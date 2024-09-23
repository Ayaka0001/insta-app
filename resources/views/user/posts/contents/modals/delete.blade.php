<div class="modal fade" id="delete-post{{$post->id}}">
    {{-- in the page, each post has a hidden modal. so we added {{$post->id}}to make each one unique --}}

    <div class="modal-dialog">
        <div class="modal-content border-danger">
            {{-- modal content is the visible part of the modal --}}
            {{-- like a card, it has 3parts: header, body, footer --}}
            <div class="modal-header border-danger">
                <h4 class="text-danger"><i class="fa-regular fa-trash-can"></i> Delete Post</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <img src="{{$post->image}}" alt="" class="d-block mb-2 image-lg">
                <p class="mb-0 text-muted">{{$post->description}}</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{route('post.delete', $post->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    {{-- the data-bs-dismiss="modal" is to close the modal --}}
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>

</div>