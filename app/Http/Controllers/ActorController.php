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
    /**
     * Display a listing of the actors
     *
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /actors
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param \Illuminate\Http\Request $request
     * @return Inertia::render('page')
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchValue' => 'nullable|string',
        ]);
        $searchValue = $request->input('searchValue');
        $query = Actor::orderBy('id', 'desc');
        if ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        }
        $actors = $query->paginate(5);
        return Inertia::render('Actors/index', [
            'actors' => $actors,
        ]);
    }

    /**
     * Display actors create page
     *
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /actors/create
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @return Inertia::render('page')
     */
    public function create()
    {
        return Inertia::render('Actors/create');
    }

    /**
     * Store a new poduction
     *
     * @method POST
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /actors/store
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param \Illuminate\Http\Request $request
     */
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

    /**
     * Display actors edit+delete page
     *
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /actors/{actor}/edit
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integet $id
     */
    public function edit($id)
    {
        $actor = Actor::with('movies')->findOrFail($id);
        return Inertia::render('Actors/edit', [
            'actor' => $actor,
        ]);
    }

    /**
     * update the actor data
     *
     * @method PUT
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /actors/{actor}
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integet $id
     */
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

    /**
     * delete the actor model
     *
     * @method DELETE
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /actors/{actor}
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integet $id
     */
    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);
        $actor->delete();
        return Redirect::route('actors')->with('success', 'Actor Deleted.');
    }

    /**
     * return an array containing actors name
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /actors/all
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     */
    public function allActors()
    {
        $actors = Actor::all();
        return $actors;
    }
}
