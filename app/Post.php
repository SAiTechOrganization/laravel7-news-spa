<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const LIMIT_PER_RUQUEST = 10;
    const FETCH_TYPE_RECENT = 'recent';
    const FETCH_TYPE_PAST   = 'past';

    protected $fillable = [
        'title',
        'body',
        'thumbnail'
    ];

    public function fetchPosts($fetch_type, $ref_id) {

        $posts = $this->take(self::LIMIT_PER_RUQUEST);

        if ($fetch_type === self::FETCH_TYPE_RECENT) {
            if (is_numeric($ref_id) && (int)$ref_id === 0) {
                return $posts->orderBy(self::CREATED_AT, 'desc')
                             ->get();
            }

            if (is_numeric($ref_id) && (int)$ref_id > 0) {
                return $posts->orderBy(self::CREATED_AT, 'asc')
                             ->where('id', '>', $ref_id)
                             ->get();
            }
        }

        if (is_numeric($ref_id) && (int)$ref_id > 0) {
            return $posts->orderBy('created_at', 'desc')
                         ->where('id', '<', $ref_id)
                         ->get();
        }

        return [];
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
