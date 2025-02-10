@extends('layout', ['title'=> 'Home'])
@section('page-content')

<h2>Create Teacher Form</h2>

<form action="{{ route('schedules.store') }}" method="POST">
    @csrf
    <div>
        <label for="title">Class Title</label>
        <input type="text" id="title" name="title" placeholder="Enter class title" required>
    </div>
    <div>
        <label for="duration">Duration</label>
        <input type="text" id="duration" name="duration" required>
    </div>

    {{-- <div>
        <label for="teacher_id">Teacher</label>
        <select id="teacher_id" name="teacher_id" required>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
        </select>
    </div> --}}

    <div>
        <label for="start_time">Start Time</label>
        <input type="datetime-local" id="start_time" name="start_time" required>
    </div>

    <div>
        <label for="end_time">End Time</label>
        <input type="datetime-local" id="end_time" name="end_time" required>
    </div>

    <!-- Hidden input field for name -->
    <input type="hidden" id="teacher_id" name="teacher_id" value="{{ $teacher->id }}">

    <button type="submit">Create Schedule</button>
</form>


@endsection

