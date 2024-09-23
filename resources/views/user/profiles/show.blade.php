@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    <div class="row">
        @forelse ($user->posts as $post)
            <div class="col-lg-4 col-md-6 mb-4">{{-- adjusting grid. if the window is large we have 4 columns, if medium we have 6 --}}
                <a href="{{ route('post.show', $post->id) }}">
                    <img src="{{$post->image}}" alt="" class="grid-image"> {{-- grid-image: costum class. style in css --}}
                </a>
            </div>
        @empty
        <p class="text-center h5 text-muted">No posts yet.</p>
        @endforelse
    </div>
@endsection