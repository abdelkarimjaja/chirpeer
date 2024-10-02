<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Respones;
use Illuminate\Http\View;

class ChirpController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index() 
	{
		//
		return view('chirps.index', [
			'chirps' => Chirp::with('user')->latest()->get(),
		]);
	}


	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//

	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
		$validated = $request->validate([
			'message' => 'required|string|max:255',
		]);

		$request->user()->chirps()->create($validated);

		return redirect(route('chirps.index'));

	}

	/**
	 * Display the specified resource.
	 */
	public function show(Chirp $chirp)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Chirp $chirp)
	{
		// Authorize the user to update the chirp
		Gate::authorize('update', $chirp);

		// Return the edit view for the chirp
		return view('chirps.edit', [
			'chirp' => $chirp,
		]);
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Chirp $chirp)
	{
		// Authorize the user to update the chirp
		Gate::authorize('update', $chirp);

		// Validate the incoming request
		$validated = $request->validate([
			'message' => 'required|string|max:255',
		]);

		// Update the chirp with validated data
		$chirp->update($validated);

		// Redirect to the index route for chirps
		return redirect()->route('chirps.index');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Chirp $chirp)
	{
		//
		Gate::authorize('delete', $chirp);
		
		$chirp->delete();

		return redirect(route('chirps.index'));
	}
}
