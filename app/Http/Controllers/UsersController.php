<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = UserResource::collection(
                    User::searchOrFilter(
                        $request->only([
                            'search',
                            'order_by',
                        ]))->orderBy('id', 'asc')->get()
                )->paginate(6);
        return view('users.index', compact('users'));
    }

    public function create(){
      return view('users.create');
    }
}
