@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Topics')

@section('content')
    <div class="container ">
    <h1> Topics </h1>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success') }}
    </div>
    @endif

<div class="row">
    @foreach ( $topic as $topics )
<div class="col-md-3 mt-5">
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Topic name => {{$topics->name}}</h5>
          <p class="card-text" >classroom_id = > {{ $topics->classroom_id }} </p>
          <p class="card-text" >user_id =>{{ $topics->user_id }} </p>
          <div class="d-flex justify-content-between">
          <a href="{{ route('topics.show' , $topics->id) }}" class="btn btn-sm btn-primary">View</a>
          <a href="{{ route('topics.edit' , $topics->id) }}" class="btn btn-sm btn-dark">Edit</a>
          <a href="{{ route('topics.trashed') }}" class="btn btn-sm btn-warning">Trash</a>
          <form action="{{ route('topics.destroy' , $topics->id) }}" method="post">
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
