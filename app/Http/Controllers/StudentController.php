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
        dd(normalizeDateData('1'));
        if ($request->has('name') and $request->has('email') and $request->has('password')) {
            /*$user = New User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'student';
            $user->save();
            return redirect('/adminPanel');*/
            $time_array = [];
            foreach (WEEK_DAYS_ARR as $key => $elem) {
                if ($request->$key != 'null') {
                    $time_array[$key] = $request->$key;
                }
            }


        }
    }

    private function seekFutureWeekDay($day, $month, $year, $week_day)
    {
        $week_day_inner = date('w', mktime(0, 0, 0, $month, $day, $year));
        if ($week_day != $week_day_inner) {
            if ($week_day > $week_day_inner) {
                $day += $week_day - $week_day_inner;
            } else {
                $day += 7 - $week_day;
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
