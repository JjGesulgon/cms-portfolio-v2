<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Imaging;
use Illuminate\Support\Str;

class Project extends Model
{
    use SoftDeletes, Filtering, Imaging;

    /**
     * Projects table.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'name', 'type', 'intro_image',
      'screen_image', 'role', 'date_deployed', 
      'overview', 'concept_description',
      'development_description', 'github_repository',
      'live', 'slug', 'reason_if_unavailable'
    ];

    /**
       * Run functions on boot.
       *
       * @return void
       */
      public static function boot()
      {
          parent::boot();
  
          static::creating(function ($model) {
              $model->user_id = auth('api')->user()->id;
              $model->slug = Str::slug($model->name . '-' . random_int(100, 999));

              static::storeImage($model, 'intro_image');
              static::storeImage($model, 'screen_image');
          });
  
          static::updating(function ($model) {
              $model->user_id = auth('api')->user()->id;
              static::updateImage($model, 'intro_image');
              static::updateImage($model, 'screen_image');
          });

          static::deleting(function ($model) {
            static::deleteImage($model);
        });
      }

    /**
       * A Project belongs to a user.
       *
       * @return object
       */
      public function user()
      {
          return $this->belongsTo(User::class);
      }

    /**
     * A Project has many samplePageImages
     *
     * @return array object
     */
    // public function techStackItems()
    // {
    //     return $this->hasMany(TechStackItems::class);
    // }
}
