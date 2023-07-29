@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Trashed Topics')

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
<div class="col-md-3">
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Topic name => {{$topics->name}}</h5>
          <p class="card-text" >classroom_id = > {{ $topics->classroom_id }} </p>
          <p class="card-text" >user_id =>{{ $topics->user_id }} </p>
          <div class="d-flex justify-content-between">
            <form action="{{ route('topics.restore' , $topics->id) }}" method="post">
              @csrf
              @method('put')
                  <div >
                      <button type="submit" class="btn  btn-sm btn-danger mt-2">Restore</button>
                  </div>
              </form>
            <form action="{{ route('topics.force-delete' , $topics->id) }}" method="post">
              @csrf
              @method('delete')
                  <div >
                      <button type="submit" class="btn  btn-sm btn-danger mt-2">Delete Forever</button>
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
