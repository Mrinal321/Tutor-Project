<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilterController extends Controller
{
    public function university(){
        $teachers2 = Teacher::all();
        $universities = Teacher::select('university')->distinct()->pluck('university');

        $teachersByUniversity = [];

        foreach ($universities as $university) {
            $teachersByUniversity[$university] = Teacher::where('university', $university)
                ->paginate(3, pageName: Str::snake($university)); // Unique pagination for each university
        }

        return view('filter.university', compact('teachersByUniversity', 'teachers2'));
    }

    public function department(){
        $teachers2 = Teacher::all();
        $departments = Teacher::select('department')
            ->distinct()
            ->pluck('department'); // Get a list of unique universities

        $teachersByDepartment = [];

        foreach ($departments as $department) {
            $teachersByDepartment[$department] = Teacher::where('department', $department)
                ->paginate(3, pageName: Str::snake($department)); // Paginate within each university
        }

        return view('filter.department', compact('teachersByDepartment', 'teachers2'));
    }

}
