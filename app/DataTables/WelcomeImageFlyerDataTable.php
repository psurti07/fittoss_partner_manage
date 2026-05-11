<?php

namespace App\DataTables;

use App\Models\WelcomeImageFlyer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WelcomeImageFlyerDataTable extends DataTable
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
            ->editColumn('flyer_img', function ($row) {
                $imagePath = asset('assets/images/flyer/' . $row->flyer_img);
                return '<img src="' . $imagePath . '" alt="Flyer Image" height="50">';
            })
            ->editColumn('is_active', function ($row) {
                $statusClass = $row->is_active == 1 ? 'btn-outline-success' : 'btn-outline-danger';
                $statusText = $row->is_active == 1 ? 'Active' : 'Inactive';
                return '<span class="btn btn-xs ' . $statusClass . '" style="cursor:pointer;" onclick="toggleFlyerStatus(' . $row->id . ')">' . $statusText . '</span>';
            })
            ->addColumn('action', function ($row) {
                return '<ul class="action">
                            <li class="edit">
                                <a href="javascript:;" onclick="openEditModal(' . $row->id . ')">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>
                            <li class="delete">
                                <a href="javascript:;" onclick="destroy(' . $row->id . ')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->setRowId('id')
            ->rawColumns(['flyer_img', 'action', 'is_active']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WelcomeImageFlyer $model): QueryBuilder
    {
        return $model->newQuery()->where('is_delete', 0)->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('welcomeimageflyer-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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
            Column::computed('DT_RowIndex')->title('Id')->searchable(false)->orderable(false)
                ->addClass('text-nowrap')->responsivePriority(1),

            Column::make('flyer_img')->title('Flyer Image')->responsivePriority(1),
            Column::make('flyer_name')->responsivePriority(2),

            Column::make('is_active')->title('Status')->responsivePriority(4),

            Column::computed('action')->responsivePriority(5)
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
        return 'WelcomeImageFlyer_' . date('YmdHis');
    }
}
