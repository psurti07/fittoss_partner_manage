<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Faq\App\Models\Faq;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FaqDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $action = '<ul class="action">';
                if (auth()->user()->can('faqs-edit', $row)) {
                    $action .= '<li class="edit"> 
                                <a href="javascript:;" onclick="openEditModal(' . $row->id . ')">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>';
                }
                if (auth()->user()->can('faqs-delete', $row)) {
                    $action .= '<li class="delete">
                                <a href="javascript:;" onclick="deleteFaq(' . $row->id . ')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>';
                }
                $action .= '</ul>';

                return $action;
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Faq $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id','desc');;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('faq-table')
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
            Column::make('id'),
            Column::make('question'),
            Column::make('answer'),
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
        return 'Faq_' . date('YmdHis');
    }
}
