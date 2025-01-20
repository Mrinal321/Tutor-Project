@extends('layout', ['title'=> 'Home'])
@section('page-content')

{{-- @extends('layouts.app')
@section('content') --}}

<!-- Teacher Cards in a Column-Wise Layout -->
<div class="col-sm-offset-2 col-sm-10">
    <a href="{{route('create')}}" class="btn btn-primary">Create New</a>
    @guest
    <a href="{{route('login')}}" class="btn btn-primary">Login</a>
    <a href="{{route('register')}}" class="btn btn-primary">Register</a>
    @else
    <!-- Authentication -->
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

<div class="container mt-5">
    <h1 class="text-center mb-4">Teachers</h1>
    <div class="row g-4">
        @foreach($teachers as $item)
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
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    {{-- <div class="d-flex justify-content-center mt-4">
        {{ $teachers->links('pagination::bootstrap-5') }}
    </div> --}}
</div>

@endsection
