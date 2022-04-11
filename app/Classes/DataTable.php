<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\ParameterBag;

class DataTable
{
    public static function render(
        Builder      $data,
        string       $modelClass,
        ParameterBag $params,
        array        $customData = null,
        string       $orderColumn = null,
        string       $orderDirection = 'DESC'
    ) {

        $start = $params->get("start");
        $rowPerPage = $params->get("length");
        $columnIndex_arr = $params->get('order');

        $columnName_arr = $params->get('columns');
        if (isset($columnIndex_arr[0]['column'])) {
            $order_arr = $params->get('order');
            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['name']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        }
        $totalRecords = 0; /*$modelClass::select('count(*) as allcount')->count()*/

        $totalRecordsWithFilter = $data->withoutGlobalScopes()->count();
        $records = $data;

        if (isset($columnName)) {
            $records = $records->orderBy($columnName, $columnSortOrder);
        } elseif ($orderColumn) {
            $records = $records->orderBy($orderColumn, $orderDirection);
        }

        if ($rowPerPage > 0) {
            $records = $records->skip($start)->take($rowPerPage);
        }

        $records = $records->withoutGlobalScopes()
            ->get();

        $response = array(
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordsWithFilter,
            "data" => $records,
            "custom" => $customData
        );
        return $response;
    }
}
