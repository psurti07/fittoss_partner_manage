<?php

namespace App\DataTables;

use App\Models\Disease;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DiseaseDataTable extends DataTable
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
            ->addColumn('description', function ($row) {
                return $row->description ?? '--';
            })
            ->addColumn('rec_date', function ($row) {
                return \Carbon\Carbon::parse($row->rec_date)->format('d-m-Y');
            })
            ->addColumn('action', function ($row) {
                $action = '<ul class="action">';
                $action .= '<li class="edit">
                                <a href="javascript:;" onclick="openEditModal('.$row->id.')">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>';
                $action .= '<li class="delete">
                                <a href="javascript:;" onclick="deleteDisease('.$row->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>';
                $action .= '</ul>';

                return $action;
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Disease $model): QueryBuilder
    {
        return $model->newQuery()->where('is_delete',0)->orderBy('id','asc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('diseases-table')
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
            Column::computed('DT_RowIndex')->title('Id')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('description'),
            Column::make('rec_date')->title('Date'),
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
        return 'Disease_' . date('YmdHis');
    }
}
