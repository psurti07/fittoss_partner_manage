<?php

namespace App\DataTables;

use App\Models\OtpVerification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class SendOtpDataTable extends DataTable
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
            ->editColumn('updated_at', function ($model) {
                return $model->updated_at ? Carbon::parse($model->updated_at)->format('d-m-Y H:i:s A') : '';
            })
            ->addColumn('product_name', function ($row) {
                return $row->product->product_title ?? '-';
            })
            ->setRowId('id')
            ->rawColumns(['date']);
    }

    /**
     * Get the query source of dataTable.
     */

    public function query(): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date   = $this->request()->get('end_date');
        $product_id   = $this->request()->get('product_id');

        $query = OtpVerification::with(['product:id,product_title']);

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(
                'updated_at',
                [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]
            );
        } else {
            $query->whereBetween(
                'updated_at',
                [now()->subDays(2)->toDateString(), now()->toDateString()]
            );
        }

        if ($product_id) {
            $query->where('product_id', $product_id);
        }

        return $query;
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('sendotp-table')
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
            Column::computed('DT_RowIndex')->title('#')->width(5),
            Column::make('updated_at')->title('Date')->width(200),
            Column::make('mobile'),
            Column::computed('product_name'),
            Column::make('otp_code'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SendOtp_' . date('YmdHis');
    }
}
