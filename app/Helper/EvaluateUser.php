<?php
namespace App\Helper;

use App\Models\User;
use DB;

class EvaluateUser
{
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
    public function checkLineRank($user)
    {
        $rank = static::CheckRank($user);

        if ($rank != $user->user_rank_id) {
            $user->user_rank_id = $rank;
            $user->save();
        }
        $j = static::get_level($user->id, 999, 'p');

        $current_rank = 0;
        $current_rate = 0;
        foreach ($j as $k => $v) {

            $user = User::where('id', $v)->first();
            if ($user) {
                $rank = static::CheckRank($user);
                $user->user_rank_id = $rank;
                $user->save();
            }
        }
    }
    public static function CheckRank($user = 0)
    {
        $team = DB::select(DB::raw("SELECT sum(invest) as total FROM `users` WHERE jid = " . $user->id . " OR id IN (SELECT user_id FROM u_all WHERE p LIKE '%" . $user->id . "%');"));
        $team_sales = $team[0]->total;
        $rank = 0;
        $md = 0;
        $rd = 0;
        $sd = 0;
        $jd = 0;
        $member = 0;
        $refferal = DB::select(DB::raw("SELECT id ,invest FROM `users` where pid = " . $user->id . ""));
        for ($i = 0; $i < count($refferal); $i++) {
            $p = DB::select(DB::raw("SELECT count(id) as total,user_rank_id FROM `users` where id=  " . $refferal[$i]->id . " or id in (select user_id from u_all where p like '%" . $refferal[$i]->id . "%' )  group by user_rank_id  order by user_rank_id desc"));
            for ($j = 0; $j < count($p); $j++) {
                if ($p[$j]->user_rank_id == 4 && $p[$j]->total > 0) {
                    $md = $md + 1;
                    break;
                } elseif ($p[$j]->user_rank_id == 3 && $p[$j]->total > 0) {
                    $rd = $rd + 1;
                    break;
                } elseif ($p[$j]->user_rank_id == 2 && $p[$j]->total > 0) {
                    $sd = $sd + 1;
                    break;
                } elseif ($p[$j]->user_rank_id == 1 && $p[$j]->total > 0) {
                    $jd = $jd + 1;
                    break;
                }
            }

        }

        $totalrd = $md + $rd;
        $totalsd = $md + $rd + $sd;
        $totaljd = $md + $rd + $jd;

        if ($user->invest >= 300000 && $team_sales >= 30000000 && $totalrd >= 3) {
            $user->user_rank_id = 4;

        } elseif ($user->invest >= 200000 && $team_sales >= 10000000 && $totalsd >= 3) {
            $user->user_rank_id = 3;

        } elseif ($user->invest >= 100000 && $team_sales >= 2000000 && $totaljd >= 3) {
            $user->user_rank_id = 2;

        } elseif ($user->invest >= 50000 && $team_sales >= 200000) {
            $user->user_rank_id = 1;

        } else {
            $user->user_rank_id = 0;
        }

        $user->save();
    }
    public static function CheckDynamic($user = 0)
    {
        $total_sales = DB::table('users')->where([
            ['pid', '=', $user->id],
        ])->sum('invest');
        $total_invest = $user->invest + $total_sales;
        if ($total_invest >= 100000) {
            $rank = 8;

        } elseif ($total_invest >= 50000 && $total_invest < 100000) {
            $rank = 7;

        } elseif ($total_invest >= 20000 && $total_invest < 50000) {
            $rank = 6;

        } elseif ($total_invest >= 10000 && $total_invest < 20000) {
            $rank = 5;

        } elseif ($total_invest >= 5000 && $total_invest < 10000) {
            $rank = 4;

        } elseif ($total_invest >= 3000 && $total_invest < 5000) {
            $rank = 3;

        } elseif ($total_invest >= 100 && $total_invest < 3000) {
            $rank = 2;

        } else {
            $rank = 0;
        }

        if ($user->special == 0) {
            if ($rank > $user->dynamic_lv) {
                $user->dynamic_lv = $rank;
            }
        } else {
            $user->dynamic_lv = $rank;
        }

        echo 'dynamic : ' . $user->id . ' level=' . $user->dynamic_lv . ' invest=' . $user->invest . '<br>';
        $user->save();
    }
}
