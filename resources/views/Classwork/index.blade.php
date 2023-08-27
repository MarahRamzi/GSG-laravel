@extends('layoute.master')

@push('styles')

@endpush

@section('title' , $classroom->name)

@section('content')

<div class="container ">

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success') }}
    </div>
    @endif

    <h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>Classworks
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              + create
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'Assignment' ]) }}">Assignment</a></li>
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'Material']) }}">Material</a></li>
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'Question']) }}">Question</a></li>
            </ul>
          </div>
</h3>
    <hr>

    @forelse ($classWork as $i => $group )
        <h3 class="text-danger-emphasis">{{ $group->first()->type }}</h3>
    <div class="accordion accordion-flush " id="accordion{{ $i }}">
    @foreach ($group as $classWorks)
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
         data-bs-target="#flush-collapse{{ $classWorks->id }}" aria-expanded="false" aria-controls="flush-collapseThree">
          {{ $classWorks->title }} / {{ $classWorks->topic->name }}/
                                                               {{ $classWorks->published_at }}
        </button>
      </h2>
      <div id="flush-collapse{{ $classWorks->id }}" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordion {{ $i }}">
        <div class="accordion-body">
            {{ $classWorks->descreption }}
        </div>
        <div class="accordion-body">
           <a href="{{ route('classrooms.classworks.edit' , [$classroom->id ,$classWorks->id ]) }}"><i class="fa-solid fa-pen"></i>edit</a>
            <form action="{{ route('classrooms.classworks.destroy' , [$classroom->id , $classWorks->id]) }}" method="post">
                @csrf
                @method('delete')
               <button type="submit"> <i class="fa-solid fa-trash text-dark"></i> </button>
            </form>
        </div>
      </div>

    </div>
    @endforeach

    @empty
    <p class="text-center fs-3">No Classwork yet.</p>
    @endforelse
  </div>

@endsection
