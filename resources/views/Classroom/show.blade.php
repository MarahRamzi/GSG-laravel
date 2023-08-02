@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classrooms')

@section('content')
    <div class="container ">
    <h1> classroom </h1>
    <h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>{{ $classroom->section }}</h3>

    <div class="row">
        <div class="col-md-3">
            <div class="border rounded p-3 text-center">
               <span class="text-success fs-2">{{ $classroom->code }}</span>
            </div>
        </div>

        <div class="col-md-9">

            <p>
                <a href="{{ route('classrooms.classworks.index' , $classroom->id) }}" target="_self" rel="">Classwork</a>
            </p>

        </div>
    </div>

    </div>

    @endsection

    @push('scripts')

    @endpush
