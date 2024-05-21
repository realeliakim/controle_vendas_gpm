<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserRequest;
use App\Models\Section;
use App\Models\UserType;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
                    User::searchOrFilter(
                        $request->only([
                            'search',
                            'order_by',
                        ]))->orderBy('id', 'asc')->get()
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
     * @param App\Http\Requests\CreateUserRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        try {
            $type = UserType::find($request->user_type_id);
            $section = Section::find($request->section_id);
            if (!$type) {
                throw new ModelNotFoundException('Id #'.$request->user_type_id.' não encontrado', 404);
            }
            if (!$section) {
                throw new ModelNotFoundException('Id #'.$request->section_id.' não encontrado', 404);
            }
            $user = User::create($request->all());
            return redirect()->route('users.index')->with('success', 'Usuário '. $user->name .' criado com sucesso');
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }


    /**
    * Delete homepage block type.
    *
    * @param  int $user_id
    * @return Illuminate\Http\JsonResponse
    */
    public function delete(int $user_id): JsonResponse
    {
        try {
            $user = User::find($user_id);

            if (!$user) {
                throw new ModelNotFoundException('Usuário com id #'.$user_id. ' não encontrado', 404);
            }

            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuário '. $user_id .' deletado com sucesso');
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }
}
