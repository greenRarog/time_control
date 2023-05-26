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

    public function read()//надо добавить фильтр по студику
    {
        $year = $_GET['year'];
        $month = $_GET['month'];
        $day = $_GET['day'];
        if(isset($_GET['time'])){
            $time = $_GET['time'];
            $lessons = Lesson::where('date', $year . '-' . $month . '-' . $day)
                            ->where('time', $time)
                            ->get();
        } else {
            $lessons = Lesson::where('date', $year . '-' . $month . '-' . $day)
                            ->get();
        }
            $result = [];
            foreach ($lessons as $lesson) {
                $result['array'][$lesson->id]['student_id'] = $lesson->student_id;//раз есть зависимость моделей, это по-идее можно убрать
                $result['array'][$lesson->id]['lesson_id'] = $lesson->id;
                $result['array'][$lesson->id]['date'] = $lesson->date;
                $result['array'][$lesson->id]['time'] = $lesson->time;
                $result['array'][$lesson->id]['paid'] = $lesson->paid;
                $result['array'][$lesson->id]['status'] = $lesson->status;
                $result['array'][$lesson->id]['cost'] = $lesson->cost;
                $result['array'][$lesson->id]['name'] = $lesson->user->name;
            }
            return json_encode($result);
    }
    public function update(Request $request){
        /*$lesson = Lesson::find($request->id);
        $lesson->student_id = $request->student_id;
        $lesson->date = $request->date;
        $lesson->time = $request->time;
        $lesson->paid = $request->paid;
        $lesson->status = $request->status;
//        $lesson->cost = $lesson->cost;
        $lesson->save();*/
        echo $request->id . ' '. $request->date . ' ' . $request->time . ' ' . 'урок был обновлен! ';
        echo $request->paid . ' = ' . $request->status;
    }

    public function delete($id){
        $lesson = Lesson::find($id);
        echo 'должен был быть удален урок id=' . $lesson->id . ' но пока не удален';
    }
}
