<?php

namespace App\Http\Controllers;

use App\Services\TreeServices;
use Illuminate\Http\Request;
use App\Employee;
use App\Http\Requests\EmployeeRequest;

class TreeController extends Controller
{
    protected $services;

    public function __construct(Employee $employee, TreeServices $treeServices)
    {
        $this->services=$treeServices;
    }

    public function edit(EmployeeRequest $request)
    {
        return view('employee.edit');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function lazy(Request $request)
    {
        if ($request->ajax()) {
            $employees = $this->services->getEmployees(['parent_id', '=', $request->input('id')]);
            if (!$employees) {
                return response()->json(false);
            }

            return response()->json(['table' => view('employee.parts.tree-lazy', compact('employees'))->render()]);
        }

        $employees = $this->services->getEmployees(['parent_id', '=', null]);
        $table = view('employee.parts.tree-lazy', compact('employees'))->render();

        return view('employee.tree', compact('table'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function tree(Request $request)
    {
        if ($request->ajax()) {
            $this->services->updateEmployeeParentId($request->input('id'), $request->input('chief_id'));

            return response()->json(true);
        }

        $employeesTree = $this->services->getEmployeesTree(300);

        $var = [
            'table' => view('employee.parts.tree')->with(['employeesTree' => $employeesTree, 'parent_id' => ''])->render()
        ];

        return view('employee.tree')->with($var);
    }
}
