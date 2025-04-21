<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            $events = Event::where('status', 'approved')
                ->where('event_date', '>=', now())
                ->orderBy('event_date')
                ->get();
        } elseif ($user->isClub()) {
            $events = Event::where('created_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $events = Event::orderBy('created_at', 'desc')->get();
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Event creation request received', $request->all());
            
            $request->validate([
                'event_name' => ['required', 'string', 'max:255'],
                'club_name' => ['required', 'string', 'max:255'],
                'event_date' => ['required', 'date', 'after:today'],
                'venue' => ['required', 'string', 'max:255'],
                'needs_stalls' => ['required', 'boolean'],
                'number_of_stalls' => ['required_if:needs_stalls,true', 'integer', 'min:1'],
                'registration_form_link' => ['required', 'url'],
            ]);

            \Log::info('Validation passed');

            $eventData = [
                'event_name' => $request->event_name,
                'club_name' => $request->club_name,
                'event_date' => $request->event_date,
                'venue' => $request->venue,
                'needs_stalls' => $request->boolean('needs_stalls'),
                'number_of_stalls' => $request->boolean('needs_stalls') ? $request->number_of_stalls : null,
                'registration_form_link' => $request->registration_form_link,
                'status' => 'pending',
                'created_by' => Auth::id(),
            ];

            \Log::info('Event data prepared', $eventData);

            $event = Event::create($eventData);
            \Log::info('Event created successfully', ['event_id' => $event->id]);

            return redirect()->route('events.index')
                ->with('success', 'Event created successfully. Waiting for admin approval.');
        } catch (\Exception $e) {
            \Log::error('Error creating event: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create event. Please try again.');
        }
    }

    public function approve(Event $event)
    {
        $event->update(['status' => 'approved']);
        return redirect()->route('events.index')
            ->with('success', 'Event approved successfully.');
    }

    public function reject(Event $event)
    {
        $event->update(['status' => 'rejected']);
        return redirect()->route('events.index')
            ->with('success', 'Event rejected successfully.');
    }
} 