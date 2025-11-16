<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Services\Event\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        public EventService $service
    ) {}

    public function index()
    {
        return view('approval.event.index');
    }

    public function datatable()
    {
        $data = $this->service->outstandingDatatable();
        return datatables()->of($data)
            ->addColumn('requestor', function ($event) {
                return $event->requestor->name;
            })
            ->addColumn('category', function ($event) {
                return $event->eventCategory->name;
            })
            ->addColumn('company', function ($event) {
                return $event->company->name;
            })
            ->editColumn('start_date', function ($event) {
                return carbon_YmdHi($event->start_date);
            })
            ->editColumn('end_date', function ($event) {
                return carbon_YmdHi($event->end_date);
            })
            ->editColumn('created_at', function ($event) {
                return carbon_YmdHi($event->created_at);
            })
            ->editColumn('location', function ($event) {
                return strip_tags($event->location);
            })
            ->addIndexColumn()
            ->make();
    }

    public function show($key)
    {
        $data = $this->service->dataForShow($key);
        return view('approval.event.show', [
            'event' => $data,
        ]);
    }

    public function approve($key)
    {
        try {
            $this->service->approve($key);
            return response()->json([
                'message' => 'Event has been approved.',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reject($key, Request $request)
    {
        try {
            $this->service->reject($key, $request->reason);
            return response()->json([
                'message' => 'Event has been rejected.',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
