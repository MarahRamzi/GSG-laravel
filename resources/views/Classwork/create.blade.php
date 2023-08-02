@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classworks')

@section('content')
<h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>Classworks</h3>
    <hr>
    <form action="{{ route('classrooms.classworks.store' , [$classroom->id , 'type' => ]) }}" method="post">
    @csrf

    </form>
@endsection
