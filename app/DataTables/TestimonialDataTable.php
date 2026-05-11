<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Testimonial\App\Models\TestiMonial;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class TestimonialDataTable extends DataTable
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
            ->addColumn('type', function ($row) {
                switch ($row->type) {
                    case 1: return 'Webinar';
                    case 2: return 'Weight Gain';
                    case 3: return 'Weight Loss';
                    default: return 'Unknown';
                }
            })
            ->addColumn('review', function ($row) {
                return Str::words(strip_tags($row->review), 30, '...');
            })
            ->addColumn('action', function ($row) {
                $action = '<ul class="action">';
                $action .= '<li class="edit">
                                <a href="javascript:;" onclick="openEditModal('.$row->id.')">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>';
                $action .= '<li class="delete">
                                <a href="javascript:;" onclick="deleteTestimonial('.$row->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>';
                $action .= '</ul>';

                return $action;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'type', 'review']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TestiMonial $model): QueryBuilder
    {
        return $model->newQuery()->where('is_delete',0)->orderBy('id', 'asc');;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('testimonial-table')
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
            Column::make('DT_RowIndex')->title('Id')->orderable(false)->searchable(false)->width(5),
            Column::make('type')->title('Type'),
            Column::make('name'),
            Column::make('address')->title('Subtitle'),
            Column::make('rating'),
            Column::make('review'),
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
        return 'Testimonial_'.date('YmdHis');
    }
}
