<?php

namespace App\Models\Admin;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class DatatableModel extends Model
{
    protected $table = '';
    protected $primaryKey = '';
    protected $allowedFields = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function dataOutput($columns, $data)
    {
        $out = [];
        foreach ($data as $row) {
            $rowData = [];
            foreach ($columns as $column) {
                if (isset($column['formatter'])) {
                    $rowData[$column['dt']] = empty($column['db'])
                        ? $column['formatter']($row)
                        : $column['formatter']($row[$column['db']], $row);
                } else {
                    $rowData[$column['dt']] = $row[$column['db']] ?? '';
                }
            }
            $out[] = $rowData;
        }
        return $out;
    }

    public function limit($request, $columns)
    {
        return isset($request['start']) && $request['length'] != -1
            ? "LIMIT " . intval($request['start']) . ", " . intval($request['length'])
            : '';
    }

    public function order($request, $columns)
    {
        $order = '';
        if (isset($request['order']) && count($request['order'])) {
            $orderBy = [];
            $dtColumns = array_column($columns, 'dt');
            foreach ($request['order'] as $orderItem) {
                $columnIdx = intval($orderItem['column']);
                $requestColumn = $request['columns'][$columnIdx];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['orderable'] === 'true') {
                    $dir = $orderItem['dir'] === 'asc' ? 'ASC' : 'DESC';
                    $orderBy[] = '`' . $column['db'] . '` ' . $dir;
                }
            }
            $order = count($orderBy) ? implode(', ', $orderBy) : '';
        }
        return $order;
    }

    /*
    public function filter($request, $columns, BaseBuilder &$builder)
    {
        $dtColumns = array_column($columns, 'dt');
        if (isset($request['search']['value']) && $request['search']['value'] != '') {
            $builder->groupStart();
            foreach ($request['columns'] as $requestColumn) {
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['searchable'] == 'true' && !empty($column['db'])) {
                    $builder->orLike($column['db'], $request['search']['value']);
                }
            }
            $builder->groupEnd();
        }
    }*/
    public function filter($request, $columns, BaseBuilder &$builder)
    {
        $dtColumns = array_column($columns, 'dt');

        // Filtro global
        if (isset($request['search']['value']) && $request['search']['value'] != '') {
            $builder->groupStart();
            foreach ($request['columns'] as $requestColumn) {
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['searchable'] == 'true' && !empty($column['db'])) {
                    $builder->orLike($column['db'], $request['search']['value']);
                }
            }
            $builder->groupEnd();
        }

        // Filtros columna por columna
        foreach ($request['columns'] as $index => $requestColumn) {
            if (!empty($requestColumn['search']['value']) && $requestColumn['searchable'] == 'true') {
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                if ($columnIdx !== false) {
                    $column = $columns[$columnIdx];
                    if (!empty($column['db'])) {
                        $builder->where($column['db'], $requestColumn['search']['value']);
                    }
                }
            }
        }
    }

    public function simple($request, $table, $primaryKey, $columns)
    {
        $builder = $this->db->table($table);
        $builder->select(implode(',', array_column($columns, 'db')));
        $this->filter($request, $columns, $builder);

        $order = $this->order($request, $columns);
        $limit = $this->limit($request, $columns);
        if ($order) $builder->orderBy($order);
        if ($limit) $builder->limit(intval($request['length']), intval($request['start']));

        $recordsFiltered = $builder->countAllResults(false);
        $data = $builder->get()->getResultArray();

        $recordsTotal = $this->db->table($table)->countAllResults();
        return [
            "draw" => intval($request['draw'] ?? 0),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $this->dataOutput($columns, $data)
        ];
    }
}
