<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserPackage;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class UserQuit extends Model
{
    protected $table = 'user_quit';
    protected $fillable = [
        'user_id', 'user_package_id', 'price', 'get_amount', 'fee', 'day', 'status',
    ];
    protected $appends = [
        'user', 'user_package',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    public function getUserAttribute()
    {
        $user = User::where('id', $this->user_id)->first();
        return $user ? $user : null;

    }
    public function getUserPackageAttribute()
    {
        return UserPackage::where('id', $this->user_package_id)->first();
    }
}
