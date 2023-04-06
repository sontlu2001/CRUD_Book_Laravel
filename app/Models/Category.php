<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function books(){
        return $this->belongsToMany(Book::class);
    }
    public function getData($perPage = 10)
    {
        $categories = $this->select('categories.*')->orderBy('created_at','desc') -> paginate($perPage);
        return $categories;
    }
    public function getAllCategories()
    {
        $category = Category::all();
        return $category;
    }
}
