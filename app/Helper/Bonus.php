<?php
namespace App\Helper;

use App\Models\DynamicBonus;
use App\Models\FundTransfer;
use App\Models\LevelBonus;
use App\Models\MatchingBonus;
use App\Models\SpecialBonus;
use App\Models\StaticBonus;
use App\Models\User;
use App\Models\UserInvest;
use Carbon\Carbon;
use DB;

class Bonus
{
    public static function test()
    {
        return DynamicBonus::paginate(1);
    }
    public static function runStatic($id = 0, $max = 9999999)
    {

        $last = UserInvest::where('user_id', '>', '999999')->where('status', '=', '1')->orderBy('id', 'desc')->first();

        $last_bonus = static::static_bonus($id, $max);

        if (isset($last->id) && $last_bonus < $last->id) {

            static::runStatic($last_bonus, $last->id);
        }
    }
    public static function static_bonus($id = 0, $max = 9999999)
    {
        $rate = 0;

        $ur_list = UserInvest::where('user_id', '>', '999999')->where('status', '=', '1')->where(
            function ($query) use ($id, $max) {
                $query->where('id', '>', $id)->where('id', '<=', $max);
            })->get();

        $rate = 0;
        $yesterday = Carbon::parse(Carbon::now()->subDays(1)->format('Y-m-d 23:59:59'));
        $last = '';
        foreach ($ur_list as $k => $v) {
            $user = User::where('id', $v->user_id)->first();
            $update = array();
            if ($user->rb == 1 && $v->terminate == 0) //
            {
                if ($v->package->id <= 3) {
                    $today_rate = 'rate1';
                } elseif ($v->package->id >= 4 && $v->package->id <= 6) {
                    if ($v->price >= 10000 && $v->price < 50000) {
                        $today_rate = 'rate1';
                    } else if ($v->price >= 50000 && $v->price < 100000) {
                        $today_rate = 'rate2';
                    }
                } else {
                    if ($v->price >= 10000 && $v->price < 100000) {
                        $today_rate = 'rate1';
                    } else if ($v->price >= 100000 && $v->price < 500000) {
                        $today_rate = 'rate2';
                    } else if ($v->price >= 500000) {
                        $today_rate = 'rate3';
                    }
                }

                if ($user->profit_custom == 1 && isset($user->profit_setting)) {
                    $profit_setting = json_decode($user->profit_setting);

                    foreach ($profit_setting as $key => $value) {
                        if ($v->package_type_id == $value->id) {
                            $package = $value;
                            break;
                        }

                    }
                    $rate = $package->$today_rate;
                } else {
                    $rate = $v->package->$today_rate;

                }
                echo '<br>check rate:' . $rate . ' now id' . $v->id . '<br>';
                $rate = bcadd(($rate / 360), 0, 3);
                echo '<br>afters rate:' . $rate . ' now id' . $v->id . '<br>';
                $bonus = $v->price * $rate / 100;

                echo '<br>check bonus:' . $bonus . ' now id' . $v->id . '<br>';
                if ($bonus > 0) {
                    if ($v->get_second > 0) {
                        $earn = ($bonus / 86400) * (86400 - $v->get_second);
                    } else {
                        $earn = $bonus;
                    }
                    $today_roi = $earn + $v->today_get;
                    // $user->increase_roi($bonus);

                    $record['wallet1'] = $earn; //$bonus * (70 / 100);
                    $record['wallet2'] = 0; ///$bonus * (20 / 100);
                    $record['wallet3'] = 0; ///$bonus * (20 / 100);
                    $record['founds'] = $earn;
                    $record['user_id'] = $v->user_id;
                    $record['current'] = '+ ' . $earn;
                    $record['detail'] = $v->package->name . '资产收益' . $rate . '% ';
                    $record['detailen'] = $v->package->name . 'Asset Bonus' . $rate . '';
                    //  $record['detailin'] = $v->package->name . 'ROI Bonus' . $rate . '';
                    $record['dis'] = $v->id;
                    $record['user_invest_id'] = $v->id;
                    $record['package_type_id'] = $v->package_type_id;
                    // static::create_transaction($record['user_id'], '+', 'point3', 1000, 3, $record['wallet1'], $record['detail'], $record['detailen']);

                    //$r = static::create_transaction($record['user_id'], '+', 'point2', 1003, 3, $record['wallet2'], $record['detail'], $record['detailen']);

                    StaticBonus::create($record);

                    echo 'id:' . $v->id . ' user_id:' . $v->user_id . ' package:' . $v->price . ' rate:' . $rate . ' bonus:' . $bonus . '<br>';
                    $update['today_get'] = 0;
                    $update['get_second'] = 0;
                    $update['earn'] = $v->earn + $earn;
                    $update['profit_day'] = $v->profit_day + 1;

                    if ($update['profit_day'] >= 30) {
                        if ($user->rb_dynamic_sent == 1) {
                            static::dynamic_bonus($update['earn'], $v->user_id);
                            static::level_bonus($update['earn'], $v->user_id);
                        }

                        static::create_transaction($v->user_id, '+', 'point2', 109, 2, $update['earn'], '释放奖励', 'Release Reward');
                        $update['earn'] = 0;
                        $update['profit_day'] = 0;

                    }
                    if ($v->day >= $v->package->day) {
                        $update['status'] = 4; //到期
                    }
                    $update['total_profit'] = $v->total_profit + $earn;
                    UserInvest::where('id', $v->id)->update($update);

                }

            }

            $last = $v->id;

        }
        return $last;
    }
    public static function run_dynamic()
    {

        $roi = StaticBonus::whereDate('bonus_sent', 0)->get();

        for ($i = 0; $i < count($roi); $i++) {
            if ($roi[$i]->founds > 0 && $roi[$i]->user->rb_dynamic_sent == 1) {
                echo 'static_id :' . $roi[$i]->id . '  founds :' . $roi[$i]->founds . '<br>';
                //  static::dynamic_bonus($roi[$i]->founds, $roi[$i]->user_id);
                //     static::level_bonus($roi[$i]->founds, $roi[$i]->user_id);
                StaticBonus::where('id', $roi[$i]->id)->update(['bonus_sent' => 1]);

            }

        }
    }
    public static function dynamic_bonus($match_val = 100, $uid = 1000345)
    {
        $from = User::where('id', $uid)->first();

        $j = static::get_level($uid, 999, 'p');
        $now_lv = 1;
        $bonus_rate = explode(",", '15,10');
        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();
            //   echo $user->username . '--dynamic level-' . $user->dynamic_lv . '--now level-' . $now_lv . '<br>';
            if ($user->rb_dynamic == 1) //
            {

                echo $user->username . '--now level-' . $now_lv . '<br>';
                $rate = $bonus_rate[$now_lv - 1];

                $bonus = $match_val * $rate / 100;
                //     echo $user->username . '--dynamic level-' . $user->dynamic_lv . '--now level-' . $now_lv . '---' . $bonus . '<br>';
                if ($bonus > 0) {

                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = '第' . $now_lv . ' 代 (' . $from->username . ')获得' . $rate . '% 会员分享奖金';
                    $record['detailen'] = 'Dealer MGM Reward Of ' . $rate . '% - Level ' . $now_lv . ' (' . $from->username . ')';

                    $record['dis'] = '';
                    $record['detailin'] = 'Generasi ' . $now_lv . '  (' . $from->username . ') ' . $match_val . ' berbagi pendapatan untuk mendapatkan ' . $rate . '% pendapatan aljabar ';
                    $record['wallet2'] = $bonus;
                    $record['from_user'] = $from->username;
                    echo $user->username . $record['detail'] . '---' . $bonus . '<br>';
                    $r = DynamicBonus::create($record);
                    static::create_transaction($record['user_id'], '+', 'point4', 1002, 4, $record['wallet2'], $record['detail'], $record['detailen']);

                }
                $now_lv = $now_lv + 1;
                if ($now_lv > 2) {
                    break;
                }

            }

        }
    }
    public static function level_bonus($match_val = 100, $uid = 1000345)
    {
        $from = User::where('id', $uid)->first();

        $j = static::get_level($uid, 99, 'p');
        $rank = 0;
        $nowrate = 0;
        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();

            if ($user->rb_dynamic == 1 && $user->user_rank_id > $rank && $user->agent == 1) //
            {

                $rate = $user->rank->team - $nowrate;

                $bonus = $match_val * $rate / 100;
                if ($bonus > 0) {

                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = '(' . $from->username . ')获得' . $rate . '% 团队收益';
                    $record['detailen'] = 'Team bonus Of ' . $rate . '% -  (' . $from->username . ')';

                    $record['dis'] = '';
                    $record['detailin'] = ' (' . $from->username . ') ' . $match_val . ' berbagi pendapatan untuk mendapatkan ' . $rate . '% pendapatan aljabar ';
                    $record['wallet2'] = $bonus;
                    $record['from_user'] = $from->username;

                    echo $user->username . $record['detail'] . '-- base -' . $match_val . '-- rate-' . $rate . '---' . $bonus . '<br>';
                    $r = LevelBonus::create($record);
                    static::create_transaction($record['user_id'], '+', 'point4', 1002, 4, $record['wallet2'], $record['detail'], $record['detailen']);
                    /*if ($user->user_rank_id >= 5) {
                    static::same_level_bonus($bonus, $user->id);
                    }*/
                    //
                }
                $rank = $user->user_rank_id;
                $nowrate = $user->rank->team;
            }
            if ($rank == 4) {
                break;
            }

        }
    }
    public static function same_level_bonus($match_val = 100, $uid = 1000345)
    {
        $rate = 0;

        $from = User::where('id', $uid)->first();

        $j = static::get_level($uid, 999, 'p');
        $now = 1;
        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();
            if ($user->user_rank_id > $from->user_rank_id) {
                break;
            }
            if ($user->rb_dynamic == 1 && $from->user_rank_id == $user->user_rank_id) //
            {
                $rate = 5;
                $bonus = $match_val * $rate / 100;
                $user->increase_income($bonus);
                if ($bonus > 0) {

                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = ' (' . $from->username . ')获得' . $rate . '% 获得同级奖励';
                    $record['detailen'] = 'Same Rank Bonus ' . $rate . '% - (' . $from->username . ')';

                    $record['dis'] = '';
                    $record['detailin'] = '(' . $from->username . ') ' . $match_val . ' berbagi pendapatan untuk mendapatkan ' . $rate . '% pendapatan aljabar ';
                    $record['wallet1'] = 0;
                    $record['wallet2'] = $bonus;
                    $record['from_user'] = $from->username;
                    $record['dis'] = '';
                    echo $record['user_id'] . '---' . $record['detail'] . "<br/>";
                    static::create_transaction($record['user_id'], '+', 'point4', 1004, 4, $record['wallet2'], $record['detail'], $record['detailen']);

                    echo $user->username . $record['detail'] . '---' . $bonus . '<br>';
                    $r = LevelBonus::create($record);
                    $now = $now + 1;
                    if ($now >= 3) {
                        break;
                    }

                }

            }

        }

    }
    public static function sponsor_bonus($user_id, $price, $package)
    {
        $from = User::where('id', $user_id)->first();
        $j = static::get_level($user_id, 999, 'p');
        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();
            //   echo $user->username . '--dynamic level-' . $user->dynamic_lv . '--now level-' . $now_lv . '<br>';
            if ($user->rb_dynamic == 1 && $user->agent == 1) //
            {

                if ($package->day == 180) {
                    $rate = 5;
                } elseif ($package->day == 360) {
                    $rate = 10;
                } elseif ($package->day == 720) {
                    $rate = 15;
                }
                $bonus = $price * ($rate / 100);

                $content = '';

                $record['founds'] = $bonus;
                $record['user_id'] = $puser->id;
                $record['current'] = '+ ' . $bonus;
                $record['detail'] = '介绍人奖金' . $rate . '%(' . $from->username . ')';
                $record['detailen'] = 'Dealer introducer Bonus' . $rate . '%(' . $from->username . ')';
                $record['detailin'] = 'Dealer introducer Bonus' . $rate . '%(' . $from->username . ')';
                $record['dis'] = '';
                $record['wallet1'] = 0; //* (80 / 100);
                $record['wallet2'] = $bonus; //$bonus * (20 / 100);
                //  echo $record['user_id'] . ':' . $record['detail'] . '<br>';
                $r = SponsorBonus::create($record);
                static::create_transaction($record['user_id'], '+', 'point3', 1002, 3, $record['wallet1'], $record['detail'], $record['detailen'], $record['detailin']);
                //   static::create_transaction($record['user_id'], '+', 'point2', 1002, 2, $record['wallet2'], $record['detail'], $record['detailen']);
                break;
            }

        }

    }

    public static function special_bonus()
    {
        $total_gross = StaticBonus::whereDate('created_at', '=', Carbon::today())->sum('wallet3');
        $ur_list = User::where([
            ['rb', '=', 1],
            ['user_rank_id', '=', 3],
        ])->orderBy('id', 'asc')->get();

        if (count($ur_list) > 0) {
            $total_mib = count($ur_list);
            $bonus = (($total_gross * 0.3) * 0.05) / $total_mib;
            echo 'total gross:' . $total_gross . ' total mib:' . $total_mib . ' single bonus:' . $bonus . '<br>';
            foreach ($ur_list as $k => $v) {
                $record['founds'] = $bonus;
                $record['user_id'] = $v['id'];
                $record['current'] = '+ ' . $bonus;
                $record['detail'] = '等级奖励 ';
                $record['detailen'] = 'Rank Bonus ';
                $record['detailin'] = 'Rank Bonus ';
                $record['dis'] = '';
                $record['wallet1'] = 0;
                $record['wallet2'] = $bonus;
                $record['from_user'] = '';
                $r = SpecialBonus::create($record);

                static::create_transaction($record['user_id'], '+', 'point2', 1003, 2, $record['wallet2'], $record['detail'], $record['detailen']);

            }
        }

        /* $data['name'] = 'RUN_MATCHING';
    M('cronjob')->add($data);*/
    }

    /*public static function sponsor_bonus($uid = 1000345, $match_val = 100, $day = 180)
    {
    $from = User::where('id', $uid)->first();

    $rate = 0;
    if ($GLOBAL) {
    $etnex_price = $GLOBAL->key_value;
    }
    $j = static::get_level($uid, 9999, 'p');

    $current_rate = 0;

    foreach ($j as $k => $v) {

    $user = User::where('id', $v)->first();

    if ($user->rb == 1 && $user->rank->id > 0) //
    {
    if ($user->sponsor_rate > 0) {

    $sponsor_rate = $user->sponsor_rate;
    } else {
    // $sponsor_rate = $user->package->sponsor_rate;
    $sponsor_rate = $user->rank->sponsor;

    }

    if ($sponsor_rate > $current_rate) {

    $bonus_rate = $sponsor_rate - $current_rate;

    $bonus = bcadd(($match_val * $bonus_rate / 100), 0, 4);
    //  $bonus = $user->check_cap($bonus, 'sponsor');
    $user->increase_income($bonus);
    //  echo $user->id." rate = ".$bonus_rate." bonus = ".$bonus." current_rate = ".$current_rate." user_sponsor = ".$user->package->sponsor_rate."<br/>";
    if ($bonus > 0) {
    $record['founds'] = $bonus;
    $record['user_id'] = $user->id;
    $record['current'] = '+ ' . $bonus;
    if ($current_rate == 0) {
    $record['detail'] = '获得  (' . $from->fullname . ') ' . $match_val . ' (' . $bonus_rate . '%推荐奖励' . ')';
    $record['detailen'] = 'Gain (' . $from->fullname . ') total ' . $match_val . '  of ' . $bonus_rate . '% Sponsor bonus';
    $record['detailvn'] = 'Gain (' . $from->fullname . ') total ' . $match_val . '  of ' . $bonus_rate . '% Referral Rewards';
    } else {
    $record['detail'] = '获得  (' . $from->fullname . ') ' . $match_val . ' (' . $bonus_rate . '%推荐奖励' . ')';
    $record['detailen'] = 'Gain (' . $from->fullname . ') total ' . $match_val . '  of ' . $bonus_rate . '% Sponsor bonus';
    $record['detailvn'] = 'Gain (' . $from->fullname . ') total ' . $match_val . '  of ' . $bonus_rate . '% Sponsor bonus';
    }
    $record['wallet1'] = $bonus * 0.7;
    $record['wallet2'] = ($bonus * 0.3) / $etnex_price;
    $record['dis'] = '';
    //      echo $record['detailen'] . "<br/>";
    $r = SponsorBonus::create($record);
    static::create_transaction($record['user_id'], '+', 'point1', 1001, 1, $record['wallet1'], $record['detail'], $record['detailen']);
    static::create_transaction($record['user_id'], '+', 'point2', 1001, 2, $record['wallet2'], $record['detail'], $record['detailen']);

    }
    $current_rate = $sponsor_rate;
    }

    }
    if ($current_rate >= 10) {
    break;
    }
    }
    }*/

    public static function unilevel_bonus($uid = 1000345, $match_val = 100)
    {
        $from = User::where('id', $uid)->first();
        $j = static::get_level($uid, 99, 'p');
        $bonus = bcadd(($match_val * 0.01), 0, 3);
        $now_lv = 1;
        foreach ($j as $k => $v) {
            $user = User::where('id', $v)->first();

            if ($user->rb == 1) //
            {
                // dump($user->id);
                $bonus = bcadd(($match_val * 1 / 100), 0, 2);
                $total = DB::select('SELECT count(id)  as refferal  FROM user_package WHERE  user_id in (select id from users where pid =' . $user->id . ' ) and created_at >="' . date('Y-m-d 00:00:00', strtotime("-1 days")) . '"');

                if ($now_lv <= $total[0]->refferal && $bonus > 0) {
                    // echo $user->username . '    unilevel代数：' . $now_lv . '  今日推荐' . $total[0]->refferal . 'bonus:' . $bonus . '<br>';
                    $record['founds'] = $bonus;
                    $record['user_id'] = $user->id;
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = '第' . $now_lv . ' 代 (' . $from->fullname . ')无线团队奖励 1%';
                    $record['detailen'] = 'Get Level' . $now_lv . '(' . $from->fullname . ')  Unilevel Reward of 1% ';
                    $record['dis'] = '';
                    $record['detailvn'] = 'Generasi ' . $now_lv . '  (' . $from->fullname . ') berbagi pendapatan untuk mendapatkan 1% pendapatan aljabar ';
                    $record['wallet1'] = $bonus * (80 / 100);
                    $record['wallet2'] = $bonus * (20 / 100);

                    //echo $record['detail'] . '<br>';
                    $r = SpecialBonus::create($record);

                    static::create_transaction($record['user_id'], '+', 'point1', 1003, 1, $record['wallet1'], $record['detail'], $record['detailen']);
                    static::create_transaction($record['user_id'], '+', 'point2', 1003, 2, $record['wallet2'], $record['detail'], $record['detailen']);

                }
                $now_lv = $now_lv + 1;
                if ($now_lv > 3) {
                    break;
                }
            }
        }
    }

    public static function matching_bonus($uid = 99999)
    {
        $ur_list = User::where([
            ['id', '>', $uid],
            ['rb', '=', 1],
            ['user_group_id', '>', 0],
            ['left_point', '>', 0],
            ['right_point', '>', 0],
        ])->orderBy('id', 'asc')->get()->toArray();

        if (count($ur_list) > 0) {
            foreach ($ur_list as $k => $v) {

                if ($v['rb'] == 1) {
                    $user = User::where('id', $v['id'])->first();

                    $keep = $v["left_point"] >= $v["right_point"] ? "left_point" : "right_point";
                    $empty = $v["left_point"] >= $v["right_point"] ? "right_point" : "left_point";
                    $sb1 = $v["left_point"] >= $v["right_point"] ? $v["right_point"] : $v["left_point"];
                    $sb2 = $v["left_point"] >= $v["right_point"] ? $v["left_point"] : $v["right_point"];
                    $sbv = $sb2 - $sb1;
                    $tbv = 0;
                    $match_rate = $v['package']['matching_bonus'];
                    $bonus = $sb1 * ($match_rate / 100);

                    $bonus = $user->check_cap($bonus, 'matching');
                    $user->increase_income($bonus);

                    $data['user_id'] = $v['id'];
                    $data['get_bonus'] = $bonus;
                    $data['left_point'] = $v['left_point'];
                    $data['right_point'] = $v['right_point'];
                    $data['matching_point'] = $sb1;
                    MatchingRec::create($data);

                    $detail = "左区积分：" . $v["left_point"] . " 右区积分：" . $v["right_point"] . " 配对：" . $sb1 . "后获得" . $match_rate . "%奖励。";
                    $detailen = "Left Points：" . $v["left_point"] . " Right Points：" . $v["right_point"] . " Pairing：" . $sb1 . " Get " . $match_rate . "% Team Rewards.";
                    //   echo $v['id'] . ':' . $detailen . '<br>';
                    $record['founds'] = $bonus;
                    $record['user_id'] = $v['id'];
                    $record['current'] = '+ ' . $bonus;
                    $record['detail'] = $detail;
                    $record['detailen'] = $detailen;
                    $record['dis'] = '';
                    $record['detailin'] = $detailen;
                    $record['wallet1'] = $bonus * (70 / 100);
                    $record['wallet2'] = $bonus * (20 / 100);
                    $record['wallet3'] = $bonus * (10 / 100);
                    $r = MatchingBonus::create($record);

                    static::create_transaction($record['user_id'], '+', 'point1', 1001, 1, $record['wallet1'], $record['detail'], $record['detailen']);
                    static::create_transaction($record['user_id'], '+', 'point3', 1001, 3, $record['wallet2'], $record['detail'], $record['detailen']);
                    static::create_transaction($record['user_id'], '+', 'point4', 1001, 4, $record['wallet3'], $record['detail'], $record['detailen']);

                    //经理奖金
                    //   static::dynamic_bonus($bonus, $v['id']);
                    $user->bv = $user->bv + $sb1;
                    $user->$keep = $sbv;
                    $user->$empty = $tbv;
                    $user->save();
                }
                $last = $v['id'];
            }
        }

        /* $data['name'] = 'RUN_MATCHING';
    M('cronjob')->add($data);*/
    }

    public static function create_transaction($user_id, $act, $wallet, $found_type, $wallet_type, $amount, $detail, $detailen, $detailin = '', $detailvn = '', $detailth = '', $remark = '')
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json(false);
        }

        if ($amount < 0) {
            return response()->json(false);
        }

        if ($act == '+') {
            $add['current'] = $user->$wallet + $amount;
            $add['in_type'] = $wallet_type;

        } else {
            $add['current'] = $user->$wallet - $amount;
            $add['out_type'] = $wallet_type;
        }
        if ($add['current'] < 0) {
            return response()->json(false);
        }
        if ($amount > 0) {
            $add['previous'] = $user->$wallet;
            $add['action'] = $act;
            $add['user_id'] = $user_id;
            $add['found_type'] = $found_type;
            $add['found'] = $amount;
            $add['detail'] = $detail;
            $add['detailen'] = $detailen;
            $add['detailth'] = $detailth;
            $add['detailvn'] = $detailvn;
            $add['detailin'] = $detailin;
            $add['remark'] = $remark;
            $add['created_at'] = date("Y-m-d h:i:s");

            $r = DB::table('users')->where('id', $user_id)->update([$wallet => $add['current']]);
            $r = FundTransfer::create($add);
            return 1;
        }

    }
    public static function get_level($uid, $level, $team = 'P')
    {
        $pall = DB::table('u_all')->where('user_id', $uid)->value($team);
        $uall = explode(",", $pall);
        $gp = array();
        foreach ($uall as $kk => $v) {
            if ($v != 0) {
                if ($kk <= $level) {
                    $gp[$kk] = $v;
                }
            }
        }
        return $gp;
    }
}
