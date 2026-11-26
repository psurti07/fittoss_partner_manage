<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Contact\App\Models\ContactInquiry;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ContactInquiryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
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
            ->addColumn('action', function ($row) {
                $action = '<ul class="action justify-content-center">
                                <li class="info"><a href="javascript:;" onclick="openDetailsModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                            </ul>';
                return $action;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ContactInquiry $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('contactinquiry-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->dom('Blfrtip')
            ->orderBy(1, 'desc')
            ->selectStyleSingle()
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
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('created_at')->title('Date'),
            Column::make('first_name')->title('Name'),
            Column::make('title'),
            Column::make('email'),
            Column::make('mobile_no'),
            Column::make('message'),
            Column::make('status')->title('Status'),
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
        return 'ContactInquiry_' . date('YmdHis');
    }
}
