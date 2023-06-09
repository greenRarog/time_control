<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonMonthController extends LessonController

{
    public function show($id)
    {
        $student = User::find($id);
        $lessons = Lesson::where('student_id', $id)
            ->get();
        $month = date('m', time());
        $year = date('Y', time());
        $next_month = normalizeDateData($month + 1);
        $before_month = normalizeDateData($month - 1);
        return view('timetables.show', [
            'id' => $id,
            'actual_calendar' => $this->updateCalendar($lessons, $month, $year, $id),
            'next_month_calendar' => $this->updateCalendar($lessons, $next_month, $year, $id),
            'before_month_calendar' => $this->updateCalendar($lessons, $before_month, $year, $id),
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
        $next_month = normalizeDateData($month + 1);
        $before_month = normalizeDateData($month - 1);
        return view('timetables.change', [
            'id' => $id,
            'actual_calendar' => $this->updateCalendar($lessons, $month, $year, $id),
            'next_month_calendar' => $this->updateCalendar($lessons, $next_month, $year, $id),
            'before_month_calendar' => $this->updateCalendar($lessons, $before_month, $year, $id),
            'student' => $student,
        ]);
    }

    private function updateCalendar($lessons, $month, $year, $id)
    {
        $calendar = $this->createCalendar($month, $year);
        foreach ($lessons as $lesson) {
            if (substr($lesson['date'], 5, 2) == $month) {
                $day = substr($lesson['date'], 8, 2);
                $change_day = substr($lesson['date'], 8, 2);
                if ($day < 10) {
                    $day = substr($day, 1, 1);
                    $change_day = substr($lesson['date'], 9, 1);
                }
                if ($lesson['paid']) {
                    $classValue = $lesson['status'] . ' ' . 'paid';
                } else {
                    $classValue = $lesson['status'] . ' ' . 'notpaid';
                }
                $calendar = str_replace(
                    '<td>' . $day . '</td>',
                    "<td class='" . $classValue . "'>" . $change_day . '</td>',
                    $calendar);
            }
        }
        $calendar = $this->getHeader($calendar, $year, $month, $id);
        return $calendar;
    }

    private function getHeader($calendar, $year, $month, $id)
    {
        return "<table tablemonth='" . $month . "' tableyear='" . $year . "' student_id='" . $id . "'>" . '<thead><tr><th>ПН</th><th>ВТ</th><th>СР</th><th>ЧТ</th><th>ПТ</th><th>СБ</th><th>ВСК</th></tr></thead><tbody>' . $calendar . '</tbody></table>';
    }

    private function createCalendar($month, $year)
    {
        $data = $this->getDateData($month, $year);
        $result = "<span class='headerMonth'>" . MONTH_NAMES[$month] . " " . $year . "</span><tr>";
        $counter = 1;
        for ($i = 1; $i < $data['first_day']; $i++) {
            $result .= '<td></td>';
            $counter++;
        }
        for ($i = 1; $i <= $data['days']; $i++) {
            $result .= '<td>' . $i . '</td>';
            if ($counter % 7 === 0) {
                $result .= '</tr><tr>';
            }
            $counter++;
        }
        $result .= '</tr>';
        return $result;
    }

    private function getDateData($month, $year)
    {
        $weekday_first = date('w', mktime(0, 0, 0, $month, 1, $year));
        $result = [];
        $result['first_day'] = $weekday_first;
        $result['days'] = MONTH_ARR[$month];
        $result['month'] = $month;
        if ($this->leap($year)) {
            $result['days'] = 29;
        }
        return $result;
    }

}
