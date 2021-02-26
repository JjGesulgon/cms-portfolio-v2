<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PhotographRepository;
use App\Http\Resources\PhotographResource;

class PhotographsController extends Controller
{
  /**
   * Photograph repository.
   *
   * @var App\Repositories\Photograph
   */
  protected $photograph;

  /**
   * Create new instance of about controller.
   *
   * @param PhotographRepository photograph Photograph repository
   */
  public function __construct(PhotographRepository $photograph)
  {
    $this->photograph = $caphotographtegory;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $photograph = PhotographResource::collection(
      $this->photograph->paginateWithFilters(request(), request()->per_page, request()->order_by)
    );

    if (! $photograph) {
        return response()->json([
            'message' => 'Failed to retrieve resource'
        ], 400);
    }

    return $photograph;
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
      'image'         => 'required|max:2000'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->photograph->store($request)) {
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
        if (! $photograph = $this->photograph->findOrFail($id)) {
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

    if (! $this->photograph->update($request, $id)) {
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
    if (! $this->photograph->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }
}