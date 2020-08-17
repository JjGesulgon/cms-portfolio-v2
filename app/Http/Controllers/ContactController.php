<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ContactRepository;
use App\Http\Resources\ContactResource;

class ContactController extends Controller
{
  /**
   * Contact repository.
   *
   * @var App\Repositories\ContactRepository
   */
  protected $contact;

  /**
   * Create new instance of about controller.
   *
   * @param ContactRepository aboutMe AboutMe repository
   */
  public function __construct(ContactRepository $contact)
  {
    $this->contact = $contact;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (! $contact = $this->contact->getContact()) {
      return response()->json([
        'message' => 'Resource does not exist'
      ], 400);
    }

    return response()->json([
      'response' => true,
      'message'  => 'Resource successfully retrieve',
      'contact'  => $contact
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
      'content'  => 'required|min:2',
      'email'  => 'required|string|email|max:255',
      'instagram_link' => 'required|string|max:255',
      'twitter_link' => 'required|string|max:255',
      'linkedin_link' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->contact->store($request)) {
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
      'content'  => 'required|min:2',
      'email'  => 'required|string|email|max:255',
      'instagram_link' => 'required|string|max:255',
      'twitter_link' => 'required|string|max:255',
      'linkedin_link' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->contact->update($request, $id)) {
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
    if (! $this->contact->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }
}