@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <p class="mb-2 fw-bold">Category <span class="fw-light">(up to 3)</span></p>
        <div>
            @forelse ($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="categories[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
                                            {{-- by naming all the checkboxes the same (categories[]), if more than one checkbox is checked, the value will be an array --}}
                    <label for="{{$category->name}}" class="form-check-label">{{$category->name}}</label>
                </div>
            @empty
                <p class="text-muted">No categories found.</p>
            @endforelse
        </div>
        @error('categories')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <label for="description" class="form-label mt-3 fw-bold">Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="What's on your mind" rows="3">{{old('description')}}</textarea>
        @error('description')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <label for="image" class="form-label mt-3 fw-bold">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        <p class="form-text mb-0">
            Acceptable formats: jpg, jpeg, png, gif
            <br>Max size: 1048 KB
        </p>
        @error('image')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn btn-primary mt-3 px-4">Post</button>
    </form>
@endsection