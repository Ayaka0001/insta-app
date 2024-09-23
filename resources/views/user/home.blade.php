@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row gx-5">
    <div class="col-8">
        {{-- posts --}}
        @if($search) {{-- if the $search is not null--}}
            <h2 class="h4 text-muted mb-3">Search results for '<span class="fw-bold">{{$search}}</span>'</h2>
        @endif
        @forelse($all_posts as $post)
            <div class="card mb-4">
                @include('user.posts.contents.title') {{-- for inserting a view into another view --}}
                <div class="container p-0">
                    <a href="{{route('post.show', $post->id)}}">
                        <img src="{{$post->image}}" class="w-100" alt="">
                    </a>
                </div>
                <div class="card-body">
                    @include('user.posts.contents.body')
                    {{-- the top 3 comments --}}
                    @if($post->comments->isNotEmpty()) {{-- if the post has comments --}}
                        <hr class="mt-3">

                        @foreach($post->comments -> take(3) as $comment)
                            @include('user.posts.contents.comments.list-item')
                        @endforeach
                    @endif
                    @if($post->comments->count() > 3) {{-- if the post has more than 3 comments --}}
                        <a href="{{route('post.show', $post->id)}}" class="text-decoration-none small">
                            View all {{$post->comments->count()}} comments
                        </a>
                    @endif
                    {{-- add comment --}}
                    @include('user.posts.contents.comments.create')
                </div>
            </div>
        @empty
            <div class="text-center">
                <h2>Share Photos</h2>
                <p>When you share a photo, it will appear on your profile.</p>
                <a href="{{route('post.create')}}" class="text-decoration-none">Share your first photo</a>
            </div>
        @endforelse
    </div>
    <div class="col-4">
        {{-- user info, suggestions --}}
        <div class="bg-white mb-5 shadow-sm rouded-2 row align-items-center py-3">
            <div class="col-auto">
                @if(Auth::user()->avatar)
                    <img src="{{Auth::user()->avatar}}" alt="" class="rounded-circle avatar-md">
                @else
                    <a href="{{route('profile.show', Auth::user()->id)}}">
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    </a>
                @endif
            </div>
            <div class="col ps-0">
                <a href="{{route('profile.show', Auth::user()->id)}}" class="text-decoration-none text-dark fw-bold">
                    {{Auth::user()->name}}
                </a>
                <p class="mb-0 text-muted">{{Auth::user()->email}}</p>
            </div>
        </div>

        {{-- suggestions --}}
        @if($suggested_users) {{-- if the suggested_users array is not empty --}}
            <div class="row mb-3">
                <div class="col">
                    <span class="text-secondary fw-bold">Suggestions For You</span>
                </div>
                <div class="col-auto">
                    <a href="{{route('suggestions')}}" class="text-decoration-none text-dark fw-bold">See all</a>
                </div>
            </div>
            @foreach($suggested_users as $user)
                <div class="row mb-3 align-items-center">
                    <div class="col-auto">
                        {{-- avatar --}}
                        <a href="{{route('profile.show', $user->id)}}">
                            @if($user->avatar)
                                <img src="{{$user->avatar}}" alt="" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate"> {{-- text-truncate will cut the name if it is too long and show ... --}}
                        {{-- name --}}
                        <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                            {{$user->name}}
                        </a>
                    </div>
                    <div class="col-auto">
                        {{-- follow --}}
                        <form action="{{route('follow.store', $user->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn p-0 text-primary">Follow</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection