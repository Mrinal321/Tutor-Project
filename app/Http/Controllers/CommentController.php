<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Request $request, $teacherId){
        // Validate input
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Insert comment into the comments table
        DB::table('comments')->insert([
            'teacher_id' => $teacherId,
            'user_id' => Auth::id(), // Optional: null if the user is not logged in
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Your comment has been posted!');
    }
}
