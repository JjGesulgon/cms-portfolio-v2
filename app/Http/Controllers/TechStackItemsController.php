<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\TechStackItemRepository;
use App\Http\Resources\TechStackItemResource;

class TechStackItemsController extends Controller
{
  /**
   * Tech Stack Item repository.
   *
   * @var App\Repositories\TeckStackItemRepository
   */
  protected $techStackItem;

  /**
   * Create new instance of about controller.
   *
   * @param TechStackItemRepository techStackItem TechStackItem repository
   */
  public function __construct(TechStackItemRepository $techStackItem)
  {
    $this->techStackItem = $techStackItem;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $techStackItem = TechStackItemResource::collection(
      $this->techStackItem->paginateWithFilters(request(), request()->per_page, request()->order_by)
    );

    if (! $techStackItem) {
        return response()->json([
            'message' => 'Failed to retrieve resource'
        ], 400);
    }

    return $techStackItem;
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
      'proficiency'   => 'required|numeric',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->techStackItem->store($request)) {
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
        if (! $techStackItem = $this->techStackItem->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'techStackItem' => $techStackItem
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
      'proficiency'   => 'required|numeric',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->techStackItem->update($request, $id)) {
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
    if (! $this->techStackItem->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }
}