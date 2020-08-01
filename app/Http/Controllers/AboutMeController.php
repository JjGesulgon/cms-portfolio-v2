<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\AboutMeRepository;
use App\Http\Resources\AboutMeResource;

class AboutMeController extends Controller
{
  /**
   * Intro repository.
   *
   * @var App\Repositories\AboutMeRepository
   */
  protected $aboutMe;

  /**
   * Create new instance of about controller.
   *
   * @param AboutMeRepository aboutMe AboutMe repository
   */
  public function __construct(AboutMeRepository $aboutMe)
  {
    $this->aboutMe = $aboutMe;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (! $aboutMe = $this->aboutMe->getAbout()) {
      return response()->json([
        'message' => 'Resource does not exist'
      ], 400);
    }

    return response()->json([
      'response' => true,
      'message'  => 'Resource successfully retrieve',
      'aboutMe'  => $aboutMe
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
      'image'   => 'required|max:2000',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->aboutMe->store($request)) {
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
    if (! $aboutMe = $this->aboutMe->findOrFail($id)) {
      return response()->json([
        'message' => 'Resource does not exist'
      ], 400);
    }

    return response()->json([
      'response' => true,
      'message'  => 'Resource successfully retrieve',
      'aboutMe'  => $aboutMe
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
      'image'   => 'required|max:2000',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->aboutMe->update($request, $id)) {
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
    if (! $this->aboutMe->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }
}