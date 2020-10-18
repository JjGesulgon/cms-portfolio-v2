<?php

namespace App\Repositories;

use App\Project;
use App\SamplePageImage;
use App\TechUsed;

use Illuminate\Support\Facades\DB;

class ProjectRepository extends Repository
{
    /**
     * Create new instance of project repository.
     *
     * @param Project Projects project model
     */
    public function __construct(Project $project)
    {
        parent::__construct($project);
        $this->project = $project;
    }

    /**
      * Get the Projects
      *
      * @return array json object
      */
    public function getProjects()
    {
        return $this->model->all();
    }

    /**
     * Store the data in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $project =  $this->project->create($request->all());

            if ($request->image) {
                if (sizeof($request->image) > 0) {
                    for ($ctr = 0; $ctr < count($request->image); $ctr++) {
                        $samplePageImage = $project->samplePageImages()->save(new SamplePageImage(array('image' => array_values($request->image)[$ctr])));
                        if (! $samplePageImage) {
                            return response()->json([
                            'message' => 'Failed to store resource'
                        ], 500);
                        }
                    }
                }
            }

            if ($request->tech_used) {
                if (sizeof($request->tech_used) > 0) {
                    for ($ctr = 0; $ctr < count($request->tech_used); $ctr++) {
                        $techUsed= $project->techUsed()->save(new TechUsed(array('tech_stack_item_id' => array_values($request->tech_used)[$ctr])));
                        if (! $techUsed) {
                            return response()->json([
                            'message' => 'Failed to store resource'
                        ], 500);
                        }
                    }
                }
            }

            return $project;
        });
    }

    /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
    public function update($request, $id)
    {
        try {
          
            return DB::transaction(function () use ($request, $id) {
                $project = $this->project->findOrFail($id);
                $project->fill($request->all());
                $project->save();

                $project->techUsed()->delete();

                if ($request->tech_used) {
                    if (sizeof($request->tech_used) > 0) {
                        for ($ctr = 0; $ctr < count($request->tech_used); $ctr++) {
                            $techUsed = $project->techUsed()->save(new TechUsed(array('tech_stack_item_id' => array_values($request->tech_used)[$ctr])));
                            if (! $techUsed) {
                                return response()->json([
                      'message' => 'Failed to store resource'
                  ], 500);
                            }
                        }
                    }
                }

                return $project;
            });

        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Find the resource using the specified id or else fail.
     *
     * @param  int $id
     * @return json object
     */
    public function findOrFail($id)
    {
        return $this->project->with(
            'samplePageImages',
            'techUsed',
            'techUsed.techStackItem'
        )->findOrFail($id);
    }

    /**
     * Create pagination with filters for the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $orderBy
     * @param  integer                   $length
     * @param  boolean                   $removePage
     * @return array json object
     */
    public function paginateWithFilters(
        $request = null,
        $length = 15,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        return $this->project->filter($request)
      ->with(
          'samplePageImages',
      )->orderBy('created_at', $orderBy)
      ->paginate($length)
      ->withPath(
          $this->project->createPaginationUrl($request, $removePage)
      );
    }
}
