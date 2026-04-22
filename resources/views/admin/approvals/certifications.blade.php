@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Certifications Management</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-xl p-4">
        <div class="overflow-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issuer</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issued</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($certs as $cert)
                    <tr data-cert-id="{{ $cert->id }}">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $cert->instructor->user->name ?? '—' }}<div class="text-xs text-gray-500">{{ $cert->instructor->user->email ?? '' }}</div></td>
                        <td class="px-4 py-3 whitespace-nowrap"><a href="{{ route('admin.approvals.certifications.show', $cert) }}" class="text-indigo-600 hover:underline">{{ $cert->title }}</a></td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $cert->issuer }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ optional($cert->issue_date)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap status-cell">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cert->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($cert->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($cert->status) }}</span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center actions-cell">
                            @if($cert->status == 'pending')
                                <form class="inline ajax-action" method="POST" action="{{ route('admin.approvals.certifications.approve', $cert) }}">
                                    @csrf
                                    <button class="btn btn-primary btn-sm approve-btn" type="submit">Approve</button>
                                </form>
                                <a href="{{ route('admin.approvals.certifications.show', $cert) }}" class="ml-2 text-sm text-indigo-600 hover:underline">Review</a>
                            @else
                                <span class="text-sm text-gray-500">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-400">No certifications found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $certs->links() }}
        </div>
    </div>
</div>
@endsection

    @section('scripts')
    <script>
    // Confirmation for approvals to avoid accidental clicks
    document.addEventListener('click', function(e){
        if (e.target && e.target.matches('.approve-btn')){
            if (!confirm('Are you sure you want to approve this certification?')){
                e.preventDefault();
                return;
            }
        }
    });

    document.addEventListener('submit', function(e){
        const form = e.target.closest('form.ajax-action');
        if (!form) return;
        e.preventDefault();

        const url = form.action;
        const certRow = form.closest('tr[data-cert-id]');

        const formData = new FormData(form);

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
            body: formData,
        }).then(res => res.json()).then(json => {
            if (json && json.success) {
                // update UI: status and actions
                if (certRow) {
                    const statusCell = certRow.querySelector('.status-cell');
                    if (statusCell) statusCell.innerHTML = '<span class="status-badge bg-green-100 text-green-800">Approved</span>';
                    const actionsCell = certRow.querySelector('.actions-cell');
                    if (actionsCell) actionsCell.innerHTML = '<span class="text-sm text-gray-500">—</span>';
                }
                showToast(json.message || 'Action completed');
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
