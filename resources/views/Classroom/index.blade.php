@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classrooms')

@section('content')
    <div class="container ">
    <h1> Classrooms </h1>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success') }}
    </div>
    @endif

<div class="row">
    @foreach ( $classroom as $classrooms )
<div class="col-md-3">
    <div class="card">
        <img src="{{$classrooms->cover_image_url }}" class="card-img-top" alt="..">
        <div class="card-body">
          <h5 class="card-title">{{$classrooms->name}}</h5>
          <p class="card-text">{{ $classrooms->section }} - {{ $classrooms->room }}</p>
            <div class="d-flex justify-content-between">
                <a href="{{ route('classrooms.show' , $classrooms->id) }}" class="btn btn-sm btn-primary">View</a>
                <a href="{{ route('classrooms.edit' , $classrooms->id) }}" class="btn btn-sm btn-dark">Edit</a>
                <a href="{{ route('classrooms.trashed' ) }}" class="btn btn-sm btn-warning">Trash</a>
                <form action="{{ route('classrooms.destroy' , $classrooms->id) }}" method="post">
                    @csrf
                    @method('delete')
                        <div >
                            <button type="submit" class="btn  btn-sm btn-danger ">Delete</button>
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
