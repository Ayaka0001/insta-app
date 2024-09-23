@extends('layouts.app')

@section('title','Admin: Posts')

@section('content')
    {{-- no csrf. set the page you want the search results to show. set to get to be able to see what you searched for --}}
    {{-- in controller set the variable for search,and for this page, we are going to only show the searched post w/the input still showing what we searched for. so make an if statement saying what to show --}}
    {{-- we dont need @csrf b/c we are not changing anything in the database --}}
    <div class="row mb-3">
        <div class="col-3 ms-auto">
            <form action="{{ route('admin.posts') }}" method="get">
                    <input type="text" name="search" placeholder="Search posts..." class="form-control" value="{{$search}}">
            </form>
        </div>
    </div>
    <table class="table table-hover bg-white border text-secondary align-middle">
        {{-- the text-secondary doesn't work as it is, so we need to set it in css --}}
        <thead class="table-primary small text-uppercase text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>Category</th>
                <th>Owner</th>
                <th>Created At</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>
                        {{-- image --}}
                        <img src="{{$post->image}}" alt="" class="image-lg d-block mx-auto">
                    </td>
                    <td>
                        {{--category/categories--}}
                        @forelse($post->categoryPosts as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">{{$category_post->category->name}}</div>
                        @empty
                            <div class="badge bg-dark">Uncategorized</div>
                        @endforelse
                    </td>
                    <td> 
                        <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark fw-bold">
                            {{$post->user->name}}
                        </a> 
                    </td>
                    <td> {{$post->created_at}} </td>
                    <td>
                        {{-- status --}}
                        @if($post->trashed())
                        <i class="fa-solid fa-circle-minus text-secondary"></i> Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i> Visible
                        @endif
                    </td>
                    <td>
                        {{-- button --}}
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="dropdown-menu">
                                @if($post->trashed())
                                    {{-- unhide --}}
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post{{$post->id}}">
                                        <i class="fa-solid fa-eye"></i> Unhide Post {{$post->id}}
                                    </button>
                                @else
                                    {{-- hide --}}
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post{{$post->id}}">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post {{$post->id}}
                                    </button>
                                @endif
                            </div>
                        </div>
                        @include('admin.posts.status')
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">No Posts found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{$posts->links()}}
@endsection