<div class="mt-2">
    <a href="{{route('profile.show', $comment->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$comment->user->name}}</a>
    &nbsp; {{-- &nbsp; inserts a space --}}
    <span class="fw-light">{{$comment->body}}</span>
    <div>
        <span class="text-muted xsmall">{{ date('D, M d,Y', strtotime($comment->created_at))}}</span>
        @if($comment->user_id == Auth::user()->id) {{-- if the comment belongs to the logged in user --}}
            <form action="{{route('comment.delete', $comment->id)}}" method="post" class="d-inline">
                @csrf
                @method('DELETE')
                &middot; {{-- &middot; inserts a middle dot --}}
                <button type="submit" class="btn p-0 text-danger xsmall">Delete</button>
            </form>
        @endif
    </div>
</div>