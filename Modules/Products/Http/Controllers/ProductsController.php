<?php

namespace Modules\Products\Http\Controllers;

use App\Models\Product;
use App\Traits\HandlesImageUpload;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    use HandlesImageUpload;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                0 => 'id',
                1 => 'rec_date',
                2 => 'productname',
                3 => 'product_title',
                4 => 'amount',
                5 => 'offeramount',
                6 => 'inOffer',
            ];
            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');

            $query = Product::select(
                'id',
                'rec_date',
                'updated_at',
                'productname',
                'product_title',
                'amount',
                'offeramount',
                'inOffer'
            );

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('productname', 'like', "%{$search}%")
                        ->orWhere('product_title', 'like', "%{$search}%")
                        ->orWhere('amount', 'like', "%{$search}%")
                        ->orWhere('offeramount', 'like', "%{$search}%");
                });
            }
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('updated_at', 'desc');
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('amount', fn($row) => number_format($row->amount, 2))
                ->editColumn('offeramount', fn($row) => number_format($row->offeramount, 2))
                ->editColumn('inOffer', function ($row) {
                    return $row->inOffer
                        ? '<span class="badge bg-success">Yes</span>'
                        : '<span class="badge bg-danger">No</span>';
                })
                ->editColumn('product_title', function ($row) {
                    return '<span class="text-muted">' . $row->product_title . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $priceUpdateBtn = '
                            <button type="button"
                            class="btn btn-sm btn-warning editBtn"
                            data-id="' . $row->id . '"
                            data-productname="' . $row->productname . '"
                            data-amount="' . $row->amount . '"
                            data-offeramount="' . $row->offeramount . '"
                            data-inoffer="' . $row->inOffer . '">
                                <i class="fa fa-pen"></i>
                            </button>
                        ';
                    $editPageBtn = '
                            <a class="btn btn-sm btn-primary" href="' . route('manage.products.edit', $row->id) . '">
                                <i class="fa fa-edit"></i>
                            </a>
                        ';
                    $btns = '<div class="btn-group" role="group" aria-label="Actions">'.
                            $priceUpdateBtn .
                            $editPageBtn
                        .'</div>';
                    return $btns;
                })
                ->rawColumns(['inOffer', 'action', 'product_title'])
                ->make(true);
        }
        return view('products::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('products::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('products::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Product $product)
    {
        return view('products::edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'productname' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'offeramount' => 'required',
            'description' => 'nullable',
            'coach_name' => 'nullable',
            'date' => 'nullable',
            'end_time' => 'nullable',
            'start_time' => 'nullable',
            'language' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'productname',
            'amount',
            'offeramount',
            'description',
            'coach_name',
            'date',
            'end_time',
            'start_time',
            'language',
        ]);

        $data['inOffer'] = $request->has('inOffer');

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image, Product::IMAGE_FOLDER);
            $data['image'] = $this->uploadImage($request->file('image'), Product::IMAGE_FOLDER);
        }
        $product->update($data);

        return redirect()
            ->route('manage.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function priceUpdate(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'offeramount' => 'required',
            'inOffer' => 'required',
        ], [
            'amount.required' => 'Product amount field is required',
            'offeramount.required' => 'Product offer amount field is required',
            'inOffer.required' => 'Product in offer field is required',
        ]);

        Product::where('id', $request->id)->update([
            'amount' => $request->amount,
            'offeramount' => $request->offeramount,
            'inOffer' => $request->inOffer,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
