<?php

namespace App\Repositories;

use App\Employee;
use Illuminate\Http\Request;

class EmployeesRepository extends Repository
{
    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    public function getForAutocomplete(Request $request)
    {
        $name = $request->input('name');
        $query = $this->model->select($name)->groupby($name);

        if ($name == 'director') {
            $columns = ['last_name', 'first_name', 'id'];
            $query = $this->model->select($columns);
        }

        $fields = $request->input('fields');

        foreach ($fields as $key => $value) {
            $query = $query->where($key, 'like', "%{$value}%");
        }

        return $query->get();
    }

    public function getDirectorsForDeleteWindow($id)
    {
        $dir = $this->get('parent_id', [['parent_id', '!=', null], ['parent_id', '!=', $id]], 'parent_id');
        $emp = $this->get('id', ['parent_id', '=', $id]);

        return $this->model->select([
            'last_name',
            'first_name',
            'position',
            'id',
            'parent_id',
            'hired',
            'salary'
        ])->whereIn('id', $dir)->whereNotIn('id', $emp)->orderBy('last_name')->get();
    }

    public function get($select = '*', $where = false, $groupBy = false, $desc = false, $pagination = false)
    {
        if ($desc) {
            //$builder = $this->model->orderBy($desc, 'desc')->select($select);
            $builder = $this->model->latest($desc)->select($select);
        } else {
            $builder = $this->model->select($select);
        }

        if ($where) {
            $builder = $this->where($where, $builder);
        }

        if ($groupBy) {
            $builder->groupBy($groupBy);
        }

//        if ($pagination) {
//            return $this->check($builder->paginate(Config::get('settings.paginate')));
//        }

        return $builder->get();
    }

    protected function where(array $where, $builder)
    {
        foreach ($where as $item) {
            if (is_array($item)) {
                $builder = $builder->where($item[0], $item[1], $item[2]);
            }else{
                $builder = $builder->where($where[0], $where[1], $where[2]);
                break;
            }
        }

        return $builder;
    }

    public function getQueryForIndexPage(array $filters)
    {
        $query = $this->model;

        foreach ($filters as $key => $value) {
            if ($key != 'order' && $key != 'sort') {
                $query = $query->where($key, 'like', "%{$value}%");
            }
        }

        if (isset($filters['sort'])) {
            $query = $query->orderBy($filters['sort'], $filters['order']);
        }
        $query = $query->select(['last_name', 'first_name', 'position', 'id', 'parent_id'])->paginate(7);

        return $query->appends($filters);
    }

    public function getEmployeesWhere(array $where, $columns = false)
    {
        if (!$columns){
            $columns = ['last_name', 'first_name', 'position', 'id', 'parent_id'];
        }

        $result = $this->get($columns, $where);

        return $result;
    }

    public function getOneEmployee($id)
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

        return $this->model->select($columns)->where('id', '=', $id)->first();
    }

    public function getPositions()
    {
        return $this->model->select('position')->groupby('position')->orderBy('position')->get();
    }
}
