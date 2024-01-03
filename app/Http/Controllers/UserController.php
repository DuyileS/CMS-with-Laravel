<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show(User $user){
        return view('admin.user.profile', 
        ['user'=> $user,
         'roles' => Role::all()
        ]);
    }

    public function update(User $user, Request $request){
     
        $inputs = request()->validate([
            'username'=>['required', 'string', 'max:255', 'alpha_dash'],
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'email', 'max:255'],
            'avatar'=>['required','mimes:jpg,png,jpeg|max:5048']
        ]);

        if(request('avatar')){
            $imageName = time(). '-' . $request->name. '.'. $request->avatar->extension();    
            
            $inputs['avatar'] = $imageName;
            $request->avatar->move(public_path('images'), $imageName);
        }
       
        

        $user->update($inputs);
        return back();

    }


    public function attach(User $user){
        $user->roles()->attach(request('role'));
        return back();
    }

    public function detach(User $user){
        $user->roles()->detach(request('role'));
        return back();
    }


    public function index(User $user){
        $users = User::all();
        return view('admin.user.index', ['users'=>$users]);
    }

    // private function storeImage($request){
    //     $newImageName = uniqid(). '-'. $request->title;
    // }

    public function destroy(User $user){
        $user->delete();
        session()->flash('user-deleted', 'User has been deleted');
        return back();
    }
        
}
