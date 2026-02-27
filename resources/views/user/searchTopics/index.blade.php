@extends('userdashboardLayout')
@section('title','Seminar/Project Topic Generator - Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('success'))
                    Success
                @elseif (session('error'))
                    Error
                @else
                    Validation
                @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>

            <div class="toast-body text-white">
                @if (session('success'))
                {{ session('success') }}
                @elseif (session('error'))
                {{ session('error') }}
                @elseif ($errors->any())
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    @endif
    <!-- PAGE TITLE -->
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Seminar / Project</span> Topic Selection
    </h4>

    <!-- STEP 1: Generate Topics Link -->
    <div class="alert alert-primary d-flex justify-content-between align-items-center">
        <div><i class="bx bx-link-external"></i> Need to generate seminar/project topics?</div>
        <a href="{{ route('user.searchTopics.create') }}" class="btn btn-outline-primary btn-sm">Generate Topics</a>
    </div>

    <!-- STEP 2: Approve Topic -->
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Select Approved Topic</h5></div>
        <form action="{{ route('user.searchTopics.approve') }}" method="POST" class="card-body">
            @csrf
            <div class="alert alert-warning">
                <i class="bx bx-info-circle"></i> From the topics you generated, select the <strong>ONE</strong> approved by your institution.
            </div>

            @forelse($userTopics as $userTopic)
            <div class="border rounded p-3 mb-3 d-flex align-items-start gap-3">
                <input class="form-check-input mt-1" type="radio" name="approved_topic" value="{{ $userTopic->id }}" id="approved{{ $loop->index }}" {{ $userTopic->status === 'approved' ? 'checked' : '' }}>
                <label class="w-100 mb-0" for="approved{{ $loop->index }}">
                    <strong>{{ $userTopic->topic->title }}</strong>
                    <span class="text-muted d-block" style="font-size:12px;">{{ ucfirst($userTopic->status) }}</span>
                </label>
            </div>
            @empty
            <p class="text-center text-muted">No topics generated yet. Please generate topics first.</p>
            @endforelse

            @if($userTopics->count() > 0)
            <button type="submit" class="btn btn-success mt-3">Submit</button>
            @endif
        </form>
    </div>

    <!-- SUBMITTED TOPICS LIST -->
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Submitted Topics</h5></div>
        <div class="card-body table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Topic Title</th>
                        <th>Type</th>
                        <th>Level</th>
                        <th>Submission Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submittedTopics as $key => $topics)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $topics->topic->title }}</td>
                        <td>{{ ucfirst($topics->topic->paper_type) }}</td>
                        <td>{{ $topics->topic->academic_level }}</td>
                        <td>{{ $topics->created_at->format('d M Y') }}</td>
                        <td>
                            @if($topics->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($topics->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(in_array($topics->status, ['submitted', 'approved']))
                                <a href="{{ route('user.searchTopics.show', $topics->id) }}" 
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No submitted topics yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
