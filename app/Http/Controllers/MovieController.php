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
    public function index()
    {
        $movies = Movie::all();
        return Inertia::render('Movies/index', [
            'movies' => $movies,
        ]);
    }

    public function create()
    {
        return Inertia::render('Movies/create');
    }

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

        $actors = Actor::whereIn('name', $request->input('actors'))->pluck('id');

        $movie = Movie::create([
            'title' => $request->input('title'),
            'plot' => $request->input('plot'),
            'runtime' => $request->input('runtime'),
            'released_in' => $request->input('releasedIn'),
            'genre' => json_encode($request->input('genre')),
            'production_id' => $production->id,
        ]);

        // Attach actor IDs to the movie
        $movie->actors()->attach($actors);

        return Redirect::route('movies')->with('success', 'Movie created.');
    }

    public function edit($id)
    {
        $movie = Movie::with('actors')->findOrFail($id);
        return Inertia::render('Movies/edit', [
            'movie' => $movie,
        ]);
    }

    public function update($id, Request $request)
    {
        $movie = Movie::findOrFail($id);
        $request->validate([
            'title' => 'required|string',
            'plot' => 'required|string',
            'genre' => 'required|string',
            'released_in' => 'required|integer|between:1980,2024',
            'runtime' => 'required|integer|between:30,350',
        ]);
        $movie->update($request->only('title', 'plot', 'released_in', 'runtime') + ['genre' => json_encode($request->input('genre'))]);
        return Redirect::route('movies')->with('success', 'Movie updated.');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return Redirect::route('movies');
    }
}
