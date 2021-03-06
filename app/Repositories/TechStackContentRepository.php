<?php

namespace App\Repositories;

use App\TechStackContent;

class TechStackContentRepository extends Repository
{
    /**
     * Create new instance of techStackItem repository.
     *
     * @param TechStackContent Tech Stack Item techStackItem model
     */
    public function __construct(TechStackContent $techStackContent)
    {
        parent::__construct($techStackContent);
        $this->techStackContent = $techStackContent;
    }

    /**
      * Get the tech stack content
      *
      * @return array json object
      */
    public function getTechStackContent()
    {
        return $this->model->first();
    }
}
