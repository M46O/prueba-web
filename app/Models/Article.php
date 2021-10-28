<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',

        'title',
        'url',

        'abstract',
        'byline',

        'popular_date_at',
    ];

    protected $cast = [
        'uid' => 'integer',
        'popular_date_at' => 'date'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function highResolution()
    {
        return $this->hasOne(Image::class)->ofMany('width');
    }
}
