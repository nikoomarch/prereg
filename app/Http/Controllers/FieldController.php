<?php

namespace studentPreRegisteration\Http\Controllers;

use foo\bar;
use studentPreRegisteration\Field;
use Illuminate\Http\Request;
use studentPreRegisteration\Http\Requests\FieldRequest;
use studentPreRegisteration\Term;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAll',Field::class);
        $fields = Field::select('id','name')->paginate(20);
        return view('field.index',compact('fields'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FieldRequest $request)
    {
        $this->authorize('create',Field::class);
        Field::create($request->except('_token'));
        return back()->with('message',['success','ثبت رشته با موفقیت انجام شد.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \studentPreRegisteration\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \studentPreRegisteration\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \studentPreRegisteration\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(FieldRequest $request, Field $field)
    {
        $this->authorize('update',$field);
        $field->update($request->only('name'));
        return back()->with('message',['success','تغییر رشته با موفقیت انجام شد.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \studentPreRegisteration\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        $this->authorize('delete',$field);
        $field->delete();
        return response(null,204);
    }
}
