<?php

namespace App\Http\Controllers\Event;

use App\Enums\Event\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreRequest;
use App\Services\Event\EventService;

class EventController extends Controller
{
    public function __construct(
        private EventService $service
    ) {}

    public function index()
    {
        return view('event.event.index');
    }

    public function datatable()
    {
        $data = $this->service->datatable();
        return datatables()->of($data)
            ->addColumn('category', function ($event) {
                return $event->eventCategory->badge();
            })
            ->filterColumn('category', function ($query, $keyword) {
                $query->whereHas('eventCategory', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('company', function ($event) {
                return $event->company->name;
            })
            ->filterColumn('company', function ($query, $keyword) {
                $query->whereHas('company', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
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
            ->editColumn('status', function ($event) {
                return $event->status->badge();
            })
            ->editColumn('can_update', function ($event) {
                return in_array($event->status, [Status::PENDING, Status::VERIFIED]) ? false : $event->can_update;
            })
            ->editColumn('can_delete', function ($event) {
                return in_array($event->status, [Status::PENDING, Status::VERIFIED]) ? false : $event->can_delete;
            })
            ->rawColumns(['status', 'category'])
            ->addIndexColumn()
            ->make();
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

    public function edit($id)
    {
        try {
            $data = $this->service->edit($id);
            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Event successfully deleted!'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
