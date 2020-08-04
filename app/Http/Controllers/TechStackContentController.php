<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\TechStackContentRepository;
use App\Http\Resources\TechStackContentResource;

class TechStackContentController extends Controller
{
  /**
   * Tech Stack Content repository.
   *
   * @var App\Repositories\TeckStackContentRepository
   */
  protected $techStackContent;

  /**
   * Create new instance of about controller.
   *
   * @param TechStackContentRepository techStackContent TechStackContent repository
   */
  public function __construct(TechStackContentRepository $techStackContent)
  {
    $this->techStackContent = $techStackContent;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (! $techStackContent = $this->techStackContent->getTechStackContent()) {
      return response()->json([
        'message' => 'Resource does not exist'
      ], 400);
    }

    return response()->json([
      'response' => true,
      'message'  => 'Resource successfully retrieve',
      'techStackContent'  => $techStackContent
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
    $validator = Validator::make($request->all(), [
      'body'  => 'required|min:2',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->techStackContent->store($request)) {
      return response()->json([
          'message' => 'Failed to store resource'
      ], 500);
    }

    return response()->json([
      'message' => 'Resource successfully stored'
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
      'body'    => 'required|min:2',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->techStackContent->update($request, $id)) {
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
    if (! $this->techStackContent->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }
}