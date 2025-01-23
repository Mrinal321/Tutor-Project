@extends('layout', ['title'=> 'Home'])
@section('page-content')

<h2>Update Teacher Form</h2>

<form action="{{ route('teacher.update', $teacher->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <label for="">Name</label><br>
        <input type="text" value="{{$teacher->name}}" name="name" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="">University</label><br>
        <input type="text" value="{{$teacher->university}}" name="university" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="">Department</label><br>
        <input type="text" value="{{$teacher->department}}" name="department" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="">Profile Image</label><br>
        <input type="file" name="image" class="form-control">
        <img src="{{ asset('uploads/teachers/'.$teacher->image)}}" width="70px" height="70px" alt="Image">
    </div><br>
    <div class="form-group mb-3">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

@endsection
