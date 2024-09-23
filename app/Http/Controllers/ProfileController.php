<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.show')->with('user', $user_a);
    }

    public function edit(){
        // $user_a = $this->user->findOrFail(Auth::user()->id);
        // one option is to use Auth::user()->id as shown above
        // but this time we can get all the information of the logged in user with Auth::user() so we can just use the view 
        return view ('user.profiles.edit');
    }

    public function update(Request $request){
        $request->validate([
            'avatar' => 'max:1048|mimes:jpg,jpeg,png,gif',
            'name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users,email,'.Auth::user()->id,
            //when you are creating: unique:<table>,<column>
            //when you are updating: unique:<table>,<column>,<id>
            // <id> of what ever record you are updating
            //if we are creating and the email already exists, we will get an error
            //if we are updating and the email already exists and it belongs to the logged in user, its ok but if it belongs to someone else, we will get an error
            'introduction' => 'max:100',
        ]);

        $user_a = $this->user -> findOrFail(Auth::user()->id);

        if($request->avatar){ //if the form submits an avatar
            $user_a->avatar = 'data:image/'.$request->avatar->extension().';base64,'.base64_encode(file_get_contents($request->avatar));
            //convert image to long text
        }
        $user_a->name = $request->name;
        $user_a->email = $request->email;
        $user_a->introduction = $request->introduction;

        $user_a->save();
        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function following($id){
        $user_a = $this->user->findOrFail($id);
        return view('user.profiles.following')->with('user', $user_a);
    }

    public function followers($id){
        $user_a = $this->user->findOrFail($id);
        return view('user.profiles.followers')->with('user', $user_a);
    }

    public function updatePassword(Request $request){
       $user_a = $this->user->findOrFail(Auth::user()->id);
       //this type of validation, validates from top to bottom

        //1.check if old password is correct
        if(!Hash::check($request->old_password, $user_a->password)){
            //Hash::check() checks the hashed data against the plain text
            //Hash::check(encoded(hashed)data , plain text data)

            //go back to the form and display error
            return redirect()->back()->with('old_password_error', 'Your current password is incorrect.');
            //this with() is the same as when we pass the variable to the view
            //with('name of the variable', 'the error message you want to display')
            //if we use the with() function with return redirect()->back(), we cannot use it as we usually do
            //we have to use it like this: @if(session('old_password_error'))
        }
        //2.new password cannot be the same as old password
        if($request->new_password == $request->old_password){
            //go back to the form and display error
            return redirect()->back()->with('same_password_error','New password cannot be the same as current password');
        }
        //3.confirm new password (must match) ->only this one can use the regular laravel validation
        $request->validate([
            'new_password' => 'required|min:8|string|confirmed',
            //confirmed validation is used to check if the two passwords match
            //to use confirmed validation, you need two fields with name1.anyname and name2.anyname_confirmation
        ]);
        $user_a->password = Hash::make($request->new_password);
        //Hash::make() encrypts the password
        $user_a->save();

        return redirect()->back()->with('confirm_success_password','Changed password successfully!');
    }
}
