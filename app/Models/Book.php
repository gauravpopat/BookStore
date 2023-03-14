<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author_id',
        'price'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class,'purchased_book_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
