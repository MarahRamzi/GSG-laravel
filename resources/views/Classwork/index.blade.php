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
    @can('create', ['App\Models\ClassroomWork' ,$classroom])
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              + create
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'assignment' ]) }}">Assignment</a></li>
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'material']) }}">Material</a></li>
              <li><a class="dropdown-item" href="{{ route('classrooms.classworks.create' , [$classroom->id , 'type' => 'question']) }}">Question</a></li>
            </ul>
          </div>
    @endcan
</h3>
    <hr>

    <form action="{{ URL::current() }}" method="get" class="row row-cols-lg-auto g-3 align-items-center mb-3">
        <div class="col-12">
            <input type="text" name="search" class="form-control" placeholder="Search">
        </div>
        <div class="col-12">
            <button class="btn btn-outline-warning" type="submit">Find</button>
        </div>

    </form>

        {{-- <h3 class="text-danger-emphasis">{{ $group->first()->type }}</h3> --}}
    <div class="accordion accordion-flush " id="accordion">
    @foreach ($classWork as $classWorks )
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
         data-bs-target="#flush-collapse{{ $classWorks->id }}" aria-expanded="false" aria-controls="flush-collapseThree">
          {{ $classWorks->title }} / {{ $classWorks->topic->name ??''}}/
                                                               {{ $classWorks->published_at }}
        </button>
      </h2>
      <div id="flush-collapse{{ $classWorks->id }}" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" >
        <div class="accordion-body row">
            <div class="col-md-6">
            {!! $classWorks->descreption !!}
            </div>

            <div class="col-md-6 row">
                <div class="col-md-4">
                    <div class="fs-2">{{ $classWorks->assigned_count }}</div>
                    <br>
                    <div class="text-muted">Assigned</div>
                </div>
                <div class="col-md-4">
                    <div class="fs-2">{{ $classWorks->submited_count }}</div>
                    <br>
                    <div class="text-muted">Turned-in</div>
                </div>
                <div class="col-md-4">
                    <div class="fs-2">{{ $classWorks->graded_count }}</div>
                    <br>
                    <div class="text-muted">Graded</div>
                </div>

            </div>

        </div>
        <div class="accordion-body d-flex justify-content-start">
           <a class="btn btn-sm btn-outline-dark me-5" href="{{ route('classrooms.classworks.edit' , [$classroom->id ,$classWorks->id ]) }}">Edit</a>
           <a class="btn btn-sm btn-outline-success me-5" href="{{ route('classrooms.classworks.show' , [$classroom->id ,$classWorks->id]) }}">View Instruction</a>
            <form action="{{ route('classrooms.classworks.destroy' , [$classroom->id , $classWorks->id]) }}" method="post">
                @csrf
                @method('delete')
               <button type="submit" class="btn btn-sm btn-outline-danger">Delete </button>
            </form>
        </div>
      </div>

    </div>
    @endforeach

    {{-- @empty  //forelse
    <p class="text-center fs-3">No Classwork yet.</p> --}}

    <div class="mt-5">
        {{ $classWork->withQueryString()->links() }}
        {{-- {{ $classWork->links() }} --}}

    </div>
  </div>

@endsection

@push('scripts')
<script>
     classroomId = "{{ $classWorks->classroom_id }}"
</script>
    @vite(['resources/js/app.js'])
    {{-- لارفيل تلقائيا لو كنا عاملين build=> رح تجيب المسار الخاص في  --}}
    {{-- لو كنا عاملين run dev =>رح تجيب الرابط الخاص ب dev  --}}
@endpush
