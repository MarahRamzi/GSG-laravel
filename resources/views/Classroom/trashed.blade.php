@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Thrashed Classrooms')

@section('content')
    <div class="container ">
    <h1> Trashed Classrooms </h1>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success') }}
    </div>
    @endif

<div class="row">
    @foreach ( $classroom as $classrooms )
<div class="col-md-3">
    <div class="card">
        <img src="storage/{{ $classrooms->cover_image_path }}" class="card-img-top" alt="image">
        <div class="card-body">
          <h5 class="card-title">{{$classrooms->name}}</h5>
          <p class="card-text">{{ $classrooms->section }} - {{ $classrooms->room }}</p>
                <div class="d-flex justify-content-between">
          <form action="{{ route('classrooms.restore' , $classrooms->id) }}" method="post">
            @csrf
            @method('put')
                <div >
                    <button type="submit" class="btn  btn-sm btn-danger mt-2">Restore</button>
                </div>
            </form>
          <form action="{{ route('classrooms.force-delete' , $classrooms->id) }}" method="post">
            @csrf
            @method('delete')
                <div >
                    <button type="submit" class="btn  btn-sm btn-danger mt-2">Delete Forever</button>
                </div>
            </form>
        </div>
        </div>
      </div>
</div>
    @endforeach
</div>

    </div>

    @endsection

    @push('scripts')
   <script>console.log('@ stack')</script>
    @endpush
