<?php

namespace App;

use App\Traits\Filtering;
use App\Traits\FilterRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

    /**
     * TechStackItem table.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'name'
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
        });
  
        static::updating(function ($model) {
            $model->user_id = auth('api')->user()->id;
        });
    }
  
    /**
     * The category belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The category belongs to a blog.
     *
     * @return object
     */
    public function blog()
    {
        return $this->hasMany(Blog::class);
    }
}
