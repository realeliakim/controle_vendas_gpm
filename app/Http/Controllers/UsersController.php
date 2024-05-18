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
        $data = UserResource::collection(
                    User::searchOrFilter(
                        $request->only([
                            'search',
                            'order_by',
                        ])
                    )->get()
                )->paginate(6);
        $users = $data['data'];
        return view('users.index', compact('users'));
    }

    public function create(){
      return view('users.create');
    }
}
