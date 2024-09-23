<div class="mt-3">
    <form action="{{route('comment.store', $post->id)}}" method="post">
        @csrf
        <div class="input-group">
            {{-- we can use $post b/c this is inserted inside the loop --}}
            <textarea name="comment_body{{$post->id}}" rows="1" placeholder="Write a comment..." class="form-control form-control-sm">{{old('comment_body'.$post->id)}}</textarea>
            {{-- wanted to make the name unique for the validation error. if its not unique the error might appear at the top of the page --}}
            <button type="submit" class="btn btn-sm btn-outline-secondary">Post</button>
        </div>
        @error('comment_body'.$post->id)
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror
    </form>
</div>