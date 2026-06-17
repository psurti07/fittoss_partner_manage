<?php

namespace App\DataTables;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class InvoiceDataTable extends DataTable
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
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? date('d-m-Y h:i:s A', strtotime($row->created_at)) : '-';
            })
            ->addColumn('inv_number', function ($row) {
                return $row->inv_prefix . "" . $row->inv_number;
            })
            ->addColumn('action', function ($row) {
                if ($row->userid) {
                    $url = route('manage.invoice.pdf', ['id' => $row->id]);
                    return '<ul class="action gap-2">
                                <li class="info">
                                    <a href="' . $url . '" class="text-info" title="Download PDF" target="_blank">
                                        <i class="icon icon-download"></i>
                                    </a>
                                </li>
                                <li class="info">
                                    <a href="' . route('manage.customers.invoice', ['id' => $row->id]) . '" target="_blank">
                                        <i class="icon icon-files"></i>
                                    </a>
                                </li>
                                <li class="info">
                                    <a class="text-warning" href="javascript:;" title="refund" onclick="openRefundModal(' . $row->id . ',' . $row->inv_number . ')">
                                        <i class="icon-share-alt"></i>
                                    </a>
                                </li>
                                <li class="delete">
                                    <a href="javascript:;" onclick="deleteInvoice(' . $row->id . ')">
                                        <i class="icon-trash"></i>
                                    </a>
                                </li>
                            </ul>';
                }
                return '-';
            })
            ->addColumn('full_name', function ($row) {
                $name = $row->user->first_name . ' ' . $row->user->last_name;
                $tag = (($row->is_refund == 1) ? ' <span class="badge badge-light-danger">Refunded</span>' : '');
                return $name . $tag;
            })
            ->addColumn('mobile', function ($row) {
                return isset($row->user->mobile_no) ? $row->user->mobile_no : '-';
            })
            ->addColumn('city', function ($row) {
                return isset($row->user->city) ? $row->user->city : '-';
            })
            ->addColumn('state', function ($row) {
                return isset($row->user->state) ? $row->user->state : '-';
            })
            ->addColumn('product_name', function ($row) {
                if ($row->user_type == 1) {
                    return isset($row->user->product->productname) ? $row->user->product->productname : '-';
                }
                return 'Event';
            })
            ->setRowId('id')->rawColumns(['action', 'date', 'full_name', 'mobile', 'city', 'state']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Invoice $model): QueryBuilder
    {
        $search = $this->request()->get('search')['value'];
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');

        $query = $model->newQuery()
            ->with('user')
            ->where('is_delete', 0)
            ->company();

        if (!empty($start_date) && !empty($end_date)) {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->endOfDay();
            $query = $query->whereBetween('rec_date', [$start_date, $end_date]);
        } else {
            $start_date = date('Y-m-d', strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereBetween('rec_date', [$start_date, $end_date]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('mobile_no', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('state', 'like', "%{$search}%");
                });
            });
        }

        return $query;
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('invoice-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->dom('Blfrtip')
            ->orderBy(1, 'desc')
            ->selectStyleSingle()
            ->pageLength(50)
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
            Column::make('DT_RowIndex')->title('#')->orderable(false)->searchable(false)->width(5),
            Column::make('created_at')->title('Date'),
            Column::computed('inv_number')->title('Invoice No'),
            Column::computed('product_name')->title('Product'),
            Column::make('full_name'),
            Column::make('mobile'),
            Column::computed('city'),
            Column::computed('state'),
            Column::computed('inv_grandtotal')->title('Total Amount'),
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
        return 'Invoice_' . date('YmdHis');
    }
}
