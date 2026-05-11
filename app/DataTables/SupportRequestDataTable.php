<?php

namespace App\DataTables;

use App\Models\SupportRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupportRequestDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('fullname', function ($row) {
                return $row->firstname . ' ' . $row->lastname;
            })
            ->editColumn('rec_date', function ($row) {
                return \Carbon\Carbon::parse($row->rec_date)->format('d-m-Y');
            })
            ->addColumn('action', function ($row) {
                return '<a href="javascript:;" onclick="openDetailsModal(' . $row->id . ')">
                            <i class="fa fa-info-circle"></i>
                        </a>';
            })
            ->addColumn('usertype', function ($model) {
                switch ($model->usertype) {
                    case 1:
                        $status = 'Customer';
                        break;
                    default:
                        $status = "Guest";
                        break;
                }
                return $status;
            })
            ->addColumn('status', function ($model) {
                switch ($model->status) {
                    case 1:
                        $status = '<span class="text-info">Open</span>';
                        break;
                    case 2:
                        $status = '<span class="text-danger">Processing</span>';
                        break;
                    case 3:
                        $status = '<span class="text-warning">Closed</span>';
                        break;
                    case 4:
                        $status = '<span class="text-success">Solved</span>';
                        break;
                    case 5:
                        $status = '<span class="text-danger">Closed – No Response</span>';
                        break;
                    default:
                        $status = "-";
                        break;
                }
                return $status;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'fullname', 'rec_date', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SupportRequest $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('supportrequest-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->dom('Blfrtip')
            ->orderBy(1,'desc')
            ->pageLength(50)
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
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('#'),
            Column::make('rec_date')->title('Date'),
            Column::make('fullname')->title('Full Name')->orderable(false)->searchable(false),
            Column::make('mobile')->title('Mobile No'),
            Column::make('email')->title('Email'),
            Column::make('ticketno')->title('Ticket No'),
            Column::make('status')->title('Status'),
            Column::make('usertype')->title('User Type'),
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
        return 'SupportRequest_' . date('YmdHis');
    }
}
