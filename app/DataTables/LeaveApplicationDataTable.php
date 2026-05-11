<?php

namespace App\DataTables;

use App\Models\LeaveApplication;
use App\Models\LeaveApproval;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LeaveApplicationDataTable extends DataTable
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
            ->editColumn('from_date', function ($row) {
                return Carbon::parse($row->from_date)->format('d/m/Y');
            })
            ->editColumn('to_date', function ($row) {
                return Carbon::parse($row->to_date)->format('d/m/Y');
            })
            ->addColumn('action', function ($row) {
                if (in_array($row->leave_status, [1])) {
                    return '';
                }

                return '<ul class="action">
                            <li class="edit"> 
                                <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')">
                                    <i class="icon-info-alt"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->editColumn('leave_status', function ($row) {
                switch ($row->leave_status) {
                    case 1:
                        return '<span class="btn btn-xs btn-outline-success">Approved</span>';
                    case 2:
                        return '<span class="btn btn-xs btn-outline-danger">Rejected</span>';
                    default:
                        return '<span class="btn btn-xs btn-outline-warning">Pending</span>';
                }
            })
            ->rawColumns(['leave_status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LeaveApplication $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LeaveApplication $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(
                'leave_application.*',
                'leave_approval.leave_status'
            )
            ->leftJoin('leave_approval', 'leave_application.id', '=', 'leave_approval.leave_id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('leaveapplication-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
            ->orderBy(1, 'desc')
            ->responsive(true)
            ->lengthMenu([50, 100, 200, 300])
            ->selectStyleSingle()
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
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(5),
            Column::make('rec_date')->title('Applied On'),
            Column::make('name')->title('Employee Name'),
            Column::make('department')->title('Department'),
            Column::make('from_date')->title('From Date'),
            Column::make('to_date')->title('To Date'),
            Column::make('no_of_days')->title('No of Days'),
            Column::make('leave_status')->title('Leave Status'),
            Column::computed('action')->responsivePriority(6)
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
        return 'LeaveApplication_' . date('YmdHis');
    }
}
