@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classwork')

@section('content')
<div class="container">
<h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>{{ $classwork->title }} </h3>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success')}}
        </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error')}}
    </div>
@endif
    <hr>
</div>


    <div class="container">

        <p> {!! $classwork->description !!} </p>
    </div>

    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('comments.store') }}" method="post" class="form-floating">
                @csrf

                <input type="hidden" name="id" value="{{ $classwork->id }}">
                <input type="hidden" name="type" value="ClassroomWork">

                <div class="row d-flex container mx-5 px-5">
                <h4>Comments</h4>

                        <div class="form-floating mb-4 mt-3 col-md-8">
                            <input type="input" @class(['form-control', 'is-invalid' => $errors->has('content')]) id="content" name = "content" placeholder="Enter Your Comment" value={{ old('content') }}>
                            <label for="content">Comment</label>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>


                        <div class="col-md-4 my-4">
                            <button type="submit" class="btn btn-primary">Comment</button>
                        </div>
                </div>

                </form>

                <div class="mt-4 container ms-5 ">
                    @foreach ($classwork->comments as $comment )
                    {{-- $classwork->comments()->with('user')->get() => Eager load --}}
                        <div class="row container">
                            <div class="col-md-1">
                                <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}&background=random&size=55&rounded=true" alt="">
                            </div>
                            <div class="col-md-8">
                                <p>By :{{ $comment->user->name}} . Time: {{ $comment->created_at->diffForHumans(null , false, true) }}</p>
                                <p>{{ $comment->content}}</p>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>

        <div class="col-md-4">
        @can('submissions.create', [ $classwork])
            <div class="bordered rounded p-3 bg-secondary bg-gradient ">
                <h4>Submissions</h4>
                @forelse ($submissions as  $submission)
                    <ul>
                     <li><a href="{{ route('submissions.file', $submission->id) }}" class="text-white">File #{{ $loop->iteration }}</a></li>
                    </ul>
                @empty

                    <div class="row d-flex">
                        <form action="{{ route('submissions.store', $classwork->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf


                            <div class="form-floating mb-5 mt-3 col-md-8">
                                <input type="file" @class(['form-control', 'is-invalid' => $errors->has('files')]) multiple id="files" name = "files[]" placeholder="Select Files" value="">
                                <label for="files">Upload File</label>

                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                @error('files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>

                        </form>
                    </div>

                @endforelse
                @endcan
            </div>
        </div>
    </div>

@endsection
