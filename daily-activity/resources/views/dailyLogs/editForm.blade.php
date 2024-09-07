@extends('layouts.index')
@section('content')
    <div class="container">
        <h3 class="my-3">Update Form Daily Logs</h3>
        <div class="row">
            <form action="{{ url('/editForm/' . $dailyLog->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="col card rounded shadow-sm p-3">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Employee Name</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value="{{ Auth::user()->name }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea
                                class="form-control @error('description')
                                is-invalid
                            @enderror"
                                id="exampleFormControlTextarea1" rows="3" name="description" placeholder="message...">{{ $dailyLog->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3  row">
                        <label class="col-sm-2 col-form-label">Upload Bukti Pekerjaan (opsional)</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="file" name="file">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="margin-top: 2rem">
                    <button type="button" class="btn btn-secondary mx-2">
                        <a href="{{ route('dailyLogs') }}" style="text-decoration: none; color: white">Back</a>
                    </button>
                    <button class="btn btn-primary mx-2" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
