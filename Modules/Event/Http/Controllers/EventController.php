<?php

namespace Modules\Event\Http\Controllers;

use App\Traits\HandlesImageUpload;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Event\Models\Event;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
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
                1 => 'updated_at',
                2 => 'title',
                3 => 'date',
                4 => 'amount',
                5 => 'offer_amount',
                6 => 'in_offer',
            ];
            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');

            $query = Event::select(
                'id',
                'updated_at',
                'title',
                'date',
                'amount',
                'offer_amount',
                'in_offer'
            )->where('is_active', true);

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('amount', 'like', "%{$search}%")
                        ->orWhere('offer_amount', 'like', "%{$search}%");
                });
            }
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('updated_at', 'desc');
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('updated_at', fn($row) => $row->updated_at->format('d-m-Y H:i:s'))
                ->editColumn('date', fn($row) => $row->date->format('d-m-Y'))
                ->editColumn('amount', fn($row) => number_format($row->amount, 2))
                ->editColumn('offer_amount', fn($row) => number_format($row->offer_amount, 2))
                ->editColumn('in_offer', function ($row) {
                    return $row->in_offer
                        ? '<span class="badge bg-success">Yes</span>'
                        : '<span class="badge bg-danger">No</span>';
                })        
                ->rawColumns(['in_offer'])
                ->make(true);
        }
        return view('event::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('event::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'offer_amount' => 'required',
            'description' => 'nullable',
            'coach_name' => 'nullable',
            'date' => 'nullable',
            'end_time' => 'nullable',
            'start_time' => 'nullable',
            'language' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        try {
            $data = $request->only([
                'title',
                'amount',
                'offer_amount',
                'description',
                'coach_name',
                'date',
                'end_time',
                'start_time',
                'language',
            ]);

            $data['in_offer'] = $request->has('in_offer');
            $data['created_at'] = now();
            $data['updated_at'] = now();

            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImage($request->file('image'), Event::IMAGE_FOLDER);
            }
            Event::create($data);

            return redirect()
                ->route('manage.events.index')
                ->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            Log::error('store', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()
                ->back()
                ->with('error', 'Something went wrong,Please try again later.');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('event::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Event $event)
    {
        return view('event::edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'offer_amount' => 'required',
            'description' => 'nullable',
            'coach_name' => 'nullable',
            'date' => 'nullable',
            'end_time' => 'nullable',
            'start_time' => 'nullable',
            'language' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        try {
            $data = $request->only([
                'title',
                'amount',
                'offer_amount',
                'description',
                'coach_name',
                'date',
                'end_time',
                'start_time',
                'language',
            ]);

            $data['in_offer'] = $request->has('in_offer');
            $data['updated_at'] = now();
            if ($request->hasFile('image')) {
                $this->deleteImage($event->image, Event::IMAGE_FOLDER);
                $data['image'] = $this->uploadImage($request->file('image'), Event::IMAGE_FOLDER);
            }
            $event->update($data);

            return redirect()
                ->route('manage.events.index')
                ->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            Log::error('update', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()
                ->back()
                ->with('error', 'Something went wrong,Please try again later.');
        }
    }

    public function priceUpdate(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'offer_amount' => 'required',
            'in_offer' => 'required',
        ], [
            'amount.required' => 'Event amount field is required',
            'offer_amount.required' => 'Event offer amount field is required',
            'in_offer.required' => 'Event in offer field is required',
        ]);
        try {
            Event::where('id', $request->id)->update([
                'amount' => $request->amount,
                'offer_amount' => $request->offer_amount,
                'in_offer' => $request->in_offer,
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Event updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('priceUpdate', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong,Please try again later.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Event $event)
    {
        try {
            $event->is_active = false;
            $event->updated_at = now();
            $event->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Event updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('destroy', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong,Please try again later.'], 500);
        }
    }
}
