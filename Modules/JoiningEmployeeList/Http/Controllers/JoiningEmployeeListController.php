<?php

namespace Modules\JoiningEmployeeList\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Employee;
use App\DataTables\JoiningEmployeeDataTable;

class JoiningEmployeeListController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(JoiningEmployeeDataTable $dataTable)
    {
        return $dataTable->render('joiningemployeelist::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('joiningemployeelist::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('joiningemployeelist::modals.showEmployee', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('joiningemployeelist::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
