<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseTrait;

    public function list($id)
    {
        $user = User::with('books','reviews','orderedBooks')->where('id',$id)->get();
        return $this->returnResponse(true,'Data',$user);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'                  => 'required|max:40|string',
            'email'                 => 'required|email|max:40|unique:users,email',
            'role'                  => 'in:author,user',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $user = User::create($request->only(['name','email','role'])+[
            'password'  => Hash::make($request->password)
        ]);
        return $this->returnResponse(true, 'user Added Successfully', $user);
    }

    public function show()
    {
        $users = User::all();
        if ($users)
            return $this->returnResponse(true, 'users', $users);
        else
            return $this->returnResponse(false, 'users not found');
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'            => 'numeric|exists:users,id',
            'name'          => 'max:40|string',
            'email'         => 'email|max:40|unique:users,email',
            'role'          => 'in:author,user',
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $id = $request->id;
        $user = User::where('id',$id)->first();
        
        $name   = $request->name  ? $request->name  : $user->name;
        $email  = $request->email ? $request->email : $user->email;
        $role   = $request->role  ? $request->role  : $user->role;

        $user->update([
            'name'              => $name,
            'email'             => $email,
            'role'              => $role
        ]);

        return $this->returnResponse(true, 'user Updated Successfully', $user);
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        return $this->returnResponse(true, 'user Deleted Successfully');
    }


}
