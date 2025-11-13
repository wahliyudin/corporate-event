<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('event.index');
    }

    public function example()
    {
        return view('event.example');
    }

    public function dataCalendar()
    {
        return response()->json([
            [
                'id' => '7',
                'title' => 'Event 1',
                'start' => '2025-11-01',
                'end' => '2025-11-02',
                'description' => 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary',
                'example' => 'Example'
            ],
            [
                'title' => 'Event 2',
                'start' => '2025-11-03',
                'end' => '2025-11-04',
            ],
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
