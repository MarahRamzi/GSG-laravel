@extends('layoute.master')

@push('styles')

@endpush

@section('title' , 'Classroom People')

@section('content')

    <div class="container ">
    <h1>{{ $classroom->name }} People</h1>

    @if(session()->has('success'))
    <div class="alert alert-success ">
        {{ session('success') }}
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger ">
        {{ session('error') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">Rule</th>
                <th scope="col">Action</th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($classroom->users as $user)

            <tr>
                <td></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->pivot->rule }}</td>
                <td>
                    <form action="{{ route('classrooms.people.destroy' , $classroom->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="user_id" value="{{ $user->id }}"> {{-- لتحديد id الخاص ب user  --}}
                        <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                </td>
                <td></td>
            </tr>
            @endforeach

            {{-- <hr>

            <h3>Students</h3>
            <hr>
            @foreach ($classroom->students as $student)

            <tr>
                <td></td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->pivot->rule }}</td>
                <td></td>
            </tr>
            @endforeach --}}
        </tbody>
    </table>

    </div>
    @endsection
