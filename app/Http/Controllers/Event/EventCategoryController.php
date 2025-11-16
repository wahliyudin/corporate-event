<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventCategory\StoreRequest;
use App\Services\Event\EventCategoryService;

class EventCategoryController extends Controller
{
    public function __construct(
        private EventCategoryService $service
    ) {}

    public function index()
    {
        return view('event.category.index');
    }

    public function dataSelect()
    {
        $data = $this->service->repository->dataSelect();
        return response()->json([
            'data' => $data
        ]);
    }

    public function datatable()
    {
        $data = $this->service->datatable();
        return datatables()->of($data)
            ->addColumn('can_update', function ($company) {
                return true;
            })
            ->addColumn('can_delete', function ($company) {
                return true;
            })
            ->addIndexColumn()
            ->make();
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return response()->json([
                'message' => 'Event Category saved successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($key)
    {
        try {
            $data = $this->service->findForUpdate($key);
            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($key)
    {
        try {
            $this->service->delete($key);
            return response()->json([
                'message' => 'Event Category deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
