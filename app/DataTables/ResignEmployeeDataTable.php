<?php

namespace App\DataTables;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ResignEmployeeDataTable extends DataTable
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
            ->editColumn('resign_date', function ($row) {
                return Carbon::parse($row->resign_date)->format('d/m/Y');
            })
            ->addColumn('action', function ($row) {
                return '<ul class="action">
                            <li class="edit"> 
                                <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')">
                                    <i class="icon-info-alt"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ResignEmployee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model): QueryBuilder
    {
        $query = $model->newQuery()->where('isDelete', 0)->whereNotNull('resign_date');

        // Apply month filter if provided
        if (request()->filled('month_id')) {
            $query->whereMonth('resign_date', request()->month_id);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('resignemployee-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
            ->orderBy(2, 'asc')
            ->responsive(true)
            ->lengthMenu([50, 100, 200, 300])
            ->scrollX(true)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
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
            Column::computed('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(50),
            Column::make('name')->title('Employee Name'),
            Column::make('resign_date')->title('Resign Date'),
            Column::computed('action')->responsivePriority(11)
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
        return 'ResignEmployee_' . date('YmdHis');
    }
}
