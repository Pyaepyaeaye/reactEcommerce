<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable=['slug','name','mm_name','image'];
    protected $appends = ['image_url'];
    
    public function product(){
        return $this->hasMany(Product::class);
    }
    public function getImageUrlAttribute() {
        return '/images/category/'.$this->image;
    }
    
    protected $dates = ['deleted_at'];
}
