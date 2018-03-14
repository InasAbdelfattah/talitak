<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Relation;

// Relation:morphMap([
//     'posts'=> 'App\Post',
// ]);

class Comment extends Model
{
    /**
     * @var array
     * @ $fillable array of available varible to display.
     */
    protected $fillable = [
        'parent_id', 'commentable_id', 'commentable_type', 'comment', 'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }


    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }


    public function scopeById($query, $id)
    {
        if ($id != '') {
            $query->where('id', $id);
        }
        return $query->first();
    }

}
