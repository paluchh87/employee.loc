<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Services\EmployeeServices;

/**
 * Class EmployeeController
 *
 * @package App\Http\Controllers
 */
class EmployeeController extends Controller
{
    protected $services;
    protected $error = null;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeServices $employeeServices
     */
    public function __construct(EmployeeServices $employeeServices)
    {
        $this->services = $employeeServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @throws
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->services->getSelectedFilters($request);
        $query = $this->services->getIndexPageQuery($filters);

        $var = [
            'employees' => $query,
            'filters' => $filters
        ];

        if ($request->ajax()) {
            $var['pagination'] = view('employee.parts.pagination')->with('employees', $query)->render();
            $var['table'] = view('employee.parts.employee-table')->with('employees', $query)->render();
            $var['filters2'] = view('employee.parts.filters')->with('filters', $filters)->render();

            return response()->json($var);
        }

        return view('employee.index')->with($var);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $var = $this->services->getEditPageContent($id);
            $table = view('employee.parts.ajaxedit')->with($var)->render();

            return response()->json($table);
        }

        return redirect('/employee');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        if ($request->ajax()) {
            if ($request->input('director') != null && $request->input('parent_id') == null) {
                return response()->json(['error' => 'ERROR Director']);
            }

            $photo = $this->services->uploadEmployeeImage($request->file('avatar'), $request->input('id'), $request->input('photo'));
            $request->merge(['photo' => $photo]);
            $this->error = $this->services->updateEmployee($request, $id);
            $var = [
                'result' => $this->error,
                'photo' => $photo
            ];
            return response()->json($var);
        }

        return redirect('/employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $this->error = $this->services->deleteEmployee($id);

            return response()->json($this->error);
        }

        return redirect('/employee');
    }
}
