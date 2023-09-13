@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Create Classwork')

@section('content')
<h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>Classworks</h3>
    <hr>

    <form action="{{ route('classrooms.classworks.store' , [$classroom->id , 'type' => $type]) }}" method="post" class="form-floating">
        @csrf

    <div class="row container">
        @include('Classwork.Form')
    </div>



    <button type="submit" class="btn btn-primary mx-5"> Create </button>

    </form>
@endsection
