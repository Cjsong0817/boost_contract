<?php

namespace App\Models;

use App\Models\PackageType;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class UserInvestRec extends Model
{
    protected $table = 'user_invest_rec';
    protected $fillable = [
        'user_id', 'package_type_id', 'price', 'bv', 'pay', 'pay_type', 'action_type', 'action_at', 'extra',
    ];
    protected $appends = [
        'user', 'package', 'action_remark',
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
    public function getActionRemarkAttribute()
    {
        if ($this->action_type == 1) {
            return 'PURCHASE';
        } elseif ($this->action_type == 3) {
            return 'TOPUP';
        } elseif ($this->action_type == 2) {
            return 'SURRENDER';
        }
    }
}
