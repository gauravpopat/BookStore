<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class,'author_id');
    }

    public function customers()
    {
        return $this->hasManyThrough(Customer::class,Book::class,'author_id','purchased_book_id','id','id');
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class,Book::class,'author_id','book_id','id','id');
    }
}
