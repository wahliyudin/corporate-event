<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreRequest;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $service
    ) {}

    public function index()
    {
        return view('company.index');
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
                'message' => 'Company saved successfully',
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
                'message' => 'Company deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
