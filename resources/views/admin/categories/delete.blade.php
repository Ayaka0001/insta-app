<div class="modal fade" id="delete-category{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h4">
                    <i class="fa-solid fa-trash-can"></i> Delete Category
                </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{$category->name}}</strong> category?</p>
                <p>This action will affect all the posts under this category. Posts without a category will fall under Uncategorized.</p>
            </div>
            <div class="modal-footer">
                <form action="{{route('admin.categories.delete', $category->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>