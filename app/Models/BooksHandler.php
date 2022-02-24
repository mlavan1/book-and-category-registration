<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksHandler extends Model
{
    use HasFactory;
    protected $fillable = [
        'bookName', 'categorySelector','price','author'
    ];
}
