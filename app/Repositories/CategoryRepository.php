<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository extends Repository
{
    /**
     * Create new instance of category repository.
     *
     * @param Category Category category model
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->category = $category;
    }

    /**
      * Get the category
      *
      * @return array json object
      */
    public function getCategories()
    {
        return $this->model->all();
    }
}