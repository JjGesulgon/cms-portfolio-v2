<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProjectRepository;
use App\Http\Resources\ProjectResource;
use App\SamplePageImage;
use App\TechUsed;

class ProjectsController extends Controller
{
  /**
   * Project repository.
   *
   * @var App\Repositories\ProjectRepository
   */
  protected $project;

  /**
   * Create new instance of project controller.
   *
   * @param ProjectRepository project Project repository
   */
  public function __construct(ProjectRepository $project)
  {
    $this->project = $project;
  }

  /**
   * Display the first resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $project = ProjectResource::collection(
      $this->project->paginateWithFilters(request(), request()->per_page, request()->order_by)
    );

    if (! $project) {
        return response()->json([
            'message' => 'Failed to retrieve resource'
        ], 400);
    }

    return $project;
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
      'name'                      => 'required',
      'type'                      => 'required',
      'intro_image'               => 'max:2000',
      'screen_image'              => 'max:2000',
      'role'                      => 'required',
      'date_deployed'             => 'required',
      'image'                     => 'required|array',
      'tech_used'                 => 'array'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    $proj = $this->project->store($request);

    if (! $proj) {
      return response()->json([
          'message' => 'Failed to store resource'
      ], 500);
    }

    if( $request->image ){
        if(sizeof($request->image) > 0){
            for ($ctr = 0; $ctr < count($request->image); $ctr++) {
                $samplePageImage = $proj->samplePageImages()->save(new SamplePageImage(array('image' => array_values($request->image)[$ctr])));
                if (! $samplePageImage) {
                  return response()->json([
                      'message' => 'Failed to store resource'
                  ], 500);
                }

            }
        }
    }

    if( $request->tech_used ){
      if(sizeof($request->tech_used) > 0){
          for ($ctr = 0; $ctr < count($request->tech_used); $ctr++) {
              $techUsed= $proj->techUsed()->save(new TechUsed(array('tech_stack_item_id' => array_values($request->tech_used)[$ctr])));
              if (! $techUsed) {
                return response()->json([
                    'message' => 'Failed to store resource'
                ], 500);
              }
          }
      }
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
        if (! $project = $this->project->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'project' => $project
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
      'name'                      => 'required',
      'type'                      => 'required',
      'intro_image'               => 'required|max:2000',
      'screen_image'              => 'required|max:2000',
      'role'                      => 'required',
      'date_deployed'             => 'required',
      'image'                     => 'required|array',
      'tech_used'                 => 'required|array'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation failed',
        'errors'  => $validator->errors()
      ], 400);
    }

    if (! $this->project->update($request, $id)) {
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
    if (! $this->project->findOrFail($id)->delete()) {
      return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
    }

    return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
  }
}