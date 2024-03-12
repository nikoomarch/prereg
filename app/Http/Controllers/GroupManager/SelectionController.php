<?php

namespace App\Http\Controllers\GroupManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\SelectionRequest;
use App\Models\Selection;
use App\Repositories\SelectionRepository;
use App\Repositories\TermRepository;
use App\Repositories\UserRepository;

class SelectionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Selection::class);
        $this->selectionRepository = new SelectionRepository();
        $this->termRepository = new TermRepository();
        $this->userRepository = new UserRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $selections = $this->selectionRepository->search(['field' => auth()->user()->field_id]);
        $terms = $this->termRepository->all();

        return view('group_manager.selection.index', compact('terms', 'selections'));
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(SelectionRequest $request)
    {
        $fields = $request->only('start_date', 'end_date', 'max', 'term', 'is_active') + ['field_id' => auth()->user()->field_id];
        if ($fields['is_active'])
            $this->selectionRepository->deactiveFieldSelections(auth()->user()->field_id);
        $selection = $this->selectionRepository->create($fields);

        $terms = [];
        foreach ($request->input('terms') as $term){
            list($id, $gender) = explode('-', $term);
            $terms[$id] = ['gender' => $gender];
        }
        $selection->allowedTerms()->attach($terms);

        if ($fields['is_active']){
            $this->userRepository->updateStudentsPermission(['field_id' => auth()->user()->field_id], false);
            foreach ($terms as $id => $term)
                $this->userRepository->updateStudentsPermission(['field_id' => auth()->user()->field_id, 'gender' => $term['gender'], 'entrance_term_id' => $id], true);
        }

        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Selection $selection
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Selection $selection)
    {
        $selection->load('allowedTerms');
        return response()->json($selection);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Selection $selection
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
     * @param \App\Models\Selection $selection
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(SelectionRequest $request, Selection $selection)
    {
        $fields = $request->only('field_id', 'start_date', 'end_date', 'max', 'term', 'is_active');
        if ($fields['is_active'])
            $this->selectionRepository->deactiveFieldSelections(auth()->user()->field_id);

        $this->selectionRepository->update($selection, $fields);

        $terms = [];
        foreach ($request->input('terms') as $term){
            list($id, $gender) = explode('-', $term);
            $terms[] = ['term_id' => $id, 'gender' => $gender];
        }
        $selection->allowedTerms()->sync($terms);

        if ($fields['is_active']) {
            $this->userRepository->updateStudentsPermission(['field_id' => $selection->field_id], false);
            foreach ($terms as $term)
                $this->userRepository->updateStudentsPermission(['field_id' => $selection->field_id, 'gender' => $term['gender'], 'entrance_term_id' => $term['term_id']], true);
        }

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Selection $selection
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Selection $selection)
    {
        $this->selectionRepository->delete($selection->id);
        return response()->json(null, 204);
    }
}
