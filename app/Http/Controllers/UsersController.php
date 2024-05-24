<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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
     * Show the users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = UserResource::collection(
                    User::all()->sortDesc()
                )->paginate(6);
        return view('users.index', compact('users'));
    }

    /**
     * Show the user creation form.
     *
     */
    public function showCreateForm()
    {
        return view('users.user_form');
    }


    /**
     * Create an user
     *
     * @param App\Http\Requests\CreateUserRequest $request
     */
    public function create(CreateUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return redirect()->to(route('users'))->with('success', 'Usuário '. $user->name .' criado com sucesso');
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
    * View an user.
    *
    * @param int $user_id
    */
    public function view(int $user_id)
    {
        try {
            $user = User::find($user_id);

            if (!$user) {
                throw new ModelNotFoundException('Usuário não encontrado', 404);
            }

            $user = UserResource::make($user);
            return view('users.view', compact('user'));
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
    * Update an user.
    * @param   int  $user_id
    * @param	 App\Http\Requests\Admin\CreateSaleRequest	$request
    */
    public function update(UpdateUserRequest $request, int $user_id)
    {
        try {
            $user = User::find($user_id);

            if (!$user) {
                throw new ModelNotFoundException('Usuário não encontrado', 404);
            }

            $user->update($request->validated());
            return redirect()->to(route('users'))->with('success', 'Usuário '. $user->name .' atualizado com sucesso');
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
    * Delete an user.
    *
    * @param  int $user_id
    */
    public function delete(int $user_id)
    {
        try {
            $user = User::find($user_id);

            if (!$user) {
                throw new ModelNotFoundException('Usuário com id #'.$user_id. ' não encontrado', 404);
            }

            $user->delete();
            return redirect()->to(route('users'))->with('success', 'Usuário '. $user_id .' deletado com sucesso');
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }
}
