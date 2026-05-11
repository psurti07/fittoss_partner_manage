<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MemberShipLeadDataTable extends DataTable
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
                $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                return $actionBtn;
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at ? date('d-m-Y h:i:s A', strtotime($row->updated_at)) : '-';
            })
            ->addColumn('full_name', function ($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'full_name']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        return $model->newQuery()
            ->unPaid()
            ->where('is_delete', 0)
            ->where('product_id', config('constant.MEMBERSHIP_PLAN_OFFER_ID'));
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('membershipPlanLeadTable')
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
                Button::make('print'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('Id')->orderable(false)->searchable(false)->width(5),
            Column::make('updated_at')->title('Date')->width(2),
            Column::computed('full_name')->title('Full Name')->orderable(false)->width(2),
            Column::make('mobile_no')->title('Mobile')->width(2),
            Column::make('email')->title('Email Id')->width(2),
            Column::make('city')->title('City')->width(2),
            Column::make('state')->title('State')->width(2),
            Column::make('pincode')->title('Pincode')->width(2),
            Column::computed('action')->title('Details')
                ->addClass('text-center')
                ->exportable(false)
                ->printable(false)
                ->width(30)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MemberShipLead_' . date('YmdHis');
    }
}
