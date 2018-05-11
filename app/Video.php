<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    const UPLOAD_STATUS_UPLOADED = 'uploaded';
    const UPLOAD_STATUS_CONVERTED = 'converted';
    const UPLOAD_STATUS_FAILED = 'failed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'url', 'thumbnail_url'
    ];

    public function post()
    {
        return $this->belongsTo(Article::class);
    }
}
