<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Validation\Rule;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::all();
        return Inertia::render('Actors/index', [
            'actors' => $actors,
        ]);
    }

    public function create()
    {
        return Inertia::render('Actors/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:actors,email',
            'contact' => 'required|string',
        ]);
        Actor::create($request->all());
        return Redirect::route('actors')->with('success', 'Actor created.');
    }

    public function edit($id)
    {
        $actor = Actor::with('movies')->findOrFail($id);
        return Inertia::render('Actors/edit', [
            'actor' => $actor,
        ]);
    }

    public function update($id, Request $request)
    {
        $actor = Actor::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'string', Rule::unique('actors', 'email')->ignore($actor->id)],
            'contact' => 'required|string',
        ]);
        $actor->update($request->all());
        return Redirect::route('actors')->with('success', 'Actor updated.');
    }

    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);
        $actor->delete();
        return Redirect::route('actors');
    }

    public function allActors()
    {
        $actors = Actor::pluck('name');
        return $actors;
    }
}
