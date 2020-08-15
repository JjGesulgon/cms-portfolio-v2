<?php

namespace App\Repositories;

use App\Passion;

class PassionRepository extends Repository
{
    /**
     * Create new instance of tech stack item repository.
     *
     * @param Passions Tech Stack Item techStackItem model
     */
    public function __construct(Passion $passion)
    {
        parent::__construct($passion);
        $this->passion = $passion;
    }

    /**
      * Get Passions
      *
      * @return array json object
      */
    public function getPassions()
    {
        return $this->model->all();
    }
}
