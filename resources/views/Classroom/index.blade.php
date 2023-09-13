@extends('layoute.master')

@push('styles')

@endpush

@section('title' , __('Classrooms') )

@section('content')
    <div class="container ">
    <h1> {{ __('Classrooms') }} </h1>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success') }}
    </div>
    @endif

    <ul id="classrooms"></ul>

<div class="row">
    @foreach ( $classroom as $classrooms )
<div class="col-md-3">
    <div class="card">
        <img src="{{$classrooms->cover_image_url }}" class="card-img-top" alt="..">
        <div class="card-body">
          <h5 class="card-title">{{$classrooms->name}}</h5>
          <p class="card-text">{{ $classrooms->section }} - {{ $classrooms->room }}</p>
            <div class="d-flex justify-content-between">
                <a href="{{ $classrooms->url }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                <a href="{{ route('classrooms.edit' , $classrooms->id) }}" class="btn btn-sm btn-dark">{{ __('Edit') }}</a>
                <a href="{{ route('classrooms.trashed' ) }}" class="btn btn-sm btn-warning">{{ __('Trash') }}</a>
                <form action="{{ route('classrooms.destroy' , $classrooms->id) }}" method="post">
                    @csrf
                    @method('delete')
                        <div >
                            <button type="submit" class="btn  btn-sm btn-danger ">{{ __('Delete') }}</button>
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
   <script>
        fetch('/api/v1/classrooms') //fetch API route
            .then(res => res.json())
            .then(json => {
                document.getElementById('classrooms');
                for(let i in json.data){
                    ul.innerHtml += `<li>${json.data[i].name}</li>`
                }
            })
   </script>
    @endpush
