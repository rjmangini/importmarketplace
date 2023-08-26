<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class ApiController extends Controller
{   
    private $repository;
    protected $validation = [];

    public function __construct($repository)
    {   
        try {
            $this->repository = $repository;
        } catch(Exception $e) {
            return $e;
        }
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function store(Request $request)
    {
        // aqui entra validação
        return $this->repository->store($request);
    }

    public function update(Request $request, string $id)
    {
        return $this->repository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }

}
