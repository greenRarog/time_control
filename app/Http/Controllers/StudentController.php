<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;

class StudentController extends Controller
{
    public function adminPanel(){
        return view('students.adminPanel', [

        ]);
    }
    public function create(Request $request)
    {
    if($request->has('name') and $request->has('email') and $request->has('password')){
        echo $request->name . ' ' . $request->email . ' ' . $request->password . ' ' . $request->time . ' ' . $request->week_day;
    } else {
        $hours_array = ['8:00:00', '9:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00'];
        $days_week_array = [
            '01' => 'ПН',
            '02' => 'ВТ',
            '03' => 'СР',
            '04' => 'ЧТ',
            '05' => 'ПТ',
            '06' => 'СБ',
            '07' => 'ВСК',
        ];
        return view('students.create', [
            'hours_array' => $hours_array,
            'days_week_array' =>$days_week_array,
        ]);
    }
    }

 }
