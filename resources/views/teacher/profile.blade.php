@extends('layout', ['title'=> 'Home'])
@section('page-content')

{{-- @extends('layouts.app')
@section('content') --}}

{{-- Nevigation Bar Start --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('index')}}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="btn btn-search" href="{{route('university')}}">All University <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="btn btn-search" href="{{route('department')}}">All Department <span class="sr-only">(current)</span></a>
        </li>
      </ul>

        @guest
            <a class="btn " href="">Enroll as a teacher or rate? Login first! <span class="sr-only">(current)</span></a>
            <a href="{{route('login')}}" class="btn primary">Login</a>
            <a href="{{route('register')}}" class="btn primary">Register</a>
        @else
            @php
                $isUserPresent = $teachers->pluck('user_teacher_id')->contains(auth()->id());
                $teacherID = $teachers->firstWhere('user_teacher_id', auth()->id())?->id;
            @endphp
            @if ($isUserPresent)
                <a class="btn success" href="{{route('teacher.edit', $teacherID)}}">Edit Profile - {{ Auth::user()->name }} <span class="sr-only">(current)</span></a>
            @else
                <a class="btn success" href="{{route('create')}}">Enroll as a Teacher - {{ Auth::user()->name }} <span class="sr-only">(current)</span></a>
            @endif
            <!-- Authentication -->
            {{-- <div>{{ Auth::user()->name }}</div> --}}
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
{{-- Nevigayion Bar End --}}

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('index')}}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="btn success" href="{{route('create')}}">Enroll as a Teacher <span class="sr-only">(current)</span></a>
        </li>
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

<div class="col-md-4 col-sm-6">
    <div class="card teacher-card">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $item->name }}</h5>
            <p class="card-text"><strong>University: </strong> {{ $item->university }}</p>
            <p class="card-text"><strong>Department:</strong> {{ $item->department }}</p>
            <img src="{{ asset('uploads/teachers/'.$item->image)}}" width="100px" height="70px" alt="Image">
            <p class="card-text"><strong>Total Vote:</strong> {{ $item->vote }}</p>
            <form action="{{ route('vote', $item->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Vote</button>
            </form>
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
            <!-- Check if User Can Rate -->
            @if(auth()->check() && !$item->voters->contains(auth()->id()))
                <form action="{{ route('teachers.rate', $item->id) }}" method="POST">
                    @csrf
                    <label for="rating">Rate this teacher:</label>
                    <div id="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <label>
                                <input type="radio" name="star" value="{{ $i }}" style="display: none;">
                                <i class="fa fa-star"
                                onclick="this.closest('form').submit()"
                                style="cursor: pointer; color: gray;"
                                onmouseover="this.style.color='gold'"
                                onmouseout="this.style.color='gray'"></i>
                            </label>
                        @endfor
                    </div>
                </form>
            @else
                @if(auth()->check())
                    <p>You have already rated this teacher.</p>
                @else
                    <p><a href="{{ route('login') }}">Login</a> to rate this teacher.</p>
                @endif
            @endif

            <!-- Display Comments -->
            <h4>Comments:</h4>
            @php
                $comments = DB::table('comments')
                    ->where('teacher_id', $item->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            @if ($comments->count() > 0)
                <ul>
                    @foreach ($comments as $comment)
                        <li>
                            <strong>
                                @php
                                    $user = DB::table('users')->find($comment->user_id);
                                    echo $user ? $user->name : 'Anonymous';
                                @endphp
                            </strong>: {{ $comment->content }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No comments yet. Be the first to leave one!</p>
            @endif

            <!-- Add Comment Form -->
            <h4>Leave a Comment:</h4>
            <form action="{{ route('comments.store', $item->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="3" placeholder="Write your comment here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
