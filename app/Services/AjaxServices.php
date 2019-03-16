<?php

namespace App\Services;

use App\Employee;
use Illuminate\Http\Request;
use App\Repositories\EmployeesRepository;

/**
 * Class Filters
 *
 * @package App\Services
 */
class AjaxServices
{
    protected $repository;

    public function __construct(EmployeesRepository $employeesRepository)
    {
        $this->repository = $employeesRepository;
    }

    public function getAutocompleteContent($request)
    {
        return $this->repository->getForAutocomplete($request);
    }

    public function updateEmployeesParentId(Request $request): bool
    {
        $id = $request->input('id');
        $parent_id = $request->input('parent_id');
        $employee = $request->input('employee');
        $director = $request->input('director');

        if ($employee == $director && $employee == null) {
            return false;
        }

        if ($employee == null && $director != null) {
            Employee::where('parent_id', '=', $id)->update(['parent_id' => $director]);

            return true;
        }

        if ($employee != null && $director == null) {
            Employee::where('parent_id', '=', $id)->where('id', '!=', $employee)->update(['parent_id' => $employee]);
            Employee::where('id', '=', $employee)->update(['parent_id' => $parent_id]);

            return true;
        }
        Employee::where('parent_id', '=', $id)->where('id', '!=', $employee)->update(['parent_id' => $employee]);
        Employee::where('id', '=', $employee)->update(['parent_id' => $director]);

        return true;
    }

    public function getEmployees($id)
    {
        $columns = [
            'last_name',
            'first_name',
            'position',
            'id',
            'parent_id',
            'hired',
            'salary',
            'photo'
        ];

        return $this->repository->getEmployeesWhere(['parent_id', '=', $id], $columns);
    }

    public function getDirectors($id)
    {
        return $this->repository->getDirectorsForDeleteWindow($id);
    }
}
