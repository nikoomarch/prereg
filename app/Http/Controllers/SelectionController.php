<?php

namespace studentPreRegisteration\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use studentPreRegisteration\Field;
use studentPreRegisteration\Selection;
use Illuminate\Http\Request;
use studentPreRegisteration\Term;
use studentPreRegisteration\User;

class SelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAll',Selection::class);
        $field_id = Auth::user()->field_id;
        $selection = Selection::where('field_id',$field_id)->first();
        $terms = Term::select('code')->get();
        return view('selection.index', compact('terms','selection'));
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
        $this->authorize('create',Selection::class);
        $field_id = $request->post('field_id');
        $selection = Selection::where('field_id',$field_id)->first();
        $fields = $request->only('field_id','startDate','endDate','max','terms');
        $fields['terms'] = $request->post('terms') == null ? [] : $request->post('terms');
        if($selection==null)
            $selection = Selection::create($fields);
        else
            $selection->update($fields);
        User::where('field_id',$selection->field_id)->where('role','student')->update(['isAllowed'=>false]);
        User::where('field_id',$selection->field_id)->where('role','student')->whereIn('entranceTerm',$fields['terms'])->update(['isAllowed'=>true]);
        return back()->with('message',['success','ایجاد/تغییر انتخاب واحد با موفقیت انجام شد.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \studentPreRegisteration\Selection $selection
     * @return \Illuminate\Http\Response
     */
    public function show(Selection $selection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \studentPreRegisteration\Selection $selection
     * @return \Illuminate\Http\Response
     */
    public function edit(Selection $selection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \studentPreRegisteration\Selection $selection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Selection $selection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \studentPreRegisteration\Selection $selection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Selection $selection)
    {
        //
    }
}
