<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Grade;

class GradesController extends Controller
{
    public function list(Request $request)
    {
        // Group grades by term
        $grades = Grade::all()->groupBy('term');

        // Calculate term-wise GPA and cumulative CGPA/CCH
        $termGPAs = [];
        $cumulative = $this->calculateCumulativeGPA($grades);

        foreach ($grades as $term => $termGrades) {
            $termGPAs[$term] = $this->calculateTermGPA($termGrades);
        }

        return view("grades.list", compact('grades', 'termGPAs', 'cumulative'));
    }

    public function edit(Request $request, Grade $grade = null)
    {
        $grade = $grade ?? new Grade();
        return view("grades.edit", compact('grade'));
    }

    public function save(Request $request, Grade $grade = null)
    {
        $grade = $grade ?? new Grade();
        $grade->fill($request->all());
        $grade->save();
        return redirect()->route('grades_list');
    }

    public function delete(Request $request, Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades_list');
    }

    // Calculate GPA for a term
    private function calculateTermGPA($grades)
    {
        $totalPoints = 0;
        $totalCH = 0;

        foreach ($grades as $grade) {
            $gradePoint = $this->getGradePoint($grade->grade);
            $totalPoints += $gradePoint * $grade->credit_hours;
            $totalCH += $grade->credit_hours;
        }

        return $totalCH > 0 ? $totalPoints / $totalCH : 0;
    }

    // Calculate Cumulative GPA and CCH
    private function calculateCumulativeGPA($grades)
    {
        $totalPoints = 0;
        $totalCH = 0;

        foreach ($grades as $termGrades) {
            foreach ($termGrades as $grade) {
                $gradePoint = $this->getGradePoint($grade->grade);
                $totalPoints += $gradePoint * $grade->credit_hours;
                $totalCH += $grade->credit_hours;
            }
        }

        return [
            'cgpa' => $totalCH > 0 ? $totalPoints / $totalCH : 0,
            'cch' => $totalCH,
        ];
    }

    // Convert grade to grade point
    private function getGradePoint($grade)
    {
        switch ($grade) {
            case 'A': return 4.0;
            case 'B': return 3.0;
            case 'C': return 2.0;
            case 'D': return 1.0;
            default: return 0.0;
        }
    }
}