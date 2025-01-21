<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class TeacherController extends Controller
{
    public function index(Request $request){
        // Fetch all teachers sorted by total_star in descending order
        $teachers = Teacher::orderBy('total_star', 'desc')->get();
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

        $teacher->save();

        return redirect()->back()->with('status', 'Teacher image added successfully!');
    }

    public function rate(Request $request, $id){
        // Ensure the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to rate a teacher.');
        }

        // Validate the rating
        $request->validate([
            'star' => 'required|integer|min:1|max:5',
        ]);

        $teacher = Teacher::findOrFail($id);
        $user = auth()->user();

        // Check if the user has already rated this teacher
        if ($teacher->voters()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You have already rated this teacher.');
        }

        // Add the rating to the pivot table
        $teacher->voters()->attach($user->id, ['star' => $request->star]);

        // Update the teacher's total_star and count
        $teacher->total_star += $request->star;
        $teacher->count += 1;
        $teacher->save();

        return redirect()->back()->with('success', 'Thank you for your rating!');
    }

    public function post(){
        $teachers = Teacher::find(1);
        return view('teacher.post', compact('teachers'));
    }

    public function profile($id){
        $item = Teacher::find($id);
        return view('teacher.profile', compact('item'));
    }

}
