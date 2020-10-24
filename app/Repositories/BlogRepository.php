<?php

namespace App\Repositories;

use App\Blog;

class BlogRepository extends Repository
{
    /**
     * Create new instance of blog repository.
     *
     * @param Blogs Blog blog model
     */
    public function __construct(Blog $blog)
    {
        parent::__construct($blog);
        $this->blog = $blog;
    }

    /**
      * Get Blogs
      *
      * @return array json object
      */
    public function getBlogs()
    {
        return $this->model->all();
    }
}
