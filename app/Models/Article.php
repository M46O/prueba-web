<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Article extends Model
{
    use HasFactory, SearchableTrait;

    protected $fillable = [
        'uid',

        'title',
        'url',

        'abstract',
        'byline',
    ];

    protected $cast = [
        'uid' => 'integer',
        'popular_date_at' => 'date'
    ];

    protected $searchable = [
        'columns' => [
            'title' => 10,
            'byline' => 7,
            'abstract' => 5
        ]
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
