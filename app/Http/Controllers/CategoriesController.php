<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoryRepository;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
  /**
   * Category repository.
   *
   * @var App\Repositories\Category
   */
  protected $category;

  /**
   * Create new instance of about controller.
   *
   * @param CategoryRepository category Category repository
   */
  public function __construct(CategoryRepository $category)
  {
    $this->category = $category;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $category = CategoryResource::collection(
      $this->category->paginateWithFilters(request(), request()->per_page, request()->order_by)
    );

    if (! $category) {
        return response()->json([
            'message' => 'Failed to retrieve resource'
        ], 400);
    }

    return $category;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'          => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->category->store($request)) {
      return response()->json([
          'message' => 'Failed to store resource'
      ], 500);
    }

    return response()->json([
      'message' => 'Resource successfully stored'
    ], 200);
  }

  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! $category = $this->category->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'category' => $category
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
    $validator = Validator::make($request->all(), [
      'name'          => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->category->update($request, $id)) {
      return response()->json([
        'message' => 'Failed to update resource'
      ], 500);
    }

    return response()->json([
      'message' => 'Resource successfully updated'
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
    if (! $this->category->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }

  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        if (! $category = $this->category->getCategories()) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'category' => $category
        ], 200);
    }
}