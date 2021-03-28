<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed message
 * @property  int user_id
 * @property  int post_id
 * @property string comment_image
 * @method static create(Comment $comment)
 * @method static findOrFail(int $id)
 * @method static where(string $string, string $string1, $id)
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'comment_image',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
