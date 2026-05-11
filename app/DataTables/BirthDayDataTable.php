<?php

namespace App\DataTables;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BirthDayDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('dob', function ($row) {
                return Carbon::parse($row->dob)->format('d/m/Y');
            })
            ->addColumn('action', function ($row) {
                return '<ul class="action">
                            <li class="edit"> 
                                <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')">
                                    <i class="icon-info-alt"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->setRowId('id');
    }

    public function query(Employee $model): QueryBuilder
    {
        $month = $this->request()->get('month_id');

        $query = $model->newQuery()->where('isDelete', 0);

        if (!empty($month) && $month !== 'all') {
            $query->whereMonth('dob', $month);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('birthday-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(2,'asc')
                    ->responsive(true)
                    ->scrollX(true)
                    ->lengthMenu([50, 100, 200, 300])
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(50),
            Column::make('name')->title('Employee Name'),
            Column::make('dob')->title('Date of Birth'),
            Column::computed('action')->responsivePriority(11)
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'BirthDay_' . date('YmdHis');
    }
}