<?php

namespace App\Repositories;

use App\Project;

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