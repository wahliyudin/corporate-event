<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\MoveRequest;
use App\Http\Requests\Event\StoreRequest;
use App\Services\Event\EventService;

class EventController extends Controller
{
    public function __construct(
        private EventService $service
    ) {}

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
        $data = $this->service->dataCalendar();
        return response()->json($data);
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return response()->json([
                'message' => 'Event saved successfully'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function move($id, MoveRequest $request)
    {
        try {
            $this->service->move($id, $request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Event successfully moved!'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            $data = $this->service->edit($id);
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
