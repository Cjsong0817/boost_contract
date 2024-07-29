<?php

namespace App\Models;

use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    protected $table = 'package_type';

    protected $fillable = [
        'name',
        'name_en',
        'price',
        'status',
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    protected $appends = [

    ];

}
