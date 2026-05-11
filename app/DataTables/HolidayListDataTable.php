<?php

namespace App\DataTables;

use App\Models\HolidayList;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class HolidayListDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
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
            ->editColumn('rec_date', function ($row) {
                return $row->rec_date
                    ? \Carbon\Carbon::parse($row->rec_date)->format('d-m-Y')
                    : '-';
            })
            ->editColumn('holiday_date', function ($row) {
                return $row->holiday_date
                    ? \Carbon\Carbon::parse($row->holiday_date)->format('d-m-Y')
                    : '-';
            })
            ->editColumn('holiday_type', function ($row) {
                $statusClass = $row->holiday_type == 0
                    ? 'btn-outline-success'
                    : 'btn-outline-danger';
                $statusText = $row->holiday_type == 0
                    ? 'Full Day'
                    : 'Half Day';
                return '<span class="btn btn-xs ' . $statusClass . '">' . $statusText . '</span>';
            })
            ->addColumn('month_name', function ($row) {
                return $row->holiday_date
                    ? \Carbon\Carbon::parse($row->holiday_date)->format('F')
                    : '-';
            })
            ->addColumn('day_name', function ($row) {
                return $row->holiday_date
                    ? \Carbon\Carbon::parse($row->holiday_date)->format('l')
                    : '-';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'rec_date', 'holiday_type', 'holiday_date', 'month_name', 'day_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\HolidayList $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(HolidayList $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->where('isDelete', 0)
            ->orderByRaw("MONTH(holiday_date), DAY(holiday_date)");

        $month = request()->get('holiday_date');
        $holidaytype = request()->get('holiday_type');
        $holidayStatus = request()->get('holiday_status');

        if ($month) {
            $query->whereMonth('holiday_date', $month);
        }

        if ($holidaytype !== null && $holidaytype !== '') {
            $query->where('holiday_type', $holidaytype);
        }

        if ($holidayStatus === 'upcoming') {
            $query->whereDate('holiday_date', '>=', now()->toDateString());
        } elseif ($holidayStatus === 'previous') {
            $query->whereDate('holiday_date', '<', now()->toDateString());
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('holidaylist-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3,'asc')
            ->selectStyleSingle()
            ->dom('Blfrtip')
            ->lengthMenu([50, 100, 200, 300])
            ->parameters([
                'dom' => 'Bfrtip',
                'responsive' => true,
                'pageLength' => 100,
            ])
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print')
            ])
            ->createdRow("function(row, data, dataIndex) {
                if (data.holiday_date) {
                    // holiday_date is in d-m-Y format from your editColumn
                    var parts = data.holiday_date.split('-'); // [dd, mm, yyyy]
                    var holidayDate = new Date(parts[2], parts[1]-1, parts[0]);
                    var today = new Date();

                    if (holidayDate < today) {
                        $(row).css('background-color', '#ffbbbbff');
                    } else {
                        $(row).css('background-color', '#d4edda');
                    }
                }
            }");
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(5),
            Column::make('rec_date')->title('Date')->data('rec_date')->name('rec_date'),
            Column::make('month_name')->title('Month')->data('month_name')->searchable(false),
            Column::make('holiday_date')->title('Holiday Date')->data('holiday_date')->name('holiday_date'),
            Column::make('day_name')->title('Day')->data('day_name')->searchable(false),
            Column::make('holiday_name')->title('Holiday Name')->data('holiday_name')->name('holiday_name'),
            Column::make('holiday_type')->title('Holiday Type')->data('holiday_type')->name('holiday_type'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'HolidayList_' . date('YmdHis');
    }
}
