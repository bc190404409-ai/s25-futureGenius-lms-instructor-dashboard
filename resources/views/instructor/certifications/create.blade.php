@extends('layouts.app')

@section('title', 'Add Certification')
@section('page_title', 'Add Certification')

@section('content')
<div class="page-header">
    <h1> Add New Certification</h1>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2> Create Your Certification</h2>
    </div>
    <div class="card-body">
            @if($errors->any())
            <div style="background-color: #fee; border-left: 4px solid #ef4444; padding: 12px; margin-bottom: 20px; border-radius: 4px;">
                <p style="color: #991b1b; font-weight: 600; margin-bottom: 8px;"> Please fix the following errors:</p>
                <ul style="color: #991b1b; margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('certifications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label> Certification Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('title')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Issuing Organization</label>
                    <input type="text" name="issuer" value="{{ old('issuer') }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('issuer')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Certificate File (PDF, JPG, PNG)</label>
                    <input type="file" name="file"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('file')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Issue Date</label>
                    <input type="date" name="issue_date" value="{{ old('issue_date') }}" required
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('issue_date')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label> Expiry Date (Optional)</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('expiry_date')<span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>@enderror
                </div>



                <div class="card-footer">
                    <a href="{{ route('certifications.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"> Create Certification</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection