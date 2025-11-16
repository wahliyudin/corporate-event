<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        public UserService $service
    ) {}

    public function index()
    {
        return view('approval.user.index');
    }

    public function datatable()
    {
        $data = $this->service->outstandingDatatable();
        return datatables()->of($data)
            ->addColumn('company', function ($row) {
                return $row->company->name;
            })
            ->filterColumn('company', function ($query, $keyword) {
                $query->whereHas('company', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })
            ->addIndexColumn()
            ->make();
    }

    public function approve($key)
    {
        try {
            $this->service->approve($key);
            return response()->json([
                'message' => 'User has been approved.',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reject($key)
    {
        try {
            $this->service->reject($key);
            return response()->json([
                'message' => 'User has been rejected.',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
