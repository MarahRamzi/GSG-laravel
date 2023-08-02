@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classworks')

@section('content')

<div class="container ">
    <h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>Classworks
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              + create
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'assignment']) }}">Assignment</a></li>
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'material']) }}">Material</a></li>
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'question']) }}">Question</a></li>
            </ul>
          </div>
    </h3>


<div class="accordion accordion-flush" id="accordionFlushExample">
    @foreach ($classworks as $classwork )
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
         data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false" aria-controls="flush-collapseThree">
          {{ $classwork->title }}
        </button>
      </h2>
      <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            {{ $classwork->description }}
        </div>
      </div>
    </div>
    @empty

    @endforeach
  </div>

@endsection
