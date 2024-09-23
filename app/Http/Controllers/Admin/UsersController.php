<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(Request $request){
        if($request->search){ 
            $all_users = $this->user->withTrashed()
                                    ->orderBy('name')
                                    ->where('name', 'LIKE', '%'.$request->search.'%')
                                    ->paginate(10);
        }else{
            //get all users, arranged/ordered by name
            $all_users = $this->user->withTrashed()->orderBy('name')->paginate(10);
            //paginate(10) means that we will get 10 users per page. 
            //paginate(n) means that we will show n number of users per page
            //withTrashed() - include soft-deleted records in the lists.(means that we will show deleted (soft deleted)users) (add before paginate or get)
        }
            return view('admin.users.index')->with('all_users', $all_users)
                                            ->with('search', $request->search);
    }

    public function deactivate($id){
        $this->user -> destroy($id);
        //destroy(id) means that we will delete the user with the given id
        //b/c the users table has soft delete attribute, this destroy will delete the user temporarily
        return redirect()->back();
    }

    public function activate($id){
        $this->user -> onlyTrashed() -> findOrFail($id) -> restore();
        //we need onlyTrashed() to show only soft-deleted records.(if we don't use this, we wil get an error b/c the user is soft-deleted and can not be found)
        //restore() means that we will restore the user that was found by findOrFail(id)
        //b/c the users table has soft delete attribute, this restore will restore the user
        return redirect()->back();
    }

}
