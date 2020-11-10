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

     /**
     * Find the resource using the specified id or else fail.
     *
     * @param  int $id
     * @return json object
     */
    public function findOrFail($id)
    {
        return $this->blog->with(
            'category'
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

        return $this->blog->filter($request)
      ->with(
          'category',
      )->orderBy('created_at', $orderBy)
      ->paginate($length)
      ->withPath(
          $this->blog->createPaginationUrl($request, $removePage)
      );
    }
}
