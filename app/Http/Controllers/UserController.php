<?php

namespace studentPreRegisteration\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use studentPreRegisteration\Field;
use studentPreRegisteration\Http\Requests\UserRequest;
use studentPreRegisteration\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['test']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'student')
            abort(403);
        if (Auth::user()->role == 'admin') {
            $users = User::select('id', 'name', 'family', 'field_id', 'username', 'nationalCode')->where('role', '=', 'groupManager')->with('field')->paginate(20);
            $fields = Field::select('id', 'name')->get();
            return view('users.index', compact('users', 'fields'));
        } else if (Auth::user()->role == 'groupManager') {
            $users = User::select('id', 'name', 'family', 'field_id', 'gender', 'username', 'nationalCode', 'entranceTerm', 'isAllowed')->where('role', '=', 'student')->where('field_id', Auth::user()->field_id)->with('field')->paginate(20);
            return view('users.group_index', compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fillable = $request->except('_token');
        $fillable['password'] = Hash::make($request->post('nationalCode'));
        if ($request->post('role') == 'groupManager')
            $fillable['isAllowed'] = true;
        User::create($fillable);
        if ($fillable['role'] == 'groupManager')
            return back()->with('message', ['success', 'ثبت مدیر گروه با موفقیت انجام شد.']);
        elseif ($fillable['role'] == 'student')
            return back()->with('message', ['success', 'ثبت دانشجو با موفقیت انجام شد.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \studentPreRegisteration\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \studentPreRegisteration\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \studentPreRegisteration\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->except('_token'));
        $user->password = Hash::make($request->post('nationalCode'));
        $user->save();
        if ($user->role == 'groupManager')
            return back()->with('message', ['success', 'تغییرات مدیر گروه با موفقیت انجام شد.']);
        elseif ($user->role == 'student')
            return back()->with('message', ['success', 'تغییرات دانشجو با موفقیت انجام شد.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \studentPreRegisteration\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 204);
    }

    public function test()
    {
        $password = Hash::make('0020247141');
        User::create(['username' => '0020247141', 'password' => $password, 'name' => 'مهران', 'family' => 'نیکوبیان', 'role' => 'admin']);
        return "done!";
    }

    public function createFromFile()
    {
        return view('users.bulk');
    }

    public function storeFromFile(Request $request)
    {
        $fields = $request->except(['_token', 'excel']);
        $client = new Client();
        $request->validate([
            'excel' => 'required'
        ]);
        $file = $request->file('excel');
        $response = $client->request('POST', '127.0.0.1:9000/get-file', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'multipart' => [
                [
                    'name' => 'excel',
                    'contents' => fopen($file->getRealPath(), 'r')
                ]
            ]
        ]);
        $result = json_decode($response->getBody()->getContents());
        $cols = $result->columns;
        $keys = [];
        foreach ($cols as $i => $col) {
            $key = array_search($col, $fields);
            $keys[$key] = $i;
        }
        foreach ($result->data as $key => $row) {
            $data = [
                "name" => $row[$keys['name']],
                "family" => $row[$keys['family']],
                "nationalCode" => $row[$keys['nationalCode']],
                "password" => Hash::make($row[$keys['nationalCode']]),
                "username" => $row[$keys['username']],
                "gender" => $row[$keys['gender']],
                "entranceTerm" => $row[$keys['entranceTerm']],
                "field_id" => Auth::user()->field_id,
                "role" => "student"
            ];
            User::updateOrCreate(['username' => $row[$keys['username']]], $data);
        }
        return redirect()->route('user.index')->with('message', ['success', 'ثبت گروهی دانشجو با موفقیت انجام شد.']);
    }
}