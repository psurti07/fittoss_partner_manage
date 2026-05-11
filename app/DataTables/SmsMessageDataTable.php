<?php

namespace App\DataTables;

use App\Models\SmsList;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SmsMessageDataTable extends DataTable
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
                $action = '<ul class="action" style="display:block">
                            <li class="edit" style="display:flex;align-items: center;justify-content: center">
                                <a href="javascript:;" onclick="editModal(' . $row->id . ')">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->editColumn('rec_date', function ($row) {
                return Carbon::parse($row->rec_date)->format('d/m/Y H:i:s');
            })
            ->setRowId('id')
            ->rawColumns(['action', 'rec_date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SmsList $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->where('is_active', 1);

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('smsmessage-table')
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
            Column::computed('DT_RowIndex')->title('#')->orderable(false)->searchable(false)->width(5),
            Column::make('rec_date')->title('Update Date')->orderable(true),
            Column::make('title')->title('SMS Type')->orderable(true),
            Column::make('message')->title('SMS')->orderable(true),
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
        return 'SmsMessage_' . date('YmdHis');
    }
}
