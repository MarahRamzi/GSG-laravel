@extends('layoute.master')

@push('styles')

@endpush
 
@section('title' , 'Update Classwork')

@section('content')
<div class="container">
<h1>{{ $classroom->name }} (#{{ $classroom->id }}) detailed</h1>
    <h3>Update Classwork </h3>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success')}}
        </div> 
    @endif
</div>
    <hr>
    <form action="{{ route('classrooms.classworks.update' , [$classroom->id , $classwork->id]) }}" method="post" class="form-floating">
    @csrf
    @method('put')
    <div class="row container">
        <div class="col-md-8">
            <div class="form-floating mb-4 mt-3">
                <input type="input" @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name = "title" placeholder="Enter Classwork Title" value={{ old('title',$classwork->title) }}>
                <label for="title">Title</label>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-floating mb-4 mt-3">
                <textarea @class(['form-control', 'is-invalid' => $errors->has('descreption')]) id="descreption" name="descreption" style="height: 100px" placeholder="Enter Classwork descreption">
                    {{ old('descreption' , $classwork->descreption) }}
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
                    <input class="form-check-input" type="checkbox" name= "students[]" value="{{ $student->id }}" id="std-{{ $student->id }}" @checked(in_array($student->id , $assigned)) />
                    <label class="form-check-label" for="std-{{ $student->id }}">{{ $student->name }}</label>
                </div>
            @endforeach
            </div>

            <div class="form-floating mb-4 mt-3">
                <select name="topic_id" id="topic_id" class="form-select">
                    <option value="">No Topic</option>
                    @foreach ($classroom->topics as $topic)
                    <option @selected($topic->id == $classwork->topic_id) value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
                <label for="floatingSelect topic_id">Topic (optional)</label>
              @error('topic_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
        </div>
    </div>





    <button type="submit" class="btn btn-primary mx-5"> Update </button>

    </form>
@endsection
