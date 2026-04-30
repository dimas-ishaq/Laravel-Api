<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //

    // property buku, definisikan disini

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'status',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
