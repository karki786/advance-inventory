<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 18/May/2017
 * Time: 8:15 AM
 */

namespace CodedCell\Traits;

use PDF;
use Excel;

trait PaginateTrait
{
    public function paginate($model, $request, $reportName = "Report", $reportSubTitle = "", $actions = true)
    {
        $paginate = boolval($request->paginate);
        if ($model->isEmpty()) {
            return $model;
        }

        $methods = $model->first()->getPresenterMethods();
        $reportName = ucwords($model->first()->getTable());
        $reportSubTitle = "List of " . ucwords($model->first()->getTable()) . " (" . count($model).")";
//Check if Presenter is has Methods the pop set and get
        if ($methods != null) {
            array_pop($methods);
            array_pop($methods);
        }

        $string = substr(get_class($this), strrpos(get_class($this), '\\') + 1);
        $model->map(function ($item) use ($methods, $string, $actions) {
            //Check if Presenter is has Methods the pop set and get
            if ($methods != null) {
                foreach ($methods as $method) {
                    $item[$method] = $item->present()->$method;
                }
            }
            if ($actions) {
                $item['view'] = action($string . '@show', $item->id);
                $item['edit'] = action($string . '@edit', $item->id);
                $item['delete'] = action($string . '@destroy', $item->id);
            }
            return $item;
        });

        if ($paginate) {
            return $model;
        } else {
            $columns = $request->columns;
            $cols = array();
            foreach ($columns as $key => $column) {
                // unset($column['title']);
                unset($column['sortField']);
                unset($column['visible']);
                if ($column['name'] == "__component:custom-actions") {

                } else {
                    array_push($cols, $column['name']);
                }
            }
            if ($request->filetype == 'excel') {
                $this->report($model, $cols, $columns, $reportSubTitle, $reportName);
            } elseif ($request->filetype == 'pdf') {
                $pdf = PDF::loadView('reports.report_format1', compact('model', 'columns', 'reportSubTitle', 'reportName'))->setPaper('a4', 'landscape')->setWarnings(false);
                return $pdf->download($reportName . '.pdf');
            }

        }
    }

    public
    function report($model, $columns, $orig, $reportSubTitle, $reportName)
    {
        Excel::create($reportName, function ($excel) use ($model, $columns, $orig) {

            // Set the title
            $excel->setTitle('Our new awesome title');

            // Chain the setters
            $excel->setCreator('Maatwebsite')
                ->setCompany('Maatwebsite');

            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');

            $excel->sheet('Sheetname', function ($sheet) use ($model, $columns, $orig) {
                $rows = array();
                foreach ($model as $item) {
                    array_push($rows, array_only($item->toArray(), $columns));
                }
                $orig = array_pluck($orig, 'title', 'name');
                $new_array = array();
                foreach ($rows as $row) {
                    $arr = array();
                    foreach ($row as $key => $item) {
                        $columnTitle = $orig[$key];
                        $arr[$columnTitle] = $item;
                    }
                    array_push($new_array, $arr);
                }
                $sheet->fromArray($new_array);

            });

        })->download('xlsx');
    }
}