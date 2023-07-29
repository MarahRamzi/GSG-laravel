@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Join Classroom')

@section('content')

<div class="d-flex align-items-center justify-content-center vh100">
    <form class="border p-5" action="{{ route('classrooms.join' , $classroom->id) }}" method="post">
        @csrf
        <button type="submit" class=""></button>

    </form>

</div>
@endsection
