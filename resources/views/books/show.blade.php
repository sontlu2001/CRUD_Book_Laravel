@extends('layout')
@section('content')
    <h2 class="m-5">Book Detail</h2>
    <a href="{{route('book.index')}}" style="font-size: 35px" class="ms-5 mb-3 btn"> <i class="bi bi-arrow-left"></i> </a>
    <div class="container-fluid" style="max-width: 1200px">
        <form>
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" value="{{$book->title}}" class="form-control" id="title">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Published Date</label>
                <input type="date" name="published_date" value="{{$book->published_date}}" class="form-control"
                       id="date">
            </div>
            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="Description"
                              style="height: 100px">{{$book->description}}</textarea>
                    <label for="Description">Description</label>
                </div>
            </div>

            <div class="form-label mb-3">Categories</div>
            @foreach($book->categories as $category )
                <span class="p-2 border border-primary rounded-pill">{{$category->name}}</span>
            @endforeach

        </form>
    </div>
@endsection
