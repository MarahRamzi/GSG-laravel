@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classrooms')

@section('content')
{{-- target and id --}}

@if(session()->has('success'))
    <div class="alert alert-success container">
        {{ session()->get('success')}}
    </div>
@endif

<div class="container">
        {{-- <h1> classroom </h1> --}}
        <h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
        {{-- <h3>{{ $classroom->section }}</h3>--}}
</div>

<div class="row ">

        <div class="col-4 mt-4 ms-4 container">

            <div class="border rounded p-3 text-center" style="width: 15rem;">
                <span class="text-success fs-2">{{ $classroom->code }}</span>
            </div>

            <div  class="mt-3">
                <p >Invitation Link : 
                    <a  style="width: 15rem;" href="{{ $invitationLink }}">{{ $invitationLink }}</a>
                </p>
            </div>

            <div class="mt-3">
                <p>
                    <a href="{{ route('classrooms.classworks.index' , $classroom->id) }}" target="_self" rel="" class="btn btn-outline-dark">Classworks</a>
                </p>
            </div>

        </div>




        <div class="col-7 my-5 ms-1">
          {{-- add post --}}
            <div class="card" style="width: 50rem;">
                <div class="card-body">
                <h4 class="card-title text-muted">For {{ $classroom->name }}</h4>
                <form action="{{ route('classrooms.posts.store' , $classroom->id) }}" method="post">
                    @csrf
                <div class="input-group my-3">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    {{-- <label for="content" class="text-dark  rounded mx-2">Share Post</label> --}}
                    <input type="text" class="form-control" name="content" id="content" placeholder="Announce Something to your class">

                  </div>
                <button type="submit" class=" btn btn-outline-primary ">post</button>
                </div>
            </form>
            </div>

                {{-- view post --}}
            <div class="accordion mt-5 mb-3" id="accordionExample" style="width: 50rem;">
                @foreach ($posts as $post)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $post->id }}" aria-expanded="true" aria-controls="collapse{{ $post->id }}">
                        {{ $post->user->name }} posted new post #{{$post->id}}
                      </button>
                    </h2>
                    <div id="collapse{{ $post->id }}" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <p>{{ $post->content }}
                        <span class="text-left text-muted">{{ $post->created_at->diffForHumans(null,false,true) }}</span>
                    </p>
                    <strong>{{ $post->comments_count }} comments</strong>
                    <hr>
                        {{-- ADD COMMENT --}}
                    <form action="{{ route('comments.store') }}" method="post">
                        @csrf
                        <div>
                            <input type="hidden" name="id" value="{{ $post->id }}">
                        <input type="hidden" name="type" value="Post">
                        {{-- <label for="content" class="form-label">Comment</label> --}}
                        <input type="text" class="form-control" id="content"  name="content" placeholder="Add Your Cooment">
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-3">Comment</button>

                    </form>
                            {{-- view comment --}}
                    <div class="accordion mt-3" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              All Comments
                            </button>
                          </h2>
                          @foreach ($post->comments as $comment)
                          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row container">
                                    <div class="col-md-1">
                                        <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}&background=random&size=55&rounded=true" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <p>By :{{ $comment->user->name}} . Time: {{ $comment->created_at->diffForHumans(null , false, true) }}</p>
                                        <p>{{ $comment->content}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                         </div>
                          @endforeach

                    </div>
                    </div>
                  </div>
                </div>
            </div>
            <hr>
                  @endforeach
    </div>

    @endsection

    @push('scripts')

    @endpush
