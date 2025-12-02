<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionOption;

class QuestionOptionController extends Controller
{
    // Show all options for a question
    public function index(Question $question)
    {
        $options = $question->options()->get();

        return view('instructor.options.index', compact('question', 'options'));
    }

    // Show form to create a new option
    public function create(Question $question)
    {
        return view('instructor.options.create', compact('question'));
    }

    // Store a new option
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $question->options()->create($request->all());

        return redirect()->route('instructor.assessments.questions.options.index', $question->id)
            ->with('success', 'Option added successfully!');
    }

    // Show form to edit an option
    public function edit(Question $question, QuestionOption $option)
    {
        return view('instructor.options.edit', compact('question', 'option'));
    }

    // Update an option
    public function update(Request $request, Question $question, QuestionOption $option)
    {
        $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $option->update($request->all());

        return redirect()->route('instructor.assessments.questions.options.index', $question->id)
            ->with('success', 'Option updated successfully!');
    }

    // Delete an option
    public function destroy(Question $question, QuestionOption $option)
    {
        $option->delete();

        return redirect()->route('instructor.assessments.questions.options.index', $question->id)
            ->with('success', 'Option deleted successfully!');
    }
}
