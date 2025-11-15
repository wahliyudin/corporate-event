<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyRepository $repository
    ) {}

    public function index()
    {
        return view('company.index');
    }

    public function dataSelect()
    {
        $data = $this->repository->dataSelect();
        return response()->json([
            'data' => $data
        ]);
    }
}
