<?php

namespace App\DataTables;

use Modules\Auth\App\Models\Administrations;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StaffAccountDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = '<ul class="action" style="display:block">
                            <li class="text-primary" style="display:block;align-items: center">
                                <a href="' . route('manage.staff.account.details', ['staffId' => $row->id]) . '">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->editColumn('rec_date', function ($row) {
                return date('Y-m-d H:i:s', strtotime($row->rec_date));
            })
            ->addColumn('status', function ($row) {
                if ($row->is_active) {
                    $statusBtn = '<a href="javascript:;" onclick="changeStatus(' . $row->id . ',' . $row->is_active . ')">
                                        <span class="btn btn-xs btn-outline-success">Active</span>
                                    </a>';
                } else {
                    $statusBtn = '<a href="javascript:;"  onclick="changeStatus(' . $row->id . ',' . $row->is_active . ')">
                                        <span class="btn btn-xs btn-outline-danger">Inactive</span>
                                      </a>';
                }
                return $statusBtn;
            })
            ->addColumn('role', function ($row) {
                return (($row->role == 1) ? 'Office Staff' : (($row->role == 2) ? 'IVR/Support Staff' : (($row->role == 0) ? 'Admin' : 'IT Staff')));
            })
            ->setRowId('id')->rawColumns(['action', 'role', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Administrations $model): QueryBuilder
    {
        return $model->newQuery()->where(['is_delete' => 0, ['role', '!=', 5]]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('staffaccount-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->dom('Blfrtip')
            ->orderBy(1, 'desc')
            ->pageLength(50)
            ->lengthMenu([50, 100, 200, 300])
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->width(5)->searchable(false)->exportable(false),
            Column::make('rec_date')->title('Date'),
            Column::make('fullname')->title('Staff Name')->data('fullname'),
            Column::make('staff_code')->title('Staff Code')->data('staff_code'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('email')->title('Email')->data('email'),
            Column::make('role')->title('Role')->data('role'),
            Column::make('status')->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'StaffAccount_' . date('YmdHis');
    }
}
