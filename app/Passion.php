<?php

namespace App;

use App\Traits\Imaging;
use Illuminate\Database\Eloquent\Model;

class Passion extends Model
{
    use Imaging;

    /**
       * passion table.
       *
       * @var string
       */
    protected $table = 'passions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'name', 'description', 'image'
    ];

    /**
      * Run functions on boot.
      *
      * @return void
      */
    public static function boot()
    {
        parent::boot();
  
        static::updating(function ($model) {
            $model->user_id = auth('api')->user()->id;
            static::updateImage($model);
        });
    }
  
    /**
     * The passions belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
