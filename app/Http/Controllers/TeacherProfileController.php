<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class TeacherProfileController extends Controller
{
    public function create(){
        return view('teacher.create');
    }

    public function store(Request $request){
        // Check if the user already has a teacher profile
        $existingTeacher = Teacher::where('user_teacher_id', auth()->id())->first();

        if ($existingTeacher) {
            return redirect()->back()->with('error', 'You can only create one teacher profile.');
        }

        $teacher = new Teacher();
        $teacher->name = $request->input('name');
        $teacher->university = $request->input('university');
        $teacher->department = $request->input('department');
        $teacher->total_star = 0;
        $teacher->count = 0;
        $teacher->vote = 0;
        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/teachers/', $filename);
            $teacher->image = $filename;
        }

        $teacher->user_teacher_id = auth()->id();
        $teacher->save();

        return redirect()->back()->with('status', 'Teacher image added successfully!');
    }

    public function profile($id){
        $item = Teacher::find($id);
        return view('teacher.profile', compact('item'));
    }

    public function edit(Request $request, $id){
        $teacher = Teacher::find($id);
        return view('teacher.edit', compact('teacher'));
    }

    public function update(Request $request){
        $teacher = Teacher::find($request->id);

        $teacher->name = $request->input('name');
        $teacher->university = $request->input('university');
        $teacher->department = $request->input('department');
        $teacher->total_star = 0;
        $teacher->count = 0;
        $teacher->vote = 0;
        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/teachers/', $filename);
            $teacher->image = $filename;
        }

        $teacher->user_teacher_id = auth()->id();
        $teacher->save();

        return redirect()->route('index');
    }


}
