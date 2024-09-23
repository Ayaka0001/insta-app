<div class="modal fade" id="likes-list{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" data-bs-dismiss="modal" class="btn btn-sm ms-auto text-primary fw-bold">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="w-75 mx-auto">
                    @foreach($post->likes as $like)
                        <div class="row mb-3 align-items-center">
                            <div class="col-auto">
                                <a href="{{route('profile.show', $like->user->id)}}">
                                    @if($like->user->avatar)
                                        <img src="{{$like->user->avatar}}" alt="" class="rounded-circle avatar-sm me-2">    
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col ps-0 text-truncate">
                                <a href="{{route('profile.show', $like->user->id)}}" class="text-decoration-none text-dark fw-bold">
                                    {{$like->user->name}}
                                </a>
                            </div>
                            <div class="col-auto">
                                {{-- follow/unfollow --}}
                                @if($like->user->id !== Auth::user()->id)
                                    @if($like->user->isFollowed()) {{-- if the like user is already followed}}
                                    {{-- the isFollowed() function gets the $like->user's followers, and checks if the logged in user is in it  --}}
                                        {{-- unfollow --}}
                                        <form action="{{route('follow.delete', $like->user->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 text-secondary">
                                                Unfollow
                                            </button>
                                        </form>
                                    @else
                                        {{-- follow --}}
                                        <form action="{{route('follow.store', $like->user->id)}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn p-0 text-primary">
                                                Follow
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>