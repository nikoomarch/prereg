<?php

namespace studentPreRegisteration\Http\Controllers;

use studentPreRegisteration\Http\Requests\TermRequest;
use studentPreRegisteration\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAll',Term::class);
        $terms = Term::select('code')->paginate(20);
        return view('term.index',compact('terms'));
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
    public function store(TermRequest $request)
    {
        $this->authorize('create',Term::class);
        Term::create($request->except('_token'));
        return back()->with('message',['success','ثبت ترم با موفقیت انجام شد.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \studentPreRegisteration\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \studentPreRegisteration\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $term)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \studentPreRegisteration\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(TermRequest $request, Term $term)
    {
        $this->authorize('edit',$term);
        $term->update($request->except('_token'));
        return back()->with('message',['success','تغییر ترم با موفقیت انجام شد.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \studentPreRegisteration\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        $this->authorize('delete',$term);
        $term->delete();
        return response(null,204);
    }
}
