@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold mb-1">{{ $cert->title }}</h1>
                <p class="text-sm text-gray-600">Issued by <strong>{{ $cert->issuer }}</strong> • <span class="text-gray-500">{{ optional($cert->issue_date)->format('Y-m-d') }}</span></p>
                <p class="mt-3 text-sm">Instructor: <a href="{{ route('admin.instructors.show', $cert->instructor) }}" class="text-indigo-600 hover:underline">{{ $cert->instructor->user->name ?? '—' }}</a> &middot; <span class="text-gray-600">{{ $cert->instructor->user->email ?? '' }}</span></p>
            </div>
            <div class="text-right">
                <div class="mb-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $cert->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($cert->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($cert->status) }}</span>
                </div>
                @if($cert->file_path)
                    <a href="{{ asset('storage/' . $cert->file_path) }}" target="_blank" class="btn btn-primary btn-sm">View file</a>
                @endif

                @if($cert->status === 'rejected' && $cert->rejected_reason)
                    <div class="mt-3 text-sm text-red-700"> <strong>Rejection reason:</strong> {{ $cert->rejected_reason }}</div>
                @endif
            </div>
        </div>

        <hr class="my-6">

        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Details</h3>
            <dl class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <dt class="font-medium">Title</dt>
                    <dd>{{ $cert->title }}</dd>
                </div>
                <div>
                    <dt class="font-medium">Issuer</dt>
                    <dd>{{ $cert->issuer }}</dd>
                </div>
                <div>
                    <dt class="font-medium">Issue Date</dt>
                    <dd>{{ optional($cert->issue_date)->format('Y-m-d') }}</dd>
                </div>
                <div>
                    <dt class="font-medium">Expiry</dt>
                    <dd>{{ optional($cert->expiry_date)->format('Y-m-d') ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex items-center space-x-3">
            @if($cert->status == 'pending')
                <form method="POST" action="{{ route('admin.approvals.certifications.approve', $cert) }}">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.approvals.certifications.reject', $cert) }}" class="w-full ajax-action" data-cert-id="{{ $cert->id }}">
                    @csrf
                    <div class="flex items-center space-x-2">
                        <input type="text" name="reason" placeholder="Reason (optional)" class="border rounded px-3 py-2 w-full text-sm" />
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
                    </div>
                </form>
            @else
                <a href="{{ route('admin.approvals.certifications') }}" class="text-sm text-indigo-600 hover:underline">Back to approvals</a>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('submit', function(e){
    const form = e.target.closest('form.ajax-action');
    if (!form) return;
    e.preventDefault();

    const url = form.action;
    const formData = new FormData(form);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: formData,
    }).then(res => res.json()).then(json => {
        if (json && json.success) {
            showToast(json.message || 'Action completed');
            // redirect back to approvals index after reject/approve to show updated list
            setTimeout(()=>{ window.location.href = '{{ route('admin.approvals.certifications') }}'; }, 900);
        } else {
            showToast((json && json.message) || 'Action failed', true);
        }
    }).catch(err => {
        console.error(err);
        showToast('Request failed', true);
    });
});

function showToast(message, isError=false){
    let toast = document.createElement('div');
    toast.textContent = message;
    toast.className = 'fixed bottom-6 right-6 px-4 py-2 rounded shadow text-sm ' + (isError ? 'bg-red-600 text-white' : 'bg-green-600 text-white');
    document.body.appendChild(toast);
    setTimeout(()=>{ toast.classList.add('opacity-0'); toast.remove(); }, 3000);
}
</script>
@endsection
