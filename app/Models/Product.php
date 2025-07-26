<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'tracking_number',
        'title',
        'image',
        'quantity',
        'price',
        'tracing_number',
        'serial_number',
        'module_location',
        'pcn',
        'code_input',
        'asin',            
        'fnsku', 
    ];
}
