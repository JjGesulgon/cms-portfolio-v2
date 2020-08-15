<?php

namespace App\Repositories;

use App\TechStackItem;

class TechStackItemRepository extends Repository
{
    /**
     * Create new instance of tech stack item repository.
     *
     * @param TechStackItem Tech Stack Item techStackItem model
     */
    public function __construct(TechStackItem $techStackItem)
    {
        parent::__construct($techStackItem);
        $this->techStackItem = $techStackItem;
    }

    /**
      * Get the tech stack item
      *
      * @return array json object
      */
    public function getTechStackItem()
    {
        return $this->model->all();
    }
}