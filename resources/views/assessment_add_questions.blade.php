<h2>Add Questions - {{ $assessment->title }} ({{ $assessment->type }})</h2>

<form action="{{ route('assessment.questions.store', $assessment->id) }}" method="POST">
    @csrf

    <div id="questionBox">
        <div class="question-item">
            <label>Question</label>
            <input type="text" name="questions[0][question]" required>

            <label>Marks</label>
            <input type="number" name="questions[0][marks]" required>

            @if($assessment->type == 'quiz')
            <div class="options-box">
                <p>Options</p>

                <input type="text" name="questions[0][options][0][text]" placeholder="Option 1">
                <input type="checkbox" name="questions[0][options][0][correct]"> Correct

                <input type="text" name="questions[0][options][1][text]" placeholder="Option 2">
                <input type="checkbox" name="questions[0][options][1][correct]"> Correct
            </div>
            @endif

            @if($assessment->type == 'true_false')
            <label>Correct Answer</label>
            <select name="questions[0][options][0][text]">
                <option value="True">True</option>
                <option value="False">False</option>
            </select>
            <input type="hidden" name="questions[0][options][0][correct]" value="1">
            @endif

        </div>
    </div>

    <button type="button" onclick="addQuestion()">+ Add Question</button>
    <button type="submit">Save Questions</button>
</form>

<script>
let i = 1;
function addQuestion() {
    let html = document.querySelector('.question-item').outerHTML;
    html = html.replaceAll('[0]', '['+i+']');
    document.querySelector('#questionBox').insertAdjacentHTML('beforeend', html);
    i++;
}
</script>
