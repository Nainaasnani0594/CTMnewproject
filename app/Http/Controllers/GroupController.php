<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(StoreGroupRequest $request)
    {
        $group = Group::create($request->validated());

        return redirect()->route('projects.show', $group->project_id);
    }
    public function show(Group $group)
    {
        //
    }
    public function edit(Group $group)
    {
        //
    }
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }
    public function destroy(Group $group)
    {
        //
    }
}
