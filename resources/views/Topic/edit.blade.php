@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Topics')

@section('content')

    <div class="container ">

    <h1>create Topic</h1>
    <form action="{{ route('topics.update' ,$topic->id) }}" method="post" >
        @csrf
        @method('put')
        <div class="form-floating mb-4 mt-3">
            <input type="text" class="form-control" id="name" name = "name" placeholder="Enter topic name" value="{{ old('name', $topic->name) }}">
            <label for="name">Topic Name</label>
          </div>

          <div class="form-group col-mt-5 ">
            <label>Classroom id</label>
            <select  @class(['form-control','is-invalid' => $errors->has('classroom_id')]) name="classroom_id" id="classroom_id"  style="width: 100%;" value="{{ old('classroom_id', $topic->classroom_id) }}>
             @foreach ($classroom as  $classrooms)
             <option  value="{{  $classrooms->id }}">{{  $classrooms->id}}</option>
             @endforeach
            </select>
            @error('classroom_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


          <div class="form-group col-mt-5 mt-4 mb-5">
            <label>User id</label>
            <select  @class(['form-control','is-invalid' => $errors->has('user_id')]) name="user_id" id="user_id"  style="width: 100%;">
             @foreach ($user as  $users)
             <option  value="{{  $users->id }}">{{  $users->id}}</option>
             @endforeach
            </select>
            @error('user_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


          <button type="submit" class="btn btn-primary ">update Topic</button>
    </form>
</div>
@endsection

@push('scripts')

@endpush
