@extends('layouts.app')

@section('title','Admin: Categories')

@section('content')
<div class="col-5">
    <form action="{{route('admin.categories.store')}}" method="post">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="name" class="form-control" placeholder="Add a category...">
                 @error('name')
                    <p class="mb-0 text-danger small">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-auto ps-0">
                <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
            </div>
        </div>
    </form>
</div>
    <table class="table table-sm table-hover bg-white border text-secondary align-middle text-center">
        {{-- the text-secondary doesn't work as it is, so we need to set it in css --}}
        <thead class="table-warning small text-uppercase text-secondary">
            <tr>
                <th>#</th>
                <th>name</th>
                <th>Count</th>
                <th>Last updated</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td class="text-dark fw-bold">{{$category->name}}</td>
                    <td>{{$category->categoryPosts->count()}}</td>
                    <td>{{$category->updated_at}}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#edit-category{{$category->id}}">
                            <i class="fa-solid fa-pen"></i>
                        </button>

                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-category{{$category->id}}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                @include('admin.categories.edit')
                @include('admin.categories.delete')
            @empty
                <tr>
                    <td class="text-center" colspan="6">No Categories found</td>
                </tr>
            @endforelse
            <tr>
                <td>0</td>
                <td>Uncategorized</td>
                <td>{{$uncategorized_count}}</td>
                <td colspan="2"></td>    
            </tr>
        </tbody>
    </table>
    {{$categories->links()}}
@endsection