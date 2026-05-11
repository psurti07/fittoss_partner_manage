<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class CompanyLeadsDataTable extends DataTable
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
                $actionBtn = '<a class="" href="#"><i class="icon-delete-alt"></i></a>';
                return $actionBtn;
            })
            ->addColumn('date', function ($row) {
                return date('d-m-Y H:i', strtotime($row->created_at));
            })
            ->addColumn('city',function ($row){
                return $row->city ?: '-';
            })
            ->setRowId('id')->rawColumns(['action', 'date', 'full_name']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');

        $query = $model->newQuery()->where('is_user', 1)->orderByDesc('id');

        if (!empty($start_date) && !empty($end_date)) {
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereBetween('created_at', [$start_date, $end_date]);
        } else {
            $start_date = date('Y-m-d', strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('companyleads-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('date'),
            Column::make('name'),
            Column::make('mobile_no'),
            Column::make('email'),
            Column::make('city'),
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
        return 'CompanyLeads_' . date('YmdHis');
    }
}
