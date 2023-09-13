@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Update Classwork')

@section('content')
<div class="container">
<h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>Update Classwork </h3>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success')}}
        </div>
    @endif
</div>
    <hr>
    <form action="{{ route('classrooms.classworks.update' , [$classroom->id , $classwork->id]) }}" method="post" class="form-floating">
    @csrf
    @method('put')
    <div class="row container">
        @include('Classwork.Form')
    </div>

    <button type="submit" class="btn btn-primary mx-5"> Update </button>

    </form>
@endsection
