<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function leap($year){
        $flag = false;
        if($year%4 === 0)
        {
            if($year%100 === 0)
            {
                if($year%400 === 0)
                {
                    $flag = true;
                }
            }
        }
        return $flag;
    }
    public function normalize_date_data($date_data)
    {
        $date_data = (int)$date_data;
        if($date_data < 10) {
            return '0' . $date_data;
        } else {
            return $date_data;
        }
    }
    const MONTH_ARR = [
            '01' => 31,
            '02' => 28,
            '03' => 31,
            '04' => 30,
            '05' => 31,
            '06' => 30,
            '07' => 31,
            '08' => 31,
            '09' => 30,
            '10' => 31,
            '11' => 30,
            '12' => 31,
            1 => 31,
            2 => 28,
            3 => 31,
            4 => 30,
            5 => 31,
            6 => 30,
            7 => 31,
            8 => 31,
            9 => 30,
            10 => 31,
            11 => 30,
            12 => 31,
        ];
    const MONTH_NAMES = [
        '01' => 'январь',
        '02' => "февраль",
        '03' => "март",
        '04' => "апрель",
        '05' => "май",
        '06' => "июнь",
        '07' => "июль",
        '08' => "август",
        '09' => "сентябрь",
        '10' => "октябрь",
        '11' => "ноябрь",
        '12' => "декабрь",
        1 => "январь",
        2 => "февраль",
        3 => "март",
        4 => "апрель",
        5 => "май",
        6 => "июнь",
        7 => "июль",
        8 => "август",
        9 => "сентябрь",
        10 => "октябрь",
        11 => "ноябрь",
        12 => "декабрь",
    ];
    const WEEK_DAYS_ARR = [
      1 => 'ПН',
      2 => 'ВТ',
      3 => 'СР',
      4 => 'ЧТ',
      5 => 'ПТ',
      6 => 'СБ',
      7 => 'ВСК',
    ];
}
