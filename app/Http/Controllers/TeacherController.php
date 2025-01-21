<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class TeacherController extends Controller
{
    public function index(Request $request){
        $teachers = Teacher::all();
        return view('teacher.index', compact('teachers'));
    }

    public function incrementVote($id){
        // Find the teacher by ID and increment the vote count
        $teacher = Teacher::findOrFail($id);
        $teacher->increment('vote');
        return redirect()->back()->with('success', 'Vote added successfully!');
    }

    public function create(){
        return view('teacher.create');
    }

    public function store(Request $request){
        $teacher = new Teacher();
        $teacher->name = $request->input('name');
        $teacher->university = $request->input('university');
        $teacher->department = $request->input('department');
        $teacher->vote = 0;
        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/teachers/', $filename);
            $teacher->image = $filename;
        }

        $teacher->save();

        return redirect()->back()->with('status', 'Teacher image added successfully!');
    }
}
