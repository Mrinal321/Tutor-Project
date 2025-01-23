@extends('layout', ['title'=> 'Home'])
@section('page-content')

{{-- @extends('layouts.app')
@section('content') --}}

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('index')}}">Home <span class="sr-only">(current)</span></a>
        </li>
        @guest
        <li class="nav-item active">
            <a class="btn " href="{{route('create')}}">Enroll as a teacher? Login first! <span class="sr-only">(current)</span></a>
          </li>
        @else
            @php
                $isUserPresent = $teachers->pluck('user_teacher_id')->contains(auth()->id());
            @endphp

            @if ($isUserPresent)
                <li class="nav-item active">
                    <a class="btn success" href="{{route('create')}}">Edit Profile <span class="sr-only">(current)</span></a>
                </li>
            @else
                <li class="nav-item active">
                    <a class="btn success" href="{{route('create')}}">Enroll as a Teacher <span class="sr-only">(current)</span></a>
                </li>
            @endif
        @endguest
      </ul>

        @guest
        <a href="{{route('login')}}" class="btn primary">Login</a>
        <a href="{{route('register')}}" class="btn primary">Register</a>
        @else
        <!-- Authentication -->
        <div>{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
        @endguest

    </div>
</nav>

<a class="btn success" href="{{route('university')}}">University<span class="sr-only">(current)</span></a>

<!-- Filter Form -->
<form method="GET" action="{{ route('index') }}" class="mb-4">
    <div class="row">
        <!-- University Filter -->
        <div class="col-md-5">
            <label for="university">University</label>
            <select name="university" id="university" class="form-control">
                <option value="">-- Select University --</option>
                @foreach ($universities as $uni)
                    <option value="{{ $uni }}" {{ $uni == $university ? 'selected' : '' }}>{{ $uni }}</option>
                @endforeach
            </select>
        </div>

        <!-- Department Filter -->
        <div class="col-md-5">
            <label for="department">Department</label>
            <select name="department" id="department" class="form-control">
                <option value="">-- Select Department --</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept }}" {{ $dept == $department ? 'selected' : '' }}>{{ $dept }}</option>
                @endforeach
            </select>
        </div>

        <!-- Filter Button -->
        <div class="col-md-2">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </div>
</form>

<div class="container mt-5">
    <h1 class="text-center mb-4">Teachers List</h1>
    <div class="row g-4">
        @foreach($teachers as $item)
            <div href="{{route('create')}}" class="col-md-4 col-sm-6">
                <div class="card teacher-card">
                    <div class="card-body">
                        <h5 class="card-title">Name: {{ $item->name }}</h5>
                        <p class="card-text"><strong>University: </strong> {{ $item->university }}</p>
                        <p class="card-text"><strong>Department:</strong> {{ $item->department }}</p>
                        <img src="{{ asset('uploads/teachers/'.$item->image)}}" width="100px" height="70px" alt="Image">
                        <!-- Display Average Rating -->
                        <p>Average Rating:
                            @php
                                $number = 0; $str = 0;
                                if($item->count > 0){
                                    $str = ($item->total_star / $item->count);
                                    $number = ceil($str); // Calculate the rounded average
                                }
                                echo(round($str, 1));
                            @endphp
                            <br>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $number)
                                    <span class="fa fa-star checked" style="color: gold;"></span> <!-- Filled star -->
                                @else
                                    <span class="fa fa-star" style="color: gray;"></span> <!-- Empty star -->
                                @endif
                            @endfor
                        </p>

                        <a href="{{route('teacher.profile', $item->id)}}" >View Profile</a><br>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    {{-- <div class="d-flex justify-content-center mt-4">
        {{ $teachers->links('pagination::bootstrap-5') }}
    </div> --}}
    {{-- <div class="d-flex justify-content-center mt-4">
        {{ $teachers->appends(['sort_field' => $sortField, 'sort_direction' => $sortDirection])}}
    </div> --}}
</div>

@endsection
