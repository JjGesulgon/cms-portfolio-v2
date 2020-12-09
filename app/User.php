<?php

namespace App;

use App\Traits\Filtering;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Filtering, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The user has one aboutMe
     *
     * @return array object
     */
    public function aboutMe()
    {
        return $this->hasOne(AboutMe::class);
    }

    /**
     * The user has one techStackContent
     *
     * @return array object
     */
    public function techStackContent()
    {
        return $this->hasOne(TechStackContent::class);
    }

    /**
     * The user has many techStackItems
     *
     * @return array object
     */
    public function techStackItems()
    {
        return $this->hasMany(TechStackItem::class);
    }

        /**
     * The user has many passions
     *
     * @return array object
     */
    public function passions()
    {
        return $this->hasMany(Passion::class);
    }

    /**
     * The user has one contact
     *
     * @return array object
     */
    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    /**
     * The user has many projects
     *
     * @return array object
     */
    public function projects()
    {
        return $this->hasMany(Projects::class);
    }

    /**
     * The user has many samplePageImages
     *
     * @return array object
     */
    public function samplePageImages()
    {
        return $this->hasMany(SamplePageImage::class);
    }

    /**
     * The user has many TechUsed
     *
     * @return array object
     */
    public function TechUsed()
    {
        return $this->hasMany(TechUsed::class);
    }

    /**
     * The user has many blogs
     *
     * @return array object
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * The user has many blogs
     *
     * @return array object
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
