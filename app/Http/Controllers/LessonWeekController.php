<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonWeekController extends LessonController
{
    public function adminView()
    {
        $year = date('Y', time());
        $month = date('m', time());
        $day = date('d', time());
        if(isset($_GET['inc'])) {//это для будущего перелистывания календаря неделя вперед - неделя назад
//            $day = $day + $_GET['inc'] * 7;
        }

        $weeks = $this->last_actual_next_week_create($day, $month, $year);

        return view('timetables.adminView',
            [
                'last_week' => $this->get_week($weeks['last']),
                'actual_week' => $this->get_week($weeks['actual']),
                'next_week' => $this->get_week($weeks['next']),
            ]);
    }
    private function last_actual_next_week_create($day, $month, $year)//week
    {
        $result = [];
        $month = normalize_date_data($month);
        $day = normalize_date_data($day);
        $result['actual']['day'] = $day;
        $result['actual']['month'] = $month;
        $result['actual']['year'] = $year;
        if ($day < 7){
            if($month === '01'){
                $result['last']['year'] = $year - 1;
                $result['last']['month'] = '12';
                $result['last']['day'] = normalize_date_data(MONTH_ARR['12'] - 7 + $day);
            } else {
                $result['last']['month'] = normalize_date_data($month - 1);
                $result['last']['year'] = $year;
                $result['last']['day'] = normalize_date_data(MONTH_ARR[$month - 1] - 7 + $day);
            }
        } else {
            $result['last']['year'] = $year;
            $result['last']['month'] = $month;
            $result['last']['day'] = normalize_date_data($day - 7);
        }
        if($month == 12) {
            if (($day + 7) > MONTH_ARR[$month]) {
                $result['next']['day'] = normalize_date_data(MONTH_ARR[$month] - $day);
                $result['next']['month'] = '01';
                $result['next']['year'] = $year + 1;
            } else {
                $result['next']['day'] = normalize_date_data($day + 7);
                $result['next']['month'] = normalize_date_data($month);
                $result['next']['year'] = $year;
            }
        } else {
            $result['next']['year'] = $year;
            if (($day + 7) > MONTH_ARR[$month]) {
                $result['next']['day'] = normalize_date_data(MONTH_ARR[$month] - $day + 7);
                $result['next']['month'] = normalize_date_data($month + 1);
            } else {
                $result['next']['day'] = normalize_date_data($day + 7);
                $result['next']['month'] = $month;
            }
        }
        return $result;
    }
    private function get_week($array)//week
    {
        $day = $array['day'];
        $month = $array['month'];
        $year = $array['year'];
        $table = "<table class='week_table'>";
        $week_day = date('w', mktime(0,0,0, $month, $day, $year));
        $monday = $day + (1 - $week_day);
        if($monday < 0){
            if($month > 1) {
                $month = normalize_date_data($month - 1);
            } else {
                $month = '12';
                $year = $year--;
            }
            $monday = MONTH_ARR[$month] + $monday;
        }
        for($i = 1; $i <= 7; $i++)
        {
            if(($monday + $i - 1) > MONTH_ARR[$month]){
                if($month > 1){
                    $month = normalize_date_data($month + 1);
                } else {
                    $month = '12';
                    $year = $year--;
                }
                $monday = 2 - $i;
            }
            $table .= '<tr><th>' . WEEK_DAYS_ARR[$i] . '<br>' . ($monday + $i - 1) . '.' . $month . '</th>';
            $table .= $this->get_day_fill($year, $month, (normalize_date_data($monday + $i - 1))) . '</tr>';
        }

        $table .='</table>';
        return $table;
    }

    private function get_day_fill($year, $month, $day)//week
    {
        $date = $year .  '-' . $month . '-' . $day;
        $lessons = Lesson::where('date', $date)->get();
        $result = "<th><table>";
        foreach($lessons as $lesson){
            if($lesson->paid) {
                $class = $lesson->status . ' paid';
            } else {
                $class = $lesson->status . ' notpaid';
            }
            $result .= "<tr><td class='" . $class . "' year='" . $year . "' month='" . $month. "' day='" . $day . "'>" . $lesson->time . ' ученик ' . $lesson->user->name . '</td></tr>';
        }
        $result .= '</table></th>';
        return $result;
    }
}
