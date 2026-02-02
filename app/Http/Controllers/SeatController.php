<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->admin) {
        abort(401);
    }

    $seats = Seat::withCount('tickets')->paginate(10);
    return view('adminboard.index', compact('seats'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->admin) {
        abort(401);
    }

    return view('seat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->admin) {
        abort(401);
    }

    $validator = Validator::make($request->all(), [
        'seat_number' => 'required|string|regex:/^[A-Za-z][0-9]{3}$/',
        'base_price' => 'required|integer|min:3000|max:5000',
    ], [
        'required' => ':attribute mező kitöltése kötelező!',
        'string' => ':attribute mező csak szöveget tartalmazhat!',
        'min' => ':attribute legyen minimum: :min',
        'max' => ':attribute legyen maximum: :max',
        'seat_number.regex' => 'Az ülőhely formátuma: 1 betű + 3 számjegy (pl. A123)',
        'integer' => ':attribute mező csak egész számot tartalmazhat!',
    ], [
        'seat_number' => 'Ülőhely kódja',
        'base_price' => 'Alap ár',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    $validated = $validator->validated();

    $seat = Seat::create([
        'seat_number' => $validated['seat_number'],
        'base_price' => $validated['base_price'],
    ]);

    return redirect()->route('adminboard.index')->with('success', 'Új ülőhely sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $seat = Seat::find($id);

            if(!$seat) {
                abort(404);
            }

            if(!Auth::user()->admin && !$seat->users->contains(Auth::user())) {
                abort(401);
            }

        
            return view('seat.show', ['seat' => $seat]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $seat = Seat::findOrFail($id);

        if (!Auth::user()->admin) {
            abort(401);
        }

        return view('seat.edit', compact('seat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $seat = Seat::findOrFail($id);

        if(!Auth::user()->admin && !$seat->users->contains(Auth::user())) {
            abort(401);
        }


        if ($request->has('cancel')) {
        return redirect()->route('adminboard.index');
        }

        $validator = Validator::make($request->all(), [
            'seat_number' => 'required|string|regex:/^[A-Za-z][0-9]{3}$/',
            'base_price' => 'required|integer|min:2000|max:20000',
        ], [
            'required' => ':attribute mező kitöltése kötelező!',
            'string' => ':attribute mező csak szöveget tartalmazhat!',
            'min' => ':attribute legyen minimum: :min',
            'max' => ':attribute legyen maximum: :max',
            'seat_number.regex' => 'Az ulőhely helye formátuma: 1 betű + 3 számjegy pl. A123',
            'integer' => ':attribute mező csak egész számot tartalmazhat!',
        ], [
            'seat_number' => 'Ulohely helye',
            'base_price' => 'A priorítás',
        ]);

        if ($validator->fails()) {
            return redirect(route('seat.edit', ['seat' => $seat->id]))->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();


        $seat->update($validated);

        return redirect()->route('adminboard.index')->with('success', 'Ülőhely sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seat = Seat::findOrFail($id);

        if(!Auth::user()->admin) {
            abort(401);
        }

        if ($seat->tickets()->count() > 0) {
            return redirect()->back()->with('error', 'Nem törölhető, már van hozzárendelt jegy.');
        }

        $seat->delete();

        return redirect()->route('adminboard.index')->with('success', 'Ülőhely sikeresen törölve!');
    }
}
