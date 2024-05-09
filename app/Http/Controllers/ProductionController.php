<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Production;

class ProductionController extends Controller
{
    public function index()
    {
        try {
            // $productions = Production::paginate(5)->through(function ($production) {
            //     return [
            //         'Name' => $production->name,
            //         'City' => $production->city,
            //         'Email' => $production->email,
            //         'Phone' => $production->phone,
            //     ];
            // });
            $productions = Production::all();
            return Inertia::render('Productions/index', [
                'productions' => $productions,
            ]);
        } catch (\Throwable $th) {
            return response()->json($th, $headers);
        }
    }

    //     $items = Item::paginate(15)->through(function ($item) {
    //     return [
    //         'id' => $item->id,
    //         'name' => $item->name,
    //         // etc
    //     ];
    // });

    // return Inertia::render('Rentals/Items', ['items' => $items]);

    public function create()
    {
        return Inertia::render('Productions/create');
    }

    public function store(Request $request)
    {
        Production::create(
            $request->validate([
                'name' => 'string|required',
                'email' => 'string|required',
                'phone' => 'string|required',
                'address' => 'string|required',
                'city' => 'string|required',
                'country' => 'string|required',
            ]),
        );
        return Redirect::route('productions')->with('success', 'Production created.');
    }

    public function edit($id)
    {
        $production = Production::with('movies')->findOrFail($id);
        return Inertia::render('Productions/edit', [
            'production' => $production,
        ]);
    }

    public function update($id, Request $request)
    {
        $production = Production::findOrFail($id);
        $production->update(
            $request->validate([
                'name' => 'string|required',
                'email' => 'string|required',
                'phone' => 'string|required',
                'address' => 'string|required',
                'city' => 'string|required',
                'country' => 'string|required',
            ]),
        );
        return Redirect::route('productions')->with('success', 'Production updated.');
    }

    public function destroy($id)
    {
        $production = Production::findOrFail($id);
        $production->delete();
        return Redirect::route('productions')->with('success', 'Production deleted.');
    }

    public function productions()
    {
        $productions = Production::pluck('name');
        return $productions;
    }
}
