<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonMonthController extends LessonController
//не хочется сейчас разбираться, есть проблемы:
//не подкидываются css
//нужно переделать в js запрос к api на get (параметры были в url)
//нужно докрутить в контроллер отбор по студику
//

{
    public function show($id)
    {
        $student = User::find($id);
        $lessons = Lesson::where('student_id', $id)
            ->get();
        $month = date('m', time());
        $year = date('Y', time());
        $next_month = parent::normalize_date_data($month + 1);
        $before_month = parent::normalize_date_data($month - 1);
        return view('timetables.show', [
            'id' => $id,
            'actual_calendar' => $this->updateCalendar($lessons, $month, $year),
            'next_month_calendar' => $this->updateCalendar($lessons, $next_month, $year),
            'before_month_calendar' => $this->updateCalendar($lessons, $before_month, $year),
            'student' => $student,
        ]);
    }
    public function change($id)
    {
        $student = User::find($id);
        $lessons = Lesson::where('student_id', $id)
            ->get();
        $month = date('m', time());
        $year = date('Y', time());
        $next_month = parent::normalize_date_data($month + 1);
        $before_month = parent::normalize_date_data($month - 1);
        return view('timetables.change', [
            'id' => $id,
            'actual_calendar' => $this->updateCalendar($lessons, $month, $year),
            'next_month_calendar' => $this->updateCalendar($lessons, $next_month, $year),
            'before_month_calendar' => $this->updateCalendar($lessons, $before_month, $year),
            'student' => $student,
        ]);
    }
    private function updateCalendar($lessons, $month, $year)
    {
        $calendar = $this->createCalendar($month, $year);
        foreach ($lessons as $lesson)
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
/*    private function lessonData($lessons)//это надо убрать это кривое говно
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
    }*/
    private function createCalendar($month, $year)
    {
        $data = $this->getDateData($month, $year);
        $result = "<span class='headerMonth'>" . parent::MONTH_NAMES[$month] . " " . $year . "</span><tr>";
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
        $result['days'] = parent::MONTH_ARR[$month];
        $result['month'] = $month;
        if ($this->leap($year)){
            $result['days'] = 29;
        }
        return $result;
    }

}
