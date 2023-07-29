@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classrooms')

@section('content')

    <div class="container ">

    <h1>create classroom</h1>
    <form action="{{ route('classrooms.store') }}" method="post" enctype="multipart/form-data">
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {{ csrf_field() }} --}}
        @csrf
        <div class="form-floating mb-4 mt-3">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name" name = "name" placeholder="enter classroom name" value={{ old('name') }}>
            <label for="name">ClassRoom Name</label>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('section')]) id="section" name ="section" placeholder="enter section"  value={{ old('section') }}>
            <label for="section">Section</label>
            @error('section')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('subject')]) id="subject" name ="subject" placeholder="enter subject " value={{ old('subject') }}>
            <label for="subject">Subject</label>
            @error('subject')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('room')]) id="room" name ="room" placeholder="enter room " value={{ old('room') }}>
            <label for="room">Room</label>
            @error('room')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <div class="form-floating mb-4">
            <input type="file" @class(['form-control', 'is-invalid' => $errors->has('cover_image_path')]) id="cover_image_path" name ="cover_image_path" placeholder="cover Image ">
            <label for="cover_image_path">Cover Image</label>
            @error('cover_image_path')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

          <button type="submit" class="btn btn-primary ">Create ClassRoom</button>
    </form>
</div>
@endsection

@push('scripts')

@endpush
