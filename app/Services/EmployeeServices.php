<?php

namespace App\Services;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Repositories\EmployeesRepository;

/**
 * Class Filters
 *
 * @package App\Services
 */
class EmployeeServices
{
    protected $repository;

    public function __construct(EmployeesRepository $employeesRepository)
    {
        $this->repository = $employeesRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getSelectedFilters(Request $request): array
    {
        $filters = $request->only(['last_name', 'first_name', 'position', 'sort']);
        if (isset($filters['sort'])) {
            $filters['order'] = $request->input('order') ?? 'asc';
        }

        return $filters;
    }

    public function getIndexPageQuery(array $filters)
    {
        return $this->repository->getQueryForIndexPage($filters);
    }

    public function getEditPageContent($id)
    {
        try {
            $employee = $this->repository->getOneEmployee($id);
            $var = [
                'employee' => $employee,
                'director' => $this->repository->getOneEmployee($employee->parent_id),
                'positions' => $this->repository->getPositions()
            ];

        } catch (\Exception $e) {
            $var = ['error' => 'Ошибка с данными'];
        }

        return $var;
    }

    public function uploadEmployeeImage($avatar, $id, $oldImage = null)
    {
        if (is_file($avatar)) {
            $name = $avatar->getClientOriginalName();
            $extension = \File::extension($name);
            $filename = uniqid('employee_avatar_') . '_' . $id . '.' . $extension;
            //$filename = 'employee_avatar_' .$id . '.' . $extension;
            if ($oldImage != null && file_exists(public_path('images/') . $oldImage)) {
                unlink(public_path('images/') . $oldImage);
            }
            \File::put(public_path('images/') . $filename, \File::get($avatar));

            return (file_exists(public_path('images/') . $filename)) ? $filename : null;
        }
        return null;
    }

    public function updateEmployee(EmployeeRequest $request, $id)
    {
        try {
            $update = $request->only('last_name', 'first_name', 'position', 'salary', 'hired', 'parent_id', 'photo');
            Employee::where('id', '=', $id)->update($update);

            return ['status' => 'Работник изменен'];
        } catch (\Exception $e) {
            return ['error' => 'ERROR query UPDATE'];
        }
    }

    public function deleteEmployee($id)
    {
        try {
            if (Employee::where('id', '=', $id)->delete()) {
                return ['status' => 'Работник удален'];
            }
        } catch (\Exception $e) {
            return ['error' => 'ERROR query DELETE'];
        }
    }
}
