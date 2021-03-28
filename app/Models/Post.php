<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int user_id
 * @property mixed title
 * @property mixed message
 * @method static where(string $string, string $string1, $id)
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 */
class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'message',
        'post_image',
    ];

    /**
     * Get the user that is assigned to the product.
     *
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function getCommentsCountAttribute(){
        return $this->comment()->count();
    }
}
