<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;
    protected $fillable=['slug','name'];

    public function product(){
        return $this->belongsToMany(Product::class,'product_size');
    }
}
