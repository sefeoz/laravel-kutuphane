<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view("users.index", compact("users"));
    }
    public function create(){
        return view("users.create");
    }
    public function store(UserStoreRequest $request){
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return redirect()->route("users.index")->with("success", "User created successfully");
    }
    public function edit(User $user){
        return view("users.edit", compact("user"));
    }
    public function update(UserUpdateRequest $request, User $user){
        $data = $request->validated();
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Password yoksa array'den çıkar
        }
        
        $user->update($data);
        return redirect()->route("users.index")->with("success", "User updated successfully");
    }
    public function destroy(User $user){
        $user->delete();
        return redirect()->route("users.index")->with("success", "User deleted successfully");
    }
    public function show(User $user) : View{
        return view("users.show", ["user" => $user]);
    }
}
