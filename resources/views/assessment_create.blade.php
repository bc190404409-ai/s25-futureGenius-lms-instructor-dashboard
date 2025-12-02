<h2>Create Assessment for {{ $course->title }}</h2>

<form action="{{ route('assessment.store') }}" method="POST">
    @csrf

    <input type="hidden" name="course_id" value="{{ $course->id }}">

    <label>Assessment Title</label>
    <input type="text" name="title" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <label>Assessment Type</label>
    <select name="type" id="assessmentType" required>
        <option value="quiz">Quiz (MCQs)</option>
        <option value="assignment">Assignment (File Upload)</option>
        <option value="lab">Lab Task</option>
        <option value="true_false">True / False</option>
    </select>

    <label>Total Marks</label>
    <input type="number" name="total_marks" required>

    <label>Due Date</label>
    <input type="datetime-local" name="due_date">

    <button type="submit">Next</button>
</form>
