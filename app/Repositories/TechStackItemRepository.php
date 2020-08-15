<?php

namespace App\Repositories;

use App\TechStackItems;

class TechStackItemRepository extends Repository
{
    /**
     * Create new instance of tech stack item repository.
     *
     * @param TechStackItems Tech Stack Item techStackItem model
     */
    public function __construct(TechStackItems $techStackItem)
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
