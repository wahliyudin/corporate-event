<?php

namespace App\Http\Controllers\Event;

use App\Enums\Event\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event\UpcomingEventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class UpcomingEventController extends Controller
{
    public function index()
    {
        return view('event.upcoming.index');
    }

    public function getEvents(Request $request)
    {
        $events = Event::query()
            ->with(['eventCategory', 'company'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $search = strtolower($search);
                    $query->whereRaw('LOWER(title) like ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(description) like ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(location) like ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(pic) like ?', ['%' . $search . '%']);
                });
            })
            ->when($request->categories, function ($query, $categories) {
                $query->whereHas('eventCategory', function ($query) use ($categories) {
                    $query->whereIn('name', $categories);
                });
            })
            ->whereIn('status', [Status::VERIFIED])
            ->latest('end_date')
            ->paginate($request->per_page ?? 10);
        return response()->json(new UpcomingEventResource($events));
    }
}
