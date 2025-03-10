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
        return view("questions.exam", compact('questions'));
    }

    public function submitExam(Request $request)
    {
        $score = 0;
        $questions = Question::all();
        foreach ($questions as $question) {
            if ($request->input("answer_{$question->id}") === $question->correct_answer) {
                $score++;
            }
        }
        return view("questions.result", compact('score', 'questions'));
    }
}