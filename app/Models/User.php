<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static findOrFail(int $id)
 * @method static find(int $id)
 * @method static where(string $string, $name)
 * @method static whereId(int $id)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'about',
        'email',
        'password',
        'gender_id',
        'user_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function gender() {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Get all of the products for the user.
     */
    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function getPostsCountAttribute(){
        return $this->post()->count();
    }

    public function getCommentsCountAttribute(){
        return $this->comment()->count();
    }
}
