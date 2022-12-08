<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=['category_id','supplier_id','brand_id','slug','name','image','discount_price','buy_price','sale_price',
    'like_count','total_qty','view_count','description'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function color(){
        return $this->belongsToMany(Color::class,'product_color');
    }

    public function transaction(){
        return $this->hasMany(ProductAddTransaction::class);
    }
    public function cart(){
        return $this->hasMany(ProductCart::class);
        
    }
    public function order(){
        return $this->hasMany(ProductOrder::class);
    }

    public function review(){
        return $this->hasMany(ProductReview::class);
    }
    
    protected $dates= ['deleted_at'];
}
