<?php

namespace App\Http\Controllers;

use App\Services\AjaxServices;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    protected $services;

    public function __construct(AjaxServices $ajaxServices)
    {
        $this->services = $ajaxServices;
    }

    public function autocomplete(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('name')) {
                return response()->json($this->services->getAutocompleteContent($request));
            }
        }

        return false;
    }

    public function canDelete(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('delete') == true) {
                return response()->json(true);
            }

            return response()->json($this->services->updateEmployeesParentId($request));
        }

        return redirect('/employee');
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function showDeleteWindow(Request $request)
    {
        if ($request->ajax()) {
            $employees = $this->services->getEmployees($request->input('id'));
            if (count($employees) == 0) {
                return response()->json(['table' => view('employee.parts.ajaxdeleteok')->with(['delete' => true])->render()]);
            }

            $var = [
                'parent' => $request->input('parent_id'),
                'employees' => $employees,
                'directors' => $this->services->getDirectors($request->input('id'))
            ];

            return response()->json(['table' => view('employee.parts.ajaxdelete')->with($var)->render()]);
        }

        return redirect('/employee');
    }
}
