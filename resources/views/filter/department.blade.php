@extends('layout', ['title'=> 'Home'])
@section('page-content')

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
                $isUserPresent = $teachers2->pluck('user_teacher_id')->contains(auth()->id());
                $teacherID = $teachers2->firstWhere('user_teacher_id', auth()->id())?->id;
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

<h1 class="text-center mb-4">Department List</h1>
<div class="container">
    @foreach ($teachersByDepartment as $department => $teachers)
        <div class="university-section mb-5">
            <!-- University Title -->
            <h2 class="university-title">{{ $department }}</h2>

            <!-- Teachers List -->
            <div class="teachers-row d-flex flex-wrap">
                @foreach ($teachers as $item)
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
            <div class="d-flex justify-content-center mt-4">
                {{ $teachers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endforeach
</div>

@endsection
