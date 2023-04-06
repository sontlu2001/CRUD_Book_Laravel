@extends('layout')
@section('content')
    <h2 class="m-5">Edit Book</h2>

    <div class="container-fluid" style="max-width: 1200px">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div>
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif

        <form method="post" action="{{route('book.update',$book->id)}}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" value="{{$book->title}}" class="form-control" id="title">
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Author</label>
                <select class="form-select" name="author_id" id="inputGroupSelect01">
                    <option selected>Choose...</option>
                    @foreach($authors as $author)
                        @if($author->id == $book->author_id)
                            <option value="{{$author->id}}" selected>{{$author->name}}</option>
                        @else
                            <option value="{{$author->id}}">{{$author->name}}</option>
                        @endif
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Published Date:</label>
                <input type="date" name="published_date" value="{{$book->published_date}}" class="form-control"
                       id="date">
            </div>

            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control" name="description" placeholder="Leave a comment here"
                              id="Description"
                              style="height: 100px">{{$book->description}}</textarea>
                    <label for="Description">Description:</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="categories" class="mb-3">Categories:</label>
                @foreach($categories as $category)
                    <div class="form-check">
                        @if($book->categories->contains($category->id))
                            <input class="form-check-input" type="checkbox" value="{{ $category->id }}"
                                   id="category-{{ $category->id }}" name="categories[]" checked>
                            <label class="form-check-label" for="category-{{ $category->id }}"></label>
                            {{ $category->name }}
                        @else
                            <input class="form-check-input" type="checkbox" value="{{ $category->id }}"
                                   id="category-{{ $category->id }}" name="categories[]">
                            <label class="form-check-label" for="category-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        @endif
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
