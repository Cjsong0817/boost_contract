<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class LevelSameBonus extends Model
{
    protected $table = 'level_same_bonus';

    protected $fillable = ['user_id', 'founds', 'wallet1', 'wallet2', 'wallet3', 'current', 'detail', 'detailen',
        'package', 'bonus_rate', 'detailin',
        'from_user', 'dis'];
    protected $appends = [
        'user',
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

}