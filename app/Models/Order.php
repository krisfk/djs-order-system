<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public $table = 'order';
    public $timestamps = true;

    use HasFactory;

    protected $fillable = [
        'order_code',
        'order_type',
        'tel',
        'order_app',
        'order_date'
    ];


}