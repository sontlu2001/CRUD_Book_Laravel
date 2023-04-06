@extends('layout')
@section('content')
    <h2 class="m-5">Detail Category</h2>
    <a href="{{route('category.index')}}" class="ms-5 btn"> Back </a>
    <div class="container-fluid" style="max-width: 1200px">
        <form>
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name"  value="{{$category->name}}" class="form-control" id="name">
            </div>
        </form>
    </div>
@endsection
