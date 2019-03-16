<?php

namespace App\Services;

use App\Employee;
use App\Repositories\EmployeesRepository;

/**
 * Class Filters
 *
 * @package App\Services
 */
class TreeServices
{
    protected $repository;

    public function __construct(EmployeesRepository $employeesRepository)
    {
        $this->repository = $employeesRepository;
    }

    public function getEmployees(array $where)
    {
        $employees = $this->repository->getEmployeesWhere($where);
        if (count($employees) == 0) {
            return false;
        }

        return $employees;
    }

    public function updateEmployeeParentId($id, $chief)
    {
        try {
            Employee::where('id', '=', $id)->update(['parent_id' => $chief]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getEmployeesTree($count)
    {
        $employees = $this->getEmployees(['id', '<', $count]);
        $employeesTree = [];
        if ($employees) {
            foreach ($employees as $employee) {
                $employeesTree[$employee['parent_id']][$employee['id']] = $employee;
            }
        }

        return $employeesTree;
    }
}
