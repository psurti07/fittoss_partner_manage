<?php

namespace App\DataTables;

use App\Models\Career;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CareerDataTable extends DataTable
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
            ->addColumn('is_active', function ($row) {
                $statusText = $row->is_active ? 'Active' : 'Inactive';
                $btnClass = $row->is_active ? 'btn-outline-success' : 'btn-outline-danger';
                return '<a href="javascript:;" onclick="changeStatus('.$row->id.', '.$row->is_active.')">
                            <span class="btn btn-xs '.$btnClass.'">'.$statusText.'</span>
                        </a>';
            })
            ->rawColumns(['is_active', 'action'])
            ->addColumn('action', function ($row) {
                return '<ul class="action">
                            <li class="edit">
                                <a href="javascript:;" onclick="openEditModal('.$row->id.')">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>
                            <li class="delete">
                                <a href="javascript:;" onclick="deleteCareer('.$row->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                        </ul>';
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Career $model): QueryBuilder
    {
        return $model->newQuery()->where('is_delete',0);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('career-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->responsive(true)
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
            Column::computed('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('title')->width(500),
            Column::make('rec_date')->title('Date'),
            Column::make('is_active')->title('Status'),
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
        return 'Career_' . date('YmdHis');
    }
}
