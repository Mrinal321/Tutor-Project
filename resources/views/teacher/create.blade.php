@extends('layout', ['title'=> 'Home'])
@section('page-content')

<h2>Create Teacher Form</h2>

    <form action="{{ route('store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="">Name</label><br>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">University</label><br>
            <input type="text" name="university" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Department</label><br>
            <input type="text" name="department" class="form-control">
        </div>
        {{-- <div class="form-group mb-3">
            <label for="">Vote</label><br>
            <input type="number" name="vote" class="form-control">
        </div> --}}
        <div class="form-group mb-3">
            <label for="">Profile Image</label><br>
            <input type="file" name="image" class="form-control">
        </div><br>
        <div class="col-sm-offset-2 col-sm-10">
            <a href="{{route('index')}}" class="btn btn-danger"> <i class="bi bi-arrow-left"></i> Back</a>
            <button type="submit" class="btn btn-primary"> Submit</button>
        </div>
    </form>

@endsection


