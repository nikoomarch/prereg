<?php

namespace App\Http\Controllers\GroupManager;

use App\Http\Requests\BulkUserRequest;
use App\Repositories\FieldRepository;
use App\Repositories\TermRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->termRepository = new TermRepository();
        $this->fieldRepository = new FieldRepository();
    }

    public function index(Request $request)
    {
        $maleAllowedCount = $femaleAllowedCount = $totalUsersCount = null;
        $users = $this->userRepository
            ->with('field')
            ->paginateWithSearch(['username' => $request->get('student_code'), 'field_id' => auth()->user()->field_id, 'role' => 'student']);
        $terms = $this->termRepository->all();

        if (!$request->has('student_code')) {
            $totalUsersCount = $this->userRepository->count(['field_id' => auth()->user()->field_id, 'role' => 'student']);
            $maleAllowedCount = $this->userRepository->count(['field_id' => auth()->user()->field_id, 'is_allowed' => true, 'gender' => 'M', 'role' => 'student']);
            $femaleAllowedCount = $this->userRepository->count(['field_id' => auth()->user()->field_id, 'is_allowed' => true, 'gender' => 'F', 'role' => 'student']);
        }
        return view('group_manager.user.index', compact('users', 'maleAllowedCount','femaleAllowedCount', 'terms','totalUsersCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(UserRequest $request)
    {
        $fields = $request->only(['name','family','username','national_code','gender','entrance_term_id','is_allowed'])
            + [
                'field_id' => auth()->user()->field_id,
                'password' => Hash::make($request->input('national_code'))
            ];
        $user = $this->userRepository->create($fields);
        $user->assignRole('student');
        return response(null, 201);
    }

    public function show(User $user)
    {
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
    public function update(UserRequest $request, User $user)
    {
        $fields = $request->only(['name','family','username','national_code','gender','entrance_term_id','is_allowed'])
            + [
                'password' => Hash::make($request->input('national_code'))
            ];
        $this->userRepository->update($user, $fields);
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
        $user->roles()->detach();
        $this->userRepository->delete($user->id);
        return response(null, 204);
    }

    public function createFromFile()
    {
        return view('group_manager.user.bulk');
    }

    public function storeFromFile(BulkUserRequest $request)
    {
        $file = $request->file('excel')->getRealPath();
        $collection = (new FastExcel)->import($file);
        $terms = $this->termRepository->all();
        foreach ($collection as $key => $row) {
            if (!Arr::has($row, [$request['username'], $request['nationalCode'], $request['gender'], $request['entranceTerm']]))
                continue;
            $data = [
                "name" => $row[$request['name']],
                "family" => $row[$request['family']],
                "national_code" => rtrim($row[$request['nationalCode']], '.0'),
                "password" => Hash::make($row[rtrim($request['nationalCode'], '.0')]),
                "username" => rtrim($row[$request['username']], '.0'),
                "gender" => $row[$request['gender']],
                "entrance_term_id" => $terms->where('code',$row[$request['entranceTerm']])->first()->id,
                "field_id" => auth()->user()->field_id,
            ];
            $this->userRepository->updateOrCreate(['username' => $data['username']], $data);
        }
        return to_route('group-manager.user.index')->with('alert', ['message'=> trans('messages.created', ['entity' => 'دانشجوها']), 'icon' => 'success', 'title' => trans('messages.success')]);
    }

    public function bulkDelete(Request $request)
    {
        foreach ($request->get('terms') as $term)
            $this->userRepository->bulkDelete(['field_id' => auth()->user()->field_id, 'entrance_term_id' => $term, 'role' => 'student']);
        return response(null, 204);
    }
}
