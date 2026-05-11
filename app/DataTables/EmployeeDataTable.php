<?php

namespace App\DataTables;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('rec_date', function ($row) {
                return Carbon::parse($row->rec_date)->format('d/m/Y');
            })
            ->editColumn('dob', function ($row) {
                return Carbon::parse($row->dob)->format('d/m/Y');
            })
            ->editColumn('doj', function ($row) {
                return Carbon::parse($row->doj)->format('d/m/Y');
            })
            ->editColumn('resign_date', function ($row) {
                return $row->resign_date ? Carbon::parse($row->resign_date)->format('d/m/Y') : 'N/A';
            })
            ->editColumn('isActive', function ($row) {
                $today = Carbon::today();

                if ($row->resign_date && Carbon::parse($row->resign_date)->lt($today)) {
                    return '<span class="btn btn-xs btn-outline-danger">Inactive</span>';
                }

                $statusClass = $row->isActive == 1 ? 'btn-outline-success' : 'btn-outline-danger';
                $statusText  = $row->isActive == 1 ? 'Active' : 'Inactive';
                return '<span class="btn btn-xs '.$statusClass.'" style="cursor:pointer;" onclick="toggleEmployeeStatus('.$row->id.')">'.$statusText.'</span>';
            })
            ->addColumn('action', function ($row) {
                return '<ul class="action">
                            <li class="info">
                                <a href="' . route('manage.employee.edit', ['id' => $row->id]) . '" title="Info">
                                    <i class="icon-info-alt"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->setRowId('id')
            ->setRowClass(function ($row) {
                $today = Carbon::today();
                if ($row->resign_date && Carbon::parse($row->resign_date)->lt($today)) {
                    return 'table-danger';
                }
                return '';
            })
            ->rawColumns(['action', 'isActive']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model): QueryBuilder
    {
        return $model->newQuery()->where('isDelete',0);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('employee-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(1, 'desc')
                    ->parameters([
                        'responsive' => true,
                    ])
                    ->selectStyleSingle()
                    ->lengthMenu([50, 100, 200, 300])
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('Id')->searchable(false)->orderable(false)->addClass('text-nowrap')->responsivePriority(1),
            Column::make('rec_date')->title('Date')->responsivePriority(2),
            Column::make('name')->title('Employee Name')->responsivePriority(3),
            Column::make('mobile_no')->title('Mobile No.')->responsivePriority(4),
            Column::make('email')->title('Email')->responsivePriority(5),
            Column::make('department')->title('Department')->responsivePriority(6),
            Column::make('doj')->title('Date of Joining')->responsivePriority(7),
            Column::make('isActive')->title('Status')->responsivePriority(8),
            Column::computed('action')->responsivePriority(8)
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Employee_' . date('YmdHis');
    }
}
