<div class="modal fade" id="recent-comments">
    <div class="modal-dialog">
        <div class="modal-content border-secondary" style="height: 400px">
            <div class="modal-header border-secondary">
                <h3 class="h5 text-secondary"> Recent Comments </h3>
            </div>
            <div class="modal-body overflow-auto">
                @foreach($user->comments()->latest()->take(5)->get() as $comment)
                    <div class="row mx-1">
                        <div class="col border border-primary rounded mt-2 py-2 text-muted">
                            {{$comment->body}}
                            <hr>
                            Replied to <a href="" class="text-decoration-none">{{$comment->post->user->name}}'s post</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer border-0">
                <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-secondary">Close</button>
            </div>
        </div>
    </div>
</div>