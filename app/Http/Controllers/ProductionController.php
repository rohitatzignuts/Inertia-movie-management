<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Production;

class ProductionController extends Controller
{
    /**
     * Display listing of all the productions
     *
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /productions
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param \Illuminate\Http\Request $request
     * @return Inertia::render('page')
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'searchValue' => 'nullable|string',
            ]);
            $searchValue = $request->input('searchValue');
            $query = Production::orderBy('id', 'desc');
            if ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            }
            $productions = $query->paginate(5);
            return Inertia::render('Productions/index', [
                'productions' => $productions,
            ]);
        } catch (\Throwable $th) {
            return response()->json($th, $headers);
        }
    }

    /**
     * Display the create production page
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /productions/create
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @return Inertia::render('page')
     */
    public function create()
    {
        return Inertia::render('Productions/create');
    }

    /**
     * store the newly created production
     * @method POST
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /productions
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param \Illuminate\Http\Request $request
     * @return Inertia::render('page')
     */
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

    /**
     * display the edit+delete page for the production
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /productions/{production}/edit
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integer $id
     */
    public function edit($id)
    {
        $production = Production::with('movies')->findOrFail($id);
        return Inertia::render('Productions/edit', [
            'production' => $production,
        ]);
    }

    /**
     * update the production model
     * @method PUT
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /productions
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param \Illuminate\Http\Request $request, Integer $id
     */
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

    /**
     * delete the production model
     * @method DELETE
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /productions/{production}
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     * @param Integer $id
     */
    public function destroy($id)
    {
        $production = Production::findOrFail($id);
        $production->delete();
        return Redirect::route('productions')->with('success', 'Production deleted.');
    }

    /**
     * return an array containing production names
     * @method GET
     * @author Rohit Vispute (Zignuts Technolab)
     * @route /productions/all
     * @authentication Requires user authentication
     * @middleware sanctum:auth,verified
     */
    public function productions()
    {
        $productions = Production::pluck('name');
        return $productions;
    }
}
