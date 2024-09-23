<div class="modal fade" id="edit-category{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h4">
                    <i class="fa-regular fa-pen-to-square"></i> Edit Category
                </h3>
            </div>
            <form action="{{route('admin.categories.edit', $category->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                <div class="modal-body">
                    <input type="text" class="form-control" name="category{{$category->id}}" value="{{old('category'.$category->id,$category->name)}}">
                        @error('category'.$category->id)
                            <p class="mb-0 text-danger small">{{ $message }}</p>
                        @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-warning">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>