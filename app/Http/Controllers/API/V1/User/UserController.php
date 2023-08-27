<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\API\ApiController;
use App\Transformers\UserTransformer;
use App\Mail\UserCreated;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')
                ->only(['store', 'resend']);

        $this->middleware('auth:api')
                ->except(['store', 'resend', 'verify']);

        $this->middleware('transform.input:'. UserTransformer::class)
                ->only(['store', 'update']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"User"},
     *      summary="Get users",
     *      description="Get users",
     *
     *      @OA\Parameter(
     *         name="per_page",
     *         description="Per Page, default == 5",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *
     *      @OA\Parameter(
     *         name="Localisation",
     *         description="Localisation",
     *         in="header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
    */
    public function index()
    {
        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $rules = [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);

        $data                         = $request->all();
        $data['password']             = $request->password;
        do {
            $data['verification_token'] = Str::random(64);
        } while (User::where("verification_token", "=", $data['verification_token'])->first() instanceof User);
        $data['created_by']           = Auth::id();
        $data['is_admin']             = False;

        $user = User::create($data);

        return $this->showOne($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, User $user)
    {
        $rules = [
            'first_name'    => 'string',
            'last_name'     => 'string',
            'email'         => 'email|unique:users,email,'.$user->id,
            'password'      => 'min:6|confirmed',
            'is_admin'      => 'boolean|in:0,1'
        ]; 
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $messages = $validator->errors()->messages();
            return $this->errorResponse($messages, $code);
        }
        
        $inputs = $validator->validated();

        if ($request->has('password')) {
            $inputs['password'] = $request->password;
        }
        if ($request->has('is_admin')) {
            if (!$user->isVerified()) {
                $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                $messages = "Only verified users can modify the admin field";
                return $this->errorResponse($messages, $code);
            }
            $inputs['is_admin'] = (bool)$request->is_admin;
        }
        if ($request->has('email')) {
            $inputs['email_verified_at'] = null;
            do {
                $inputs['verification_token'] = Str::random(64);
            } while (User::where("verification_token", "=", $inputs['verification_token'])->first() instanceof User);
        }

        $user->update($inputs);

        return $this->showOne($user); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user); 
    }


    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->email_verified_at = Carbon::now();
        $user->verification_token = null;
        $user->save();

        return $this->showMessage('The account has been verified successfully.');
    }

    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->errorResponse(
                'This user is already verified',
                Response::HTTP_CONFLICT
            );
        }
        $user->email_verified_at = null;
        do {
            $user->verification_token = Str::random(64);
        } while (User::where("verification_token", "=", $user->verification_token)->first() instanceof User);
        $user->save();

        retry(
            5,
            function () use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            },
            100
        );

        
        return $this->showMessage('The verification email has been resend.');
    }
}
