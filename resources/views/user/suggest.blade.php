@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')
    {{-- suggestions --}}
    <div class="row justify-content-center">
        <div class="col-4">
            @if($suggested_users) {{-- if the suggested_users array is not empty --}}
                <div class="row mb-3">
                    <div class="col">
                        <h5 class="fw-bold">Suggested</h5>
                    </div>
                </div>
                @foreach($suggested_users as $user)
                    <div class="row mb-3 align-items-center">
                        <div class="col-auto">
                            {{-- avatar --}}
                            <a href="{{route('profile.show', $user->id)}}">
                                @if($user->avatar)
                                    <img src="{{$user->avatar}}" alt="" class="rounded-circle avatar-md">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate"> {{-- text-truncate will cut the name if it is too long and show ... --}}
                            {{-- name --}}
                            <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                                {{$user->name}}
                            </a>
                            <p class="text-muted mb-0">{{$user->email}}</p>
                            @if($user->followsYou())
                                <p class="text-muted small mb-0">Follows you</p>
                            @else
                                @if($user->followers->count() >0)
                                    <p class="text-muted small mb-0">{{$user->followers->count()}} follower</p>
                                @else
                                    <p class="text-muted small mb-0">No followers yet</p>
                                @endif
                            @endif
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