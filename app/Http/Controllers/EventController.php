<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('event_date_at', '>', now())
            ->orderBy('event_date_at', 'asc')
            ->paginate(5);

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

        public function store(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:256',
            'description' => 'required|string|max:1000',
            'event_date_at' => 'required|date|after:now',
            'sale_start_at' => 'required|date|before_or_equal:sale_end_at',
            'sale_end_at' => 'required|date|after_or_equal:sale_start_at',
            'is_dynamic_price' => 'required|boolean',
            'max_number_allowed' => 'required|integer|min:1',
            'cover_image' => 'nullable|image',
        ], [
            'required' => ':attribute mező kitöltése kötelező!',
            'string' => ':attribute mező csak szöveget tartalmazhat!',
            'max' => ':attribute mező maximum :max karakter lehet!',
            'date' => ':attribute mezőnek érvényes dátumnak kell lennie!',
            'after' => ':attribute mezőnek a jelenlegi dátum után kell lennie!',
            'before_or_equal' => ':attribute mezőnek a befejezés előtt vagy azon a napon kell lennie!',
            'after_or_equal' => ':attribute mezőnek a kezdés után vagy azon a napon kell lennie!',
            'integer' => ':attribute mező csak egész szám lehet!',
            'min' => ':attribute mező minimum :min lehet!',
            'boolean' => ':attribute mezőnek igaz/hamis értékűnek kell lennie!',
            'image' => ':attribute mezőnek képnek kell lennie!',
        ], [
            'title' => 'Cím',
            'description' => 'Leírás',
            'event_date_at' => 'Esemény kezdete',
            'sale_start_at' => 'Jegyvásárlás kezdete',
            'sale_end_at' => 'Jegyvásárlás vége',
            'is_dynamic_price' => 'Dinamikus ár',
            'max_number_allowed' => 'Max. jegyszám',
            'cover_image' => 'Borítókép',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $event = Event::create($validated);

        if ($request->hasFile('cover_image'))
        {
            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $event->cover_image = $filename;
            $event->save();
        }


        return redirect(route('events.show', $event->id))->with('success', 'Esemény sikeresen létrehozva.');
    }

    public function create()
    {   
     if (!Auth::user()->admin) {
        abort(401);
    }

    return view('events.create');
    }

    public function destroy(Event $event)
{
    if (!Auth::user()->admin) {
        abort(401);
    }

    $soldTickets = $event->tickets()->count();

    if ($soldTickets > 0) {
        return redirect()->back()->with('error', 'Az esemény nem törölhető, mert már értékesítettek rá jegyeket.');
    }

    //if ($event->cover_image_hash) {
      //  \Storage::delete($event->cover_image_hash);
   // }

    $event->delete();

    return redirect()->route('adminboard.index')->with('success', 'Esemény törölve.');
}

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, Event $event)
{
    if (!Auth::user()->admin) {
        abort(401);
    }

    $saleStarted = now()->greaterThanOrEqualTo($event->sale_start_at);

    if ($saleStarted) {
        $rules = [
            'title' => 'required|string|max:256',
            'description' => 'required|string|max:1000',
            'cover_image' => 'nullable|image'
        ];
    } else {
        $rules = [
            'title' => 'required|string|max:256',
            'description' => 'required|string|max:1000',
            'event_date_at' => 'required|date|after:now',
            'sale_start_at' => 'required|date|before_or_equal:sale_end_at',
            'sale_end_at' => 'required|date|after_or_equal:sale_start_at',
            'is_dynamic_price' => 'required|boolean',
            'max_number_allowed' => 'required|integer|min:1',
            'cover_image' => 'nullable|image',
        ];
    }

    $messages = [
        'required' => ':attribute mező kitöltése kötelező!',
        'string' => ':attribute mező csak szöveget tartalmazhat!',
        'max' => ':attribute mező maximum :max karakter lehet!',
        'date' => ':attribute mezőnek érvényes dátumnak kell lennie!',
        'after' => ':attribute mezőnek a jelenlegi dátum után kell lennie!',
        'before_or_equal' => ':attribute mezőnek a befejezés előtt vagy azon a napon kell lennie!',
        'after_or_equal' => ':attribute mezőnek a kezdés után vagy azon a napon kell lennie!',
        'integer' => ':attribute mező csak egész szám lehet!',
        'min' => ':attribute mező minimum :min lehet!',
        'boolean' => ':attribute mezőnek igaz/hamis értékűnek kell lennie!',
        'image' => ':attribute mezőnek képnek kell lennie!',
    ];

    $attributes = [
        'title' => 'Cím',
        'description' => 'Leírás',
        'event_date_at' => 'Esemény kezdete',
        'sale_start_at' => 'Jegyvásárlás kezdete',
        'sale_end_at' => 'Jegyvásárlás vége',
        'is_dynamic_price' => 'Dinamikus ár',
        'max_number_allowed' => 'Max. jegyszám',
        'cover_image' => 'Borítókép',
    ];

    $validator = Validator::make($request->all(), $rules, $messages, $attributes);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $validated = $validator->validated();

    if ($saleStarted) {
        unset($validated['event_date_at']);
        unset($validated['sale_start_at']);
        unset($validated['sale_end_at']);
        unset($validated['is_dynamic_price']);
        unset($validated['max_number_allowed']);
    }

    if ($request->hasFile('cover_image')) {
        if ($event->cover_image) {
            $old = public_path('images/' . $event->cover_image);
            if (file_exists($old)) {
                unlink($old);
            }
        }

        $file = $request->file('cover_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $validated['cover_image'] = $filename;
    }

    $event->update($validated);

    return redirect()->route('events.show', $event->id)->with('success', 'Esemény módosítva.');
}




    public function edit(Event $event)
{
    if (!Auth::user()->admin) {
        abort(401);
    }

    return view('events.edit', compact('event'));
}


}
