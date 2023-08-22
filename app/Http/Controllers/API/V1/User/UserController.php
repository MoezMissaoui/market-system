<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{


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

        return response()->json([
            'data' => $users
        ], 200);
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

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $data = $validator->errors()->messages();
            return response()->json([
                'data' => $data
            ], $code);
        }


        $data                         = $request->all();
        $data['password']             = Crypt::encryptString($request->password);
        $data['email_verified_at']    = now();
        $data['created_by']           = Auth::id();
        $data['is_admin']             = False;

        $user = User::create($data);

        return response()->json([
            'data' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $rules = [
            'first_name'    => 'string',
            'last_name'     => 'string',
            'email'         => 'email|unique:users,email,'.$id,
            'password'      => 'min:6|confirmed',
            'is_admin'      => 'boolean|in:0,1'
        ]; 
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $data = $validator->errors()->messages();
            return response()->json([
                'data' => $data
            ], $code);
        }
        $inputs = $validator->validated();

        $user = User::findOrFail($id);
        if ($request->has('password')) {
            $inputs['password'] = Crypt::encryptString($request->password);
        }
        if ($request->has('is_admin')) {
            if (!$user->has_verified_email()) {
                return response()->json([
                    'error' => "Only verified users can modify the admin field",
                    'code'  => 409,
                ], 409);
            }
            $inputs['is_admin'] = (bool)$request->is_admin;
        }
        $user->update($inputs);

        return response()->json([
            'data' => $user
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'data' => null
        ], 200); 
    }
}