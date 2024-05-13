<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Production;
use App\Models\Actor;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class MovieController extends Controller
{
    /**
     * Display listing of all the movies
     *
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /movies
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
        $query = Movie::orderBy('id', 'desc');
        if ($searchValue) {
            $query->where('title', 'like', '%' . $searchValue . '%');
        }
        $movies = $query->paginate(5);
        return Inertia::render('Movies/index', [
            'movies' => $movies,
        ]);
    }

    /**
     * Display the create movie page
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /movies/create
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param \Illuminate\Http\Request $request
     * @return Inertia::render('page')
     */
    public function create()
    {
        return Inertia::render('Movies/create');
    }

    /**
     * store a newly created movie
     * @method POST
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /movies
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'plot' => 'required|string',
            'genre' => 'required|string',
            'releasedIn' => 'required|integer|between:1980,2024',
            'runtime' => 'required|integer|between:30,350',
            'production' => 'required|string',
            'actors' => 'required|array',
        ]);

        $production = Production::where('name', $request->input('production'))->firstOrFail();
        $actorNames = array_map(function ($actor) {
            return $actor['name'];
        }, $request->input('actors'));

        $actorIds = Actor::whereIn('name', $actorNames)->pluck('id')->toArray();

        $movie = Movie::create([
            'title' => $request->input('title'),
            'plot' => $request->input('plot'),
            'runtime' => $request->input('runtime'),
            'released_in' => $request->input('releasedIn'),
            'genre' => json_encode($request->input('genre')),
            'production_id' => $production->id,
        ]);

        // Attach actor IDs to the movie
        $movie->actors()->attach($actorIds);

        return Redirect::route('movies')->with('success', 'Movie created.');
    }

    /**
     * Display the edit+delte page for a movie
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /movies/{movie}/edit
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integer $id
     */
    public function edit($id)
    {
        $movie = Movie::with('actors')->findOrFail($id);
        return Inertia::render('Movies/edit', [
            'movie' => $movie,
        ]);
    }

    /**
     * update the movie data
     * @method PUT
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /movies/{movie}
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integer $id, Request $request
     */
    public function update($id, Request $request)
    {
        $movie = Movie::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'plot' => 'required|string',
            'genre' => 'required|string',
            'released_in' => 'required|integer|between:1980,2024',
            'runtime' => 'required|integer|between:30,350',
            'actors' => 'required|array',
        ]);

        // Extract actor names from the array of objects
        $actorNames = array_map(function ($actor) {
            return $actor['name'];
        }, $request->input('actors'));

        // Find actor IDs based on names
        $actorIds = Actor::whereIn('name', $actorNames)->pluck('id')->toArray();

        // Update the movie with the new data
        $movie->update($request->only('title', 'plot', 'released_in', 'runtime') + ['genre' => json_encode($request->input('genre'))]);

        // Sync the actors for the movie
        $movie->actors()->sync($actorIds);

        return Redirect::route('movies')->with('success', 'Movie updated.');
    }

    /**
     * delete the movie model
     * @method DELETE
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /movies/{movie}
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integer $id
     */
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return Redirect::route('movies')->with('success', 'Movie deleted.');
    }
}
