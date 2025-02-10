<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ScheduleController extends Controller
{
    public function index(){
        $currentTime = now(); // Get the current time
        $upcoming = Schedule::where('start_time', '>', $currentTime)
            ->orderBy('start_time', 'asc')->get();

        $running = Schedule::where('end_time', '>', $currentTime)
            ->where('start_time', '<=', $currentTime)
            ->orderBy('start_time', 'asc')
            ->get();

        $previous = Schedule::where('end_time', '<', $currentTime)
            ->orderBy('start_time', 'desc')->get();

        return view('schedule.index', compact('upcoming','running', 'previous'));
    }
    public function create($id){
        $teacher = Teacher::find($id);
        return view('schedule.create', compact('teacher'));
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'teacher_id' => 'required|exists:teachers,id',
        //     'start_time' => 'required|date|after:now',
        //     'end_time' => 'required|date|after:start_time',
        // ]);

        $schedule = new Schedule();
        $schedule->title = $request->title;
        $schedule->duration = $request->duration;
        $schedule->teacher_id = $request->teacher_id;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;

        $schedule->save();

        return redirect()->back()->with('success', 'Schedule created successfully.');
    }
}
