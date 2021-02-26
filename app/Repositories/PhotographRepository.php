<?php

namespace App\Repositories;

use App\Photograph;

class PhotographRepository extends Repository
{
    /**
     * Create new instance of photograph repository.
     *
     * @param Photograph Photograph photograph model
     */
    public function __construct(Photograph $photograph)
    {
        parent::__construct($photograph);
        $this->photograph = $photograph;
    }

    /**
      * Get the photograph
      *
      * @return array json object
      */
    public function getPhotographs()
    {
        return $this->model->all();
    }
}