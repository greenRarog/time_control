<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class ApiLessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($month, $day, $year)
    {
        $lesson = Lesson::where('date', $year . '-' . $month . '-' . $day);

        return json_encode([
            'id' => $lesson->id,
            'date' => substr($lesson->datetime, 0,10),
            'time' => substr($lesson->datetime, 11, 8),
            'paid' => $lesson->paid,
            'status' => $lesson->status,
            'cost' => $lesson->cost,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
