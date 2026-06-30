<?php

namespace App\DataTables;

use App\Models\WebsiteLinks;
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

class WebsiteLinksDataTable extends DataTable
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
                $action = '<ul class="action text-center">';

                $action .= '<li class="details">
                            <a href="javascript:;" onclick="openEditModal(' . $row->id . ')">
                                <i class="text-success icon-pencil-alt"></i>
                            </a>';

                $action .=            '<a href="javascript:;" onclick="deleteWebsiteLinks(' . $row->id . ')">
                                <i class="text-danger icon-trash"></i>
                            </a>';

                $action .= '</li>
                    </ul>';
                return $action;
            })
            ->addColumn('view', function ($row) {
                if (!empty($row->link)) {
                    return '<a href="' . $row->link . '" target="_blank" class="btn btn-sm btn-warning">View</a>';
                }
                return '-';
            })
            ->editColumn('rec_date', function ($row) {
                return $row->rec_date
                    ? date('d/m/Y H:i:s A', strtotime($row->rec_date))
                    : 'N/A';
            })
            ->editColumn('isActive', function ($row) {
                $statusClass = $row->isActive == 1 ? 'btn-outline-success' : 'btn-outline-danger';
                $statusText = $row->isActive == 1 ? 'Active' : 'Inactive';
                return '<span class="btn btn-xs ' . $statusClass . '" style="cursor:pointer;" onclick="websiteLinksStatus(' . $row->id . ')">' . $statusText . '</span>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'rec_date', 'view', 'isActive']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WebsiteLink $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WebsiteLinks $model, Request $request): QueryBuilder
    {
        return $model->newQuery()
            ->company()
            ->where('isDelete', 0);

        // if (request()->filled('fromdate') && request()->filled('todate')) {
        //     $from = Carbon::parse(request('fromdate'))->startOfDay();
        //     $to   = Carbon::parse(request('todate'))->endOfDay();
        // } else {
        //     $from = Carbon::today()->startOfDay();
        //     $to   = Carbon::today()->endOfDay();
        // }

        // return $query->whereBetween('rec_date', [$from, $to]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('websitelinks-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->pageLength(50)
            ->dom('Blfrtip')
            ->lengthMenu([50, 100, 200, 300])
            ->orderBy(1, 'desc')
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
            ]);
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
            Column::make('title')->title('title')->data('title')->name('Title'),
            Column::computed('view')->exportable(false)->printable(false)->title('Visit Link')->addClass('text-center'),
            Column::make('short_link')->title('Short Link')->addClass('text-center'),
            column::make('isActive')->title('Status')->data('isActive')->name('isActive'),
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
        return 'WebsiteLinks_' . date('YmdHis');
    }
}
