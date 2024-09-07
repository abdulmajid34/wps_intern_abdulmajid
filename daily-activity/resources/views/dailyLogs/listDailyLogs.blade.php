@extends('layouts.index')
@section('content')
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success" style="width: 400px" role="alert">
                <div class="d-flex flex-row justify-content-between">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            </div>
        @endif
        <h1>Daily Logs</h1>
        <div class="row" style="margin-top: 3rem">
            <form action="{{ route('dailyLogs') }}">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-md-10">
                                <div>
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Select status</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <button class="btn btn-primary" type="submit">Search</button>

                        @if (Auth::user()->id !== 1)
                            <button class="btn btn-success">
                                <a href="{{ route('createForm') }}" style="color: white; text-decoration: none">
                                    Create
                                </a>
                            </button>
                        @endif


                    </div>
                </div>
            </form>



            <div class="container" style="margin-top: 5rem">
                <div class="row">
                    <table class="table">
                        <thead class="" style="background-color: #0d6efd">
                            <tr>
                                <th scope="col" class="text-start text-white">Description</th>
                                <th scope="col" class="text-start text-white">Status</th>
                                <th scope="col" class="text-start text-white">File</th>
                                <th scope="col" class="text-center text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $list)
                                <tr>
                                    <td class="text-start">{{ $list->description }}</td>
                                    @if ($list->status === 'pending')
                                        <td class="text-start badge bg-warning text-dark my-2">{{ $list->status }}</td>
                                    @elseif($list->status === 'approved')
                                        <td class="text-start badge bg-success my-2">{{ $list->status }}</td>
                                    @elseif($list->status === 'rejected')
                                        <td class="text-start badge bg-danger my-2">{{ $list->status }}</td>
                                    @endif
                                    <td class="text-start">
                                        @if ($list->file)
                                            <a href="{{ asset('storage/' . $list->file) }}" download>Download
                                                Bukti</a>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if (Auth::user()->id !== 1)
                                            <button type="button" class="btn btn-warning">
                                                <a style="text-decoration: none; color: white"
                                                    href="{{ url('/editForm/' . $list->id) }}">
                                                    Edit
                                                </a>
                                            </button>
                                            <form action="{{ url('/destroy/' . $list->id) }}" method="post"
                                                class="d-inline pl-2">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        @elseif(Auth::user()->id == 1)
                                            <form action="{{ url('/dailyLog/', [$list->id, 'approved']) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approved</button>
                                            </form>
                                            <form action="{{ url('/dailyLog/', [$list->id, 'rejected']) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Rejected</button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Employees Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $logs->links('pagination::bootstrap-4') }}
                </div>

            </div>

        </div>
    </div>
@endsection
