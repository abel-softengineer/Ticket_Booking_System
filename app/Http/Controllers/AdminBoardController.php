<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Seat;


class AdminBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalevents = Event::count();
        $totaltickets = Ticket::count();
        $totalrevenue = Ticket::sum('price');
        $seats = Seat::all();
        $topseats = Ticket::select('seat_id')
            ->selectRaw('COUNT(*) as count_sold')
            ->groupBy('seat_id')
            ->orderByDesc('count_sold')
            ->with('seat')
            ->take(3)
            ->get();
        $events = Event::withCount('tickets')->paginate(5);
        return view('adminboard.index', compact(
            'totalevents',
            'totaltickets',
            'totalrevenue',
            'topseats',
            'seats',
            'events'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           return view('adminboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
