@if(session('status'))
    <div role="status" aria-live="polite" class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
        {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div role="alert" class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif