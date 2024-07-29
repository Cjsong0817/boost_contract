<?php

namespace App\Models;

use App\Models\PackageType;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class UserInvest extends Model
{
    protected $table = 'user_invest';
    protected $fillable = [
        'user_id', 'package_type_id', 'price', 'bv', 'pay', 'pay_type', 'status', 'exp_date', 'terminate', 'topup', 'extra',
    ];
    protected $appends = [
        'user', 'package', 'penalty',
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
    public function getPackageAttribute()
    {
        return PackageType::where('id', $this->package_type_id)->first();
    }
    public function getPenaltyAttribute()
    {
        if ($this->day >= 90) {
            $charges_rate = 0;
        } elseif ($this->day > 60) {
            $charges_rate = 10;
        } elseif ($this->day > 30) {
            $charges_rate = 20;
        } else {
            $charges_rate = 30;
        }
        $return['penalty_rate'] = $charges_rate;
        $charge_fee = $this->bv * $charges_rate / 100;
        $getback = $this->bv - $charge_fee;
        $return['charge_fee'] = $charge_fee;
        $return['getback'] = $getback;
        return $return;
    }

}
