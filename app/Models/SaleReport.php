<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReport extends Model
{
    use HasFactory;

    protected $table = 'sale_reports';

    protected $fillable = [
        'product_id',
        'quantity',
        'price',
    ];
}
