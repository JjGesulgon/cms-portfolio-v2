<?php

namespace App\Repositories;

use App\SamplePageImage;

class SamplePageImageRepository extends Repository
{
    /**
     * Create new instance of samplePageImage repository.
     *
     * @param SamplePageImage SamplePageImage samplePageImage model
     */
    public function __construct(SamplePageImage $samplePageImage)
    {
        parent::__construct($samplePageImage);
        $this->samplePageImage = $samplePageImage;
    }

    /**
      * Get all sample page item
      *
      * @return array json object
      */
    public function getSamplePageImages($id)
    {
      // return $this->model->all();
        return $this->model->where('project_id', $id)->get();
    }
}