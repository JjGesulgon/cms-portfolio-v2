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
}