<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($id)
    {
        $lessons = Lesson::where('student_id', $id)
            ->get();

        return view('timetables.show', [
            'id' => $id,
            'calendar' => $this->updateCalendar($lessons),
        ]);
    }


    private function updateCalendar($lessons)
    {
        $calendar =$this->createCalendar();
        $month = substr($calendar, 20, 2);
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
               $calendar = str_replace(
                   '<td>' . $day . '</td>',
                   '<td class='. $lesson['status'] . '>' . $change_day . '</td>',
                   $calendar);
            }
        }
        return $calendar;
    }
    private function lessonData($lessons)
    {
        $result = [];
        $i = 0;
        foreach ($lessons as $lesson)
        {
            $result[$i]['id'] = $lesson->id;
            $result[$i]['date'] = substr($lesson->datetime,0, 10);
            $result[$i]['time'] = substr($lesson->datetime,11, 8);
            $result[$i]['status'] = str_replace(' ', '', $lesson->status);
            $i++;
        }
        return $result;
    }
    private function createCalendar()
    {
        $data = $this->getDateData();
        $result = "<input hidden month=" . $data['month'] . "><tr>";
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

    private function getDateData()
    {
        $months_arr = [
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
        ];
        $month = date('m', time());
        $year = date('Y');
        $weekday_first = date('w', mktime(0,0,0, $month, 1, $year));
        $result = [];
        $result['first_day'] = $weekday_first;
        $result['days'] = $months_arr[$month];
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
}
