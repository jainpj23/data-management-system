<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
  
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'name', 'description','price','product_image','category_id'
    ];

     /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */

    protected $dates = ['deleted_at'];

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
      

}
