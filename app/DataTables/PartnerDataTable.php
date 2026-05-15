<?php

namespace App\DataTables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Partner\App\Models\Company;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PartnerDataTable extends DataTable
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
                $actionBtn = '<a class="" href="' . route('manage.partner.details', ['id' => encrypt($row->id)]) . '"><i class="fa fa-info-circle"></i></a>';
                return $actionBtn;
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('company_code', function ($row) {
                return $row->company_code ?? NULL;
            })
            ->editColumn('company_name', function ($row) {
                return $row->company_name ?? NULL;
            })
            ->editColumn('company_mobile_no', function ($row) {
                return $row->company_mobile_no ?? NULL;
            })
            ->editColumn('company_email', function ($row) {
                return $row->company_email ?? NULL;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Company $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('partner-table')
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
            Column::make('DT_RowIndex')->title('#')->orderable(false)->searchable(false)->width(5),
            Column::make('updated_at')->title('Date')->width(2),
            Column::make('company_code')->width(2),
            Column::make('company_name')->width(2),
            Column::make('company_mobile_no')->width(2),
            Column::make('company_email')->width(2),
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
        return 'Partner_' . date('YmdHis');
    }
}
