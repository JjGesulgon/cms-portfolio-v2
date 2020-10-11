<?php

namespace App;

use App\Traits\FilterRelationships;
use App\Traits\Filtering;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechUsed extends Model
{
    use SoftDeletes, Filtering, FilterRelationships;

    /**
     * TechUsed table.
     *
     * @var string
     */
    protected $table = 'tech_used';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'project_id', "tech_stack_item_id"
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
     * A TechUsed belongs to a user.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A TechUsed belongs to a Project.
     *
     * @return object
     */
    public function techUsed()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * A TechUsed belongs to a TechStackItem.
     *
     * @return object
     */
    public function techStackItem()
    {
        return $this->belongsTo(TechStackItem::class);
    }
}
