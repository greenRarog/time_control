<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function adminView()
    {
        return view('timetables.adminView',
        [
            'last_week' => '1',
            'actual_week' => '2',
            'next_week' => '3',
        ]);
    }
    public function show($id)//month
    {
        $student = User::find($id);
        $lessons = Lesson::where('student_id', $id)
            ->get();
        $month = date('m', time());
        $year = date('Y', time());
        $next_month = $this->normalize_date_data($month + 1);
        $before_month = $this->normalize_date_data($month - 1);
        return view('timetables.show', [
            'id' => $id,
            'actual_calendar' => $this->updateCalendar($lessons, $month, $year),
            'next_month_calendar' => $this->updateCalendar($lessons, $next_month, $year),
            'before_month_calendar' => $this->updateCalendar($lessons, $before_month, $year),
            'student' => $student,
        ]);
    }
    /*public function changeAll()
    {
        $lessons = Lesson::all();
        $month = date('m', time());
        $year = date('Y', time());
        $next_month = $this->normalize_date_data($month + 1);
        $before_month = $this->normalize_date_data($month - 1);
        return view('timetables.changeAll', [
            'actual_calendar' => $this->updateCalendar($lessons, $month, $year),
            'next_month_calendar' => $this->updateCalendar($lessons, $next_month, $year),
            'before_month_calendar' => $this->updateCalendar($lessons, $before_month, $year),
        ]);
    }*/
    public function change($id) //month
    {
        $student = User::find($id);
        $lessons = Lesson::where('student_id', $id)
            ->get();
        $month = date('m', time());
        $year = date('Y', time());
        $next_month = $this->normalize_date_data($month + 1);
        $before_month = $this->normalize_date_data($month - 1);
        return view('timetables.change', [
            'id' => $id,
            'actual_calendar' => $this->updateCalendar($lessons, $month, $year),
            'next_month_calendar' => $this->updateCalendar($lessons, $next_month, $year),
            'before_month_calendar' => $this->updateCalendar($lessons, $before_month, $year),
            'student' => $student,
        ]);
    }
    private function updateCalendar($lessons, $month, $year)//month
    {
        $calendar = $this->createCalendar($month, $year);
        $date_lessons = $this->lessonData($lessons);
        foreach ($date_lessons as $lesson)
        {
            if(substr($lesson['date'], 5,2) == $month)
            {
               $day = substr($lesson['date'], 8,2);
               $change_day = substr($lesson['date'], 8,2);
               if($day < 10)
               {
                   $day = substr($day, 1,1);
                   $change_day = substr($lesson['date'], 9,1);
               }
               if($lesson['paid']){
                   $classValue = $lesson['status'] . ' ' . 'paid';
               } else {
                   $classValue = $lesson['status'] . ' ' . 'notpaid';
               }
               $calendar = str_replace(
                   '<td>' . $day . '</td>',
                   "<td class='". $classValue .  "'>" . $change_day . '</td>',
                   $calendar);
            }
        }
        $calendar = $this->getHeader($calendar);
        $calendar = str_replace(
            '<table>',
            "<table tablemonth='" . $month . "' tableyear='" . $year . "'>",
            $calendar);
        return $calendar;
    }
    private function getHeader($result)//month
    {
        return '<table><thead><tr><th>ПН</th><th>ВТ</th><th>СР</th><th>ЧТ</th><th>ПТ</th><th>СБ</th><th>ВСК</th></tr></thead><tbody>' . $result . '</tbody></table>';
    }
    private function lessonData($lessons)//это надо убрать это кривое говно
    {
        $result = [];
        $i = 0;
        foreach ($lessons as $lesson)
        {
            $result[$i]['id'] = $lesson->id;
            $result[$i]['date'] = $lesson->date;
            $result[$i]['time'] = $lesson->time;
            $result[$i]['status'] = str_replace(' ', '', $lesson->status);
            $result[$i]['paid'] = $lesson->paid;
            $i++;
        }
        return $result;
    }
    private function createCalendar($month, $year)//month
    {
        $data = $this->getDateData($month, $year);
        $result = "<span class='headerMonth'>" . self::MONTH_NAMES[$month] . " " . $year . "</span><tr>";
        $counter = 1;
        for ($i = 1; $i < $data['first_day']; $i++)
        {
            $result .= '<td></td>';
            $counter++;
        }
        for ($i = 1; $i <= $data['days']; $i++)
        {
            $result .= '<td>' . $i . '</td>';
            if($counter%7 === 0)
            {
                $result .= '</tr><tr>';
            }
            $counter++;
        }
        $result .= '</tr>';
        return $result;
    }



    private function getDateData($month, $year)
    {
        $weekday_first = date('w', mktime(0,0,0, $month, 1, $year));
        $result = [];
        $result['first_day'] = $weekday_first;
        $result['days'] = self::MONTH_ARR[$month];
        $result['month'] = $month;
        if($year%4 === 0)
        {
            if($year%100 === 0)
            {
                if($year%400 === 0)
                {
                    $result['days'] = 29;
                }
            }
        }
        return $result;
    }
    private function normalize_date_data($date_data)
    {
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
}
