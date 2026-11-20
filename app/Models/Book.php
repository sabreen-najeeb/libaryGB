<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        "name",
        "ISBN",
        "category_id",
        "author",
        "publish_date",
        "publisher"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function customers(){
        return $this->belongsToMany(Customer::class, 'borrowings')
            ->withPivot('borrowing_date', 'return_date', 'is_returned');
    }
}
