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
        $lessons = Lesson::where('date', $year . '-' . $month . '-' . $day)->get();
        if($lessons->isNotEmpty()) {
            $result = [];
            $result['not_empty'] = true;
            //$n = 0;
            foreach($lessons as $lesson){
                $result['array']['id'] = $lesson->id;
                $result['array']['date'] = $lesson->date;
                $result['array']['time'] = $lesson->time;
                $result['array']['paid'] = $lesson->paid;
                $result['array']['status'] = $lesson->status;
                $result['array']['cost'] = $lesson->cost;
                //$n++;
            }
            return json_encode($result);
        } else {
            $result = [];
            $result['not_empty'] = false;
            return json_encode($result);
        }
    }

    public function update(Request $request){

    }

    public function delete($id){
        
    }
}
