<?php

namespace App\DataTables;

use App\Models\CareerEnquiry;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CareerEnquiryDataTable extends DataTable
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
            ->addColumn('resume', function ($row) {
                if (!empty($row->resume)) {
                    $resumeFile = basename($row->resume);

                    $resumePath = asset('assets/images/resumes/' . $resumeFile);

                    return '<a href="' . $resumePath . '" target="_blank">
                                <i class="icofont icofont-file-pdf" style="color: red;"></i>
                            </a>';
                }
                return 'N/A';
            })
            ->addColumn('action', function ($row) {
                return '<ul class="action">
                            <li class="delete">
                                <a href="javascript:;" onclick="deleteCareerEnquiry('.$row->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->setRowId('id')
            ->rawColumns(['action','resume']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CareerEnquiry $model): QueryBuilder
    {
        return $model->newQuery()->where('is_delete',0);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('careerenquiry-table')
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
            Column::make('rec_date')->title('Date'),
            Column::make('firstname'),
            Column::make('lastname'),
            Column::make('mobile')->title('Mobile No'),
            Column::make('email')->title('Email'),
            Column::make('resume')->title('Resume'),
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
        return 'CareerEnquiry_' . date('YmdHis');
    }
}
