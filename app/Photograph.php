<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Imaging;

class Photograph extends Model
{
    use SoftDeletes, Filtering, Imaging, FilterRelationships;

    /**
     * Projects table.
     *
     * @var string
     */
    protected $table = 'photographs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'name', 'image'
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
            static::storeImage($model);
        });

        static::updating(function ($model) {
            $model->user_id = auth('api')->user()->id;
            static::updateImage($model);
        });

        static::deleting(function ($model) {
            static::deleteImage($model);
        });
    }

    /**
     * A Photograph belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
