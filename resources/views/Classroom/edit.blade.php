@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classrooms')

@section('content')

    <div class="container ">

    <h1>Edit classroom</h1>
    <form action="{{ route('classrooms.update' ,$classroom->id) }}" method="post" enctype="multipart/form-data">
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {{ csrf_field() }} --}}
        @csrf
        {{-- Form Method Sppofing
        <input type="hidden" name="_method" value="put">
        {{ method_field('put') }}
        --}}
        @method('put')
        <div class="form-floating mb-4 mt-3">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name" name = "name"  placeholder="enter classroom name" value ={{ $classroom->name }}>
            <label for="name">ClassRoom Name</label>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('subject')]) id="section" name ="section"   placeholder="enter section "  value ={{ $classroom->section }}>
            <label for="section">Section</label>
            @error('subject')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('section')]) id="subject" name ="subject"  placeholder="enter subject " value ={{ $classroom->subject }}>
            <label for="subject">Subject</label>
            @error('section')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('room')]) id="room" name ="room"  placeholder="enter room " value ={{ $classroom->room }}>
            <label for="room">Room</label>
            @error('room')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <img src="{{Storage::url( $classroom->cover_image_path )  }}" alt="...">
            <input type="file" @class(['form-control', 'is-invalid' => $errors->has('cover_image_path')]) id="cover_image_path" name ="cover_image_path" placeholder="cover Image ">
            <label for="cover_image_path">Cover Image</label>
            @error('cover_image_path')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <button type="submit" class="btn btn-primary ">Update ClassRoom</button>
    </form>
</div>
  @endsection

  @push('scripts')

  @endpush
