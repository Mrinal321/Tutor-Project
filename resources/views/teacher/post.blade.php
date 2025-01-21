@extends('layout', ['title'=> 'Home'])
@section('page-content')

<form  method="POST">
    {{ csrf_field() }}
    <div class="card">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6">
                    <div class="preview-pic tab-content">
                        <div class="tab-pane active" id="pic-1"><img src="https://dummyimage.com/300x300/0099ff/000" /></div>
                    </div>
                </div>
                <div class="details col-md-6">
                    <h3 class="product-title">Laravel 5.5 Ratting System</h3>
                    <div class="rating">
                        <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $teachers->total_star }}" data-size="xs">
                        <input type="hidden" name="id" required="" value="{{ $teachers->id }}">
                        <br/>
                        <button class="btn btn-success">Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
