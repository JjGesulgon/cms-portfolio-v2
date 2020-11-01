<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Imaging;
use Illuminate\Support\Str;

class Blog extends Model
{
    use SoftDeletes, Filtering, Imaging, FilterRelationships;

    /**
     * Projects table.
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'title', 'author', 'content',
      'header_image', 'slug', 'category_id',
      'published_at'
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

            static::storeImage($model, 'header_image', true);
        });
  
        static::updating(function ($model) {
            $model->user_id = auth('api')->user()->id;
            static::updateImage($model, 'header_image', true);
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
     * The user has one Category
     *
     * @return array object
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
