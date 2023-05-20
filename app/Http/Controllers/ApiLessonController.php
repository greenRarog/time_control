<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use Illuminate\Http\Request;

class ApiLessonController extends Controller
{
    public function create(Request $request){
        $lesson = new Lesson;
        $lesson->date = $request->date;
        $lesson->time = $request->time;
        $lesson->paid = $request->paid;
        $lesson->status = $request->status;
        $lesson->cost = $request->cost;
        $lesson->save();

        return 'lesson create!';
    }

    public function read($year, $month, $day)
    {
        $lessons = Lesson::where('date', $year . '-' . $month . '-' . $day)->get();//надо добавить фильтр по студику
            $result = [];
            foreach ($lessons as $lesson) {
                $result['array'][$lesson->id]['student_id'] = $lesson->student_id;
                $result['array'][$lesson->id]['date'] = $lesson->date;
                $result['array'][$lesson->id]['time'] = $lesson->time;
                $result['array'][$lesson->id]['paid'] = $lesson->paid;
                $result['array'][$lesson->id]['status'] = $lesson->status;
                $result['array'][$lesson->id]['cost'] = $lesson->cost;
            }
            return json_encode($result);
    }
    public function update(Request $request){
        $lesson = Lesson::find($request->id);
        $lesson->student_id = $request->student_id;
        $lesson->date = $request->date;
        $lesson->time = $request->time;
        $lesson->paid = $request->paid;
        $lesson->status = $request->status;
        $lesson->cost = $lesson->cost;
        $lesson->save();

        return 'урок был обновлен!';
    }

    public function delete($id){

    }
}
