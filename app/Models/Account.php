<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
                'tag1' ,
                'tag2' ,
                'tag3' ,
                'tag4' ,
                'account_name',
                'product_category',
                'product_type'  ,
                'activation_date'  ,
                'status'  ,
                'party_id'  ,
    ];
}
