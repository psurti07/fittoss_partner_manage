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
            ->addColumn('action', function ($row) {
                $action = '';
                $action = '<a href="#" data-id="' . $row->id . '" class="btn">
                                   <i class="fa fa-info-circle text-success"></i>
                               </a>';

                return $action;
            });
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
            // Column::computed('action')
            //   ->exportable(false)
            //   ->printable(false)
            //   ->width(60)
            //   ->addClass('text-center'),
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
