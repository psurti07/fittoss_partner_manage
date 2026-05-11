<?php

namespace Modules\LeaveApplication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveApplication;
use App\DataTables\LeaveApplicationDataTable;
use App\Models\LeaveApproval;
use Illuminate\Support\Facades\Log;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(LeaveApplicationDataTable $dataTable)
    {
        return $dataTable->render('leaveapplication::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('leaveapplication::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function approveLeave(Request $request, $id)
    {
        $validated = $request->validate([
            'leave_status' => 'required|in:0,1,2',
            'paid_leave' => 'nullable|in:1',
            'unpaid_leave' => 'nullable|in:1',
            'no_of_paid_leaves' => 'nullable|numeric',
            'no_of_unpaid_leaves' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        try {
            $leave = LeaveApplication::findOrFail($id);

            $noOfPaidLeaves = $validated['no_of_paid_leaves'] ?? 0;
            $noOfUnpaidLeaves = $validated['no_of_unpaid_leaves'] ?? 0;
            $totalApprovedLeaves = $noOfPaidLeaves + $noOfUnpaidLeaves;
            $requestedDays = $leave->no_of_days;

            if ($totalApprovedLeaves > $requestedDays) {
                return response()->json([
                    'type' => 'ERROR',
                    'message' => 'The total number of paid and unpaid leaves cannot exceed the number of requested days (' . $requestedDays . ').'
                ], 422);
            }

            // If leave is approved, at least one type must be selected
            if ($validated['leave_status'] == 1 && ($noOfPaidLeaves == 0 && $noOfUnpaidLeaves == 0)) {
                return response()->json([
                    'type' => 'ERROR',
                    'message' => 'When approving leave, you must assign at least 1 Paid or Unpaid leave.'
                ], 422);
            }


            $paid_leave = $validated['paid_leave'] ?? 0;
            $unpaid_leave = $validated['unpaid_leave'] ?? 0;

            $lastApproval = LeaveApproval::where('emp_id', $leave->emp_id)
                ->orderBy('id', 'desc')
                ->first();

            $defaultLeaves = 12;

            $currentBalance = $lastApproval ? $lastApproval->total_leaves : $defaultLeaves;

            $newBalance = $currentBalance - $noOfPaidLeaves;

            LeaveApproval::updateOrCreate(
                [
                    'leave_id' => $leave->id,
                    'emp_id' => $leave->emp_id
                ],
                [
                    'rec_date' => now(),
                    'total_leaves' => $newBalance,
                    'leave_status' => $validated['leave_status'],
                    'paid_leave' => $paid_leave,
                    'unpaid_leave' => $unpaid_leave,
                    'no_of_paid_leaves' => $noOfPaidLeaves,
                    'no_of_unpaid_leaves' => $noOfUnpaidLeaves,
                    'remarks' => $validated['remarks'] ?? null,
                ]
            );

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Leave updated successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error storing Leave Application', ['error' => $e->getMessage()]);
            return response()->json([
                'type' => 'ERROR',
                'message' => 'Failed to update Leave!'
            ], 500);
        }
    }

    public function edit($id)
    {
        $leave = LeaveApplication::findOrFail($id);
        $approval = LeaveApproval::where('leave_id', $leave->id)->first();
        return view('leaveapplication::modals.showLeaveUpdate', compact('leave', 'approval'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'leave_type'   => 'required|string',
            'other_reason' => 'nullable|string',
            'from_date'    => 'required|date',
            'to_date'      => 'required|date',
            'no_of_days'   => 'required|numeric',
            'half_day'     => 'nullable|boolean',
            'from_time'    => 'nullable',
            'to_time'      => 'nullable',
            'comments'     => 'nullable|string',
        ]);

        try {
            $user = Auth::user();

            $from = Carbon::parse($validated['from_date']);
            $to   = Carbon::parse($validated['to_date']);
            $no_of_days = $from->diffInDays($to) + 1;

            if ($request->has('half_day') && $request->half_day) {
                if ($from->equalTo($to)) {
                    $no_of_days = 0.5;
                } else {
                    $no_of_days = $no_of_days - 0.5;
                }
            }

            $leaveType = $validated['leave_type'] === 'Others'
                ? ($validated['other_reason'] ?? 'Others')
                : $validated['leave_type'];

            $leave = LeaveApplication::findOrFail($id);

            $approval = LeaveApproval::where('leave_id', $leave->id)->first();
            if ($approval) {
                // Restore old paid leaves first
                $approval->total_leaves = $approval->total_leaves + ($approval->no_of_paid_leaves ?? 0);

                // Deduct new paid leaves
                $approval->total_leaves = $approval->total_leaves - ($request->no_of_paid_leaves ?? 0);

                // Update details
                $approval->no_of_paid_leaves = $request->no_of_paid_leaves ?? 0;
                $approval->no_of_unpaid_leaves = $request->no_of_unpaid_leaves ?? 0;
                $approval->remarks = $request->remarks ?? $approval->remarks;
                $approval->save();
            }

            $leave->update([
                'leave_type'  => $leaveType,
                'from_date'   => $validated['from_date'],
                'to_date'     => $validated['to_date'],
                'no_of_days'  => $no_of_days,
                'half_day'    => $validated['half_day'] ?? 0,
                'from_time'   => $validated['from_time'] ?? null,
                'to_time'     => $validated['to_time'] ?? null,
                'comments'    => $validated['comments'] ?? null,
            ]);

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Leave updated successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error updating Leave Application ', ['error' => $e->getMessage()]);
            return response()->json([
                'type' => 'ERROR',
                'message' => 'Failed to update Leave !'
            ], 500);
        }
    }
}
