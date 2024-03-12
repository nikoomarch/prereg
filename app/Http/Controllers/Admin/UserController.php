<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminUserRequest;
use App\Repositories\FieldRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->fieldRepository = new FieldRepository();
    }

    public function index()
    {
        $users = $this->userRepository->with('field')->paginateWithSearch(['role' => 'group_manager']);
        $fields = $this->fieldRepository->all();
        return view('admin.user.index', compact('users', 'fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AdminUserRequest $request)
    {
        $field = $this->fieldRepository->create(["name" => $request->input('field')]);
        $fields = $request->only(['name','family','username']) + ['password' => Hash::make($request->input('password'))];
        $user = $field->users()->create($fields);
        $user->assignRole('group_manager');
        return response(null, 201);
    }

    public function show(User $user)
    {
        $user->load('field');
        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(AdminUserRequest $request, User $user)
    {
        $fields = $request->only(['name','family','username']);
        if ($request->has('password'))
            $fields += ['password' => Hash::make($request->input('password'))];
        $this->userRepository->update($user, $fields);
        $user->field()->update(["name" => $request->input('field')]);
        return response(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $user->field()->delete();
        $user->roles()->detach();
        $this->userRepository->delete($user->id);
        return response(null, 204);
    }
}
