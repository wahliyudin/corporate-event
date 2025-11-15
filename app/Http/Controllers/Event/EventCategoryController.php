<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Repositories\Event\EventCategoryRepository;

class EventCategoryController extends Controller
{
    public function __construct(
        private EventCategoryRepository $repository
    ) {}

    public function index()
    {
        return view('event.category.index');
    }

    public function dataSelect()
    {
        $data = $this->repository->dataSelect();
        return response()->json([
            'data' => $data
        ]);
    }
}
