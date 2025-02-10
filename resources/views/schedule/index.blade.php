@extends('layout', ['title'=> 'Home'])
@section('page-content')

<h1>Running Events</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Teacher</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($running as $schedule)
                <tr>
                    <td>{{ $schedule->title }}</td>
                    <td>{{ $schedule->teacher_id}}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No upcoming events</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<h1>Upcoming Events</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Teacher</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($upcoming as $schedule)
                <tr>
                    <td>{{ $schedule->title }}</td>
                    <td>{{ $schedule->teacher_id}}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No upcoming events</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h1>Previous Events</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Teacher</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($previous as $schedule)
                <tr>
                    <td>{{ $schedule->title }}</td>
                    <td>{{ $schedule->teacher_id}}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No upcoming events</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
