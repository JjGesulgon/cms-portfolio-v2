<?php

namespace App\Repositories;

use App\AboutMe;

class AboutRepository extends Repository
{
  /**
   * Create new instance of about repository.
   *
   * @param AboutMe About about model
   */
  public function __construct(AboutMe $aboutMe)
  {
    parent::__construct($aboutMe);
    $this->aboutMe = $aboutMe;
  }

  /**
    * Get the about me
    *
    * @return array json object
    */
  public function getAboutMe()
  {
    return $this->model->first();
  }
}