@extends('layout', ['title'=> 'Home'])
@section('page-content')

<div class="container">
    @foreach ($teachersByUniversity as $university => $teachers)
        <div class="university-section mb-5">
            <!-- University Title -->
            <h2 class="university-title">{{ $university }}</h2>

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
            {{-- <div class="d-flex justify-content-center mt-4">
                {{ $teachers->links('pagination::bootstrap-5') }}
            </div> --}}

        </div>
        <div class="pagination-wrapper">
            {{ $teachers->links('pagination::bootstrap-5') }}
        </div>
    @endforeach
</div>

@endsection
