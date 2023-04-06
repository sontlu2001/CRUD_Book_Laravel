@extends('layout')
@section('content')
    <h2 class="m-5">Manage Category</h2>
    <a href="{{route('category.create')}}" class="ms-5 btn btn-primary">Add Category</a>

    <div class="container-fluid mt-3" style="width: 100%">
        @if ($message = Session::get('success'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
            </svg>
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {{$message}}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <table class="table d-b m-5">
        <thead>
        <tr>
            <th scope="col" style="width: 10%">#</th>
            <th scope="col" style="width: 70%">Name</th>
            <th scope="col" colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $key => $category)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $category->name }}</td>
                <td><a href="{{route('category.show',$category->id)}}"><i class="bi bi-eye"></i></a></td>
                <td><a href="{{route('category.edit',$category->id)}}"><i class="bi bi-pencil"></i></a></td>
                <td>
                    <form action="{{ route('category.destroy',$category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pagination justify-content-center">
        <ul class="pagination">
            @if ($data->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $data->previousPageUrl() }}">Previous</a>
                </li>
            @endif
            @for ($i = 1; $i <= $data->lastPage(); $i++)
                <li class="page-item {{ ($data->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            @if ($data->currentPage() < $data->lastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $data->nextPageUrl() }}">Next</a>
                </li>
            @endif
        </ul>
    </div>

@endsection
