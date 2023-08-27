@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Create Classwork')

@section('content')
<h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>Classworks</h3>
    <hr>

    <form action="{{ route('classrooms.classworks.store' , [$classroom->id , 'type' => $type]) }}" method="post" class="form-floating">
        @csrf

    <div class="row container">
        <div class="col-md-8">
            <div class="form-floating mb-4 mt-3">
                <input type="input" @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name = "title" placeholder="Enter Classwork Title" value={{ old('title') }}>
                <label for="title">Title</label>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-floating mb-4 mt-3">
                <textarea @class(['form-control', 'is-invalid' => $errors->has('descreption')]) id="descreption" name="descreption" style="height: 100px" placeholder="Enter Classwork descreption">
                    {{ old('descreption') }}
                </textarea>
                <label for="descreption">Descreption (optional)</label>
              @error('descreption')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

        </div>

        <div class="col-md-4">
            <h4>Students</h4>
            <div>
                @foreach ($classroom->students as $student)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name= "students[]" value="{{ $student->id }}" id="std-{{ $student->id }}" checked />
                    <label class="form-check-label" for="std-{{ $student->id }}">{{ $student->name }}</label>
                </div>
            @endforeach
            </div>
            <div class="form-floating mb-4 mt-3">
                <select name="topic_id" id="topic_id" class="form-select">
                    <option value="">No Topic</option>
                    @foreach ($classroom->topics as $topic)
                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
                <label for="floatingSelect topic_id">Topic (optional)</label>
              @error('topic_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

        </div>
    </div>



    <button type="submit" class="btn btn-primary mx-5"> Create </button>

    </form>
@endsection
