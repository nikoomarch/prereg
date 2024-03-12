<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermRequest;
use App\Models\Term;
use App\Repositories\TermRepository;

class TermController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Term::class);
        $this->termRepository = new TermRepository();
    }

    public function index()
    {
        $terms = $this->termRepository->paginate(20);
        return view('admin.term.index',compact('terms'));
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

    public function store(TermRequest $request)
    {
        $this->termRepository->create($request->only(['code']));
        return response(null,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $term
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
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TermRequest $request, Term $term)
    {
        $this->termRepository->update($term, $request->only('code'));
        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        $this->termRepository->delete($term->id);
        return response(null,204);
    }
}
