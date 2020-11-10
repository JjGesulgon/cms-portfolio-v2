<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BlogRepository;
use App\Http\Resources\BlogResource;

use Carbon\Carbon;

class BlogsController extends Controller
{
  /**
   * Blog repository.
   *
   * @var App\Repositories\BlogRepository
   */
  protected $blog;

  /**
   * Create new instance of about controller.
   *
   * @param BlogRepository blog Blog repository
   */
  public function __construct(BlogRepository $blog)
  {
    $this->blog = $blog;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $blog = BlogResource::collection(
      $this->blog->paginateWithFilters(request(), request()->per_page, request()->order_by)
    );

    if (! $blog) {
        return response()->json([
            'message' => 'Failed to retrieve resource'
        ], 400);
    }

    return $blog;
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
      'title'         => 'required',
      'author'        => 'required',
      'content'       => 'required',
      'header_image'  => 'max:2000',
      'category_id'      => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if($request->isPublish === true){
      $request->request->add(['published_at' => Carbon::now()]);
    }

    if (! $this->blog->store($request)) {
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
        if (! $blog = $this->blog->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'blog' => $blog
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
      'title'         => 'required',
      'author'        => 'required',
      'content'       => 'required',
      'published_at'  => 'date',
      'header_image'  => 'max:2000',
      'category_id'      => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if($request->isPublish == true){
      $request->request->add(['published_at' => Carbon::now()]);
    }

    if (! $this->blog->update($request, $id)) {
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
    if (! $this->blog->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }
}