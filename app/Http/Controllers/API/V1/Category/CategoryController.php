<?php

namespace App\Http\Controllers\API\V1\Category;

use App\Http\Controllers\API\ApiController;
use App\Transformers\CategoryTransformer;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')
                ->only(['index', 'show']);
        $this->middleware('transform.input:'. CategoryTransformer::class)
                ->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $categories = Category::with('products')
                        ->get();

        return $this->showAll($categories);
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
            'name'         => 'required|unique:categories',
            'description'  => 'required',
        ];
        $this->validate($request, $rules);

        $data                         = $request->all();
        $data['created_by']           = Auth::id();

        $category = Category::create($data);

        return $this->showOne($category, Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */

    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Category $category)
    {
        $rules = [
            'name'         => 'unique:categories,name,'.$category->id,
            'description'  => 'text',
        ]; 
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $messages = $validator->errors()->messages();
            return $this->errorResponse($messages, $code);
        }
        $inputs = $validator->validated();

        $category->update($inputs);

        return $this->showOne($category); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category); 
    }
}
