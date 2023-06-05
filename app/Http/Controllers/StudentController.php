<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use App\Http\Requests\StudentCreateRequest;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function adminPanel()
    {
        $users = User::where('role', 'student')->get();
        return view('students.adminPanel', [
            'students' => $users,
        ]);
    }

    public function create()
    {
        $hours_array = ['8:00:00', '9:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00'];
        return view('students.create', [
            'hours_array' => $hours_array,
            'days_week_array' => WEEK_DAYS_ARR,
        ]);
    }

    public function createEnd(StudentCreateRequest $request)
    {
        if ($request->has('name') and $request->has('email') and $request->has('password')) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'student';
            $user->save();
            $time_array = [];
            foreach (WEEK_DAYS_ARR as $key => $elem) {
                if ($request->$key != 'null') {
                    $time_array[$key] = $request->$key;
                }
            }
            $day = date('d', time());
            $month = date('m', time());
            $year = date('Y', time());
            foreach ($time_array as $key => $time_for_lesson) {
                $lessons_array = $this->getLessonsArray($year, $month, $day, $key);
                foreach ($lessons_array as $date) {
                    $lesson = new Lesson;
                    $lesson->student_id = $user->id;
                    $lesson->date = $date['year'] . '-' . $date['month'] . '-' . $date['day'];
                    $lesson->time = $time_for_lesson;
                    $lesson->paid = false;
                    $lesson->status = 'notdone';
                    $lesson->cost = 800;
                    $lesson->save();
                }
            }
            return redirect('/adminPanel');
        }
    }

    private function getLessonsArray($year, $month, $day, $key)
    {
        $lessons_array[0] = $this->seekFutureWeekDay($year, $month, $day, $key);
        $month = $lessons_array[0]['month'];
        $year = $lessons_array[0]['year'];
        $day = $lessons_array[0]['day'];
        $i = 1;
        $lessons_array = array_merge($lessons_array, $this->cycleFillArrayLessons($year, $month, $day, $i, true));
        $i = count($lessons_array);
        $day = normalizeDateData($lessons_array[$i - 1]['day'] + 7 - MONTH_ARR[$month]);
        for ($k = 1; $k <= 1; $k++) {//k это количество месяцев на которое делаем уроки
            if ($month !== '12') {
                $month = normalizeDateData(++$month);
            } else {
                $year++;
                $month = '01';
            }
            $lessons_array = array_merge($lessons_array, $this->cycleFillArrayLessons($year, $month, $day, $i));
            $i = count($lessons_array);
            $day = normalizeDateData($lessons_array[$i - 1]['day'] + 7 - MONTH_ARR[$month]);
        }
        return $lessons_array;
    }

    private function cycleFillArrayLessons($year, $month, $day, $iterator, $boolean = false)
    {
        $lessons_array = [];
        if ($boolean) {
            $day = normalizeDateData($day + 7);
        }
        for ($iterator; $day <= MONTH_ARR[$month]; $iterator++) {
            $lessons_array[$iterator]['day'] = $day;
            $lessons_array[$iterator]['month'] = $month;
            $lessons_array[$iterator]['year'] = $year;
            $day = normalizeDateData($day + 7);
        }
        return $lessons_array;
    }

    private function seekFutureWeekDay($year, $month, $day, $week_day)
    {
        $week_day_inner = date('w', mktime(0, 0, 0, $month, $day, $year));
        if ($week_day != $week_day_inner) {
            if ($week_day > $week_day_inner) {
                $day = $day + $week_day - $week_day_inner;
            } else {
                $day = $day + 7 - $week_day;
            }
            if ($day > MONTH_ARR[$month]) {
                $day = $day - MONTH_ARR[$month];
                if ($month == '12') {
                    $month = '01';
                    $year++;
                } else {
                    $month++;
                }
            }
        } else {
            $day += 7;
        }
        $result['day'] = $day;
        $result['month'] = $month;
        $result['year'] = $year;
        return $result;
    }
}
