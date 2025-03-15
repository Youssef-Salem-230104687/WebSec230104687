<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionsController extends Controller
{
    public function list(Request $request)
    {
        $questions = Question::all();
        return view("questions.list", compact('questions'));
    }

    public function edit(Request $request, Question $question = null)
    {
        $question = $question ?? new Question();
        return view("questions.edit", compact('question'));
    }

    public function save(Request $request, Question $question = null)
    {

        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $question = $question ?? new Question();
        $question->fill($request->all());
        $question->save();
        return redirect()->route('questions_list');
    }

    public function delete(Request $request, Question $question)
    {
        $question->delete();
        return redirect()->route('questions_list');
    }

    public function startExam(Request $request)
    {
        $questions = Question::all();

        if ($questions->isEmpty()) {
            return redirect()->route('questions_list')->with('error', 'No questions available for the exam.');
        }

        return view("questions.exam", compact('questions'));
    }

    public function submitExam(Request $request)
    {
        $questions = Question::all();

        if ($questions->isEmpty()) {
            return redirect()->route('questions_list')->with('error', 'No questions available for the exam.');
        }
    
        $score = 0;
        foreach ($questions as $question) {
            if ($request->input("answer_{$question->id}") === $question->correct_answer) {
                $score++;
            }
        }

        session(['score' => $score, 'questions' => $questions]);
        
        return view("questions.result", compact('score', 'questions'));
    }

    public function viewResult(Request $request)
{
    // Retrieve the score and questions from the session
    $score = session('score');
    $questions = session('questions');

    // Check if the score and questions are available
    if (!$score || !$questions) {
        return redirect()->route('questions_exam')->with('error', 'No exam results found. Please take the exam first.');
    }

    // Return the result view
    return view('questions.result', compact('score', 'questions'));
}
}