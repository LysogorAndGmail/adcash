<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Organization;
use App\Role;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {

        $users   = User::All();
        return response()->json($users);
    }

    public function show(Request $request)
    {
        $user = User::find($request->user);

        return response()->json($user);
    }

    public function store(UserRequest $request)
    {

        $user             = new User();
        $user->full_name  = $request->full_name;
        $user->save();

        info("User id=$user->id created");

        return response()->json(true);
    }

    public function update(UserRequest $request)
    {


        $user             = User::find($request->user);
        $user->full_name      = $request->full_name;
        $user->update();

        info("User id=$user->id updated");

        return response()->json(true);
    }

    public function destroy(Request $request)
    {
        $user             = User::find($request->user);

        info("User id=$user->id deleted");
        $user->delete();

        return response()->json(true);
    }
}
