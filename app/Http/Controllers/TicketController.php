<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $user = Auth::user();
    
    $tickets = $user->tickets()
    ->with(['event', 'seat'])
    ->join('events', 'tickets.event_id', '=', 'events.id')
    ->orderBy('events.event_date_at', 'asc')
    ->select('tickets.*')
    ->paginate(10);

    return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.ticketform');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'event_id' => 'required|exists:events,id',
        'seat_ids' => 'required|array',
        'seat_ids.*' => 'exists:seats,id',
    ], [
        'required' => ':attribute mező kitöltése kötelező!',
        'array' => ':attribute mezőnek tömbnek kell lennie!',
        'exists' => 'A kiválasztott :attribute érvénytelen!',
    ], [
        'event_id' => 'Esemény',
        'seat_ids' => 'Ülőhelyek',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $validated = $validator->validated();

    $event = Event::findOrFail($validated['event_id']);
    $user = Auth::user();

    $alreadybought = $event->tickets()->where('user_id', $user->id)->count();
    $remainingtickets = $event->max_number_allowed - $alreadybought;

    if (count($validated['seat_ids']) > $remainingtickets) {
        return redirect()->back()->withErrors(['seat_ids' => "Több jegyet választottál, mint amennyit vásárolhatsz!"])->withInput();
    }

    $tickets = [];
    foreach ($validated['seat_ids'] as $seatId) {
        $seat = Seat::findOrFail($seatId);

        $exists = Ticket::where('event_id', $event->id)
            ->where('seat_id', $seat->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['seat_ids' => "Az ülőhely {$seat->seat_number} már foglalt!"])
                ->withInput();
        }

        if ($event->is_dynamic_price) {
            $totalSeats = Seat::count();
            $bookedSeats = $event->tickets()->count();
            $occupancy = $totalSeats > 0 ? $bookedSeats / $totalSeats : 0;
            $daysUntil = max($event->event_date_at->diffInDays(now()), 1);

            $price = $seat->base_price * (1 + (1 - $daysUntil / 30)) * (1 + $occupancy);
            
        } else {
            $price = $seat->base_price;
        }

        $tickets[] = Ticket::create([
            'barcode' => mt_rand(100000000, 999999999),
            'admission_time' => null,
            'user_id' => $user->id,
            'event_id' => $event->id,
            'seat_id' => $seat->id,
            'price' => $price,
        ]);
    }

    return redirect()->route('tickets.index')
        ->with('success', count($tickets) . ' jegy sikeresen megvásárolva!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Scanning the tickets
     */

    public function scanform()
    {
      return view('tickets.scan');
    }
    /**
     * Checking if barcode is scanned
     * Admissioning ticket if not scanned
     */

public function scansubmit(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string|size:9',
        ]);

        $ticket = Ticket::where('barcode', $request->barcode)->first();

        if (!$ticket) {
            return back()->with('error', 'Nem található jegy ezzel a vonalkóddal.');
        }

        if ($ticket->admission_time) {
            return back()->with('error', 'A jegyet már beolvasták: ' . $ticket->admission_time->format('Y-m-d H:i:s'));
        }

        $ticket->admission_time = now();
        $ticket->save();

        return back()->with('success', 'Jegy sikeresen beolvasva: ' . $ticket->admission_time->format('Y-m-d H:i:s'));
    }



}
