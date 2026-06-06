<?php

namespace Modules\Event\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\EventCustomer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    public function customers(Request $request)
    {
        if ($request->ajax()) {
            $columns = EventCustomer::DATATABLE_COLUMNS;
            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $eventId = $request->input('event_id');

            $query = EventCustomer::from('event_customers as ec')
                ->baseCustomerQuery()
                ->userType(EventCustomer::TYPE_USER)
                ->event($eventId)
                ->dateRange($fromDate, $toDate)
                ->search($search);

            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('ec.updated_at', 'desc');
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('attend', function ($row) {
                    if ($row->is_attend) {
                        return '<span class="badge badge-success">Attended</span>';
                    }
                    return '
                            <button type="button"
                                class="btn btn-sm btn-info attendBtn"
                                onclick="attended(' . $row->id . ')">
                                Attend
                            </button>';
                })
                ->addColumn('enroll', function ($row) {

                    if ($row->is_enrolled) {
                        return '<span class="badge badge-success">Enrolled</span>';
                    }

                    return '
                        <button type="button"
                            class="btn btn-sm btn-primary enrollBtn"
                            onclick="openEnrollModal(' . $row->id . ')">
                            Enroll
                        </button>';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action justify-content-center">
                                    <li class="info"> <a class="" href="' . route('manage.events.customers.details', ['userId' => $row->user_id]) . '"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'attend', 'enroll', 'action'])
                ->make(true);
        }
        return view('event::customers');
    }

    public function usersDetails($userId)
    {
        $customer = Customer::where(['id' => $userId, 'is_delete' => 0, 'is_user' => 1])->first();
        $invoices = Invoice::where('userid', $userId)->get();
        $referralUsers = [];
        if ($customer != null) {
            $redirectRoute = route('manage.events.customers');
            return view('event::customerDetails', compact(['customer', 'invoices', 'referralUsers', 'redirectRoute']));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Users not found!', 'data' => ''));
        }
    }

    public function usersDetailsUpdate(Request $request)
    {
        $userId = $request->input('userid');
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|email|unique:customers,email,' . $userId . ',id,product_id,' . config('constant.WEIGHT_LOSS_PROGRAM_ID'),
            'email' => 'required|email',
            'pincode' => 'required|digits:6',
            'state' => 'required',
            'city' => 'required',
        ]);

        $result = Customer::where('id', $userId)->update(array(
            'first_name' => trim(ucfirst($request->input('first_name'))),
            'last_name' => trim(ucfirst($request->input('last_name'))),
            'email' => trim(strtolower($request->input('email'))),
            'pincode' => $request->input('pincode'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
        ));

        if ($result > 0) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Data updated successfully', 'data' => ''));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Data already updated!', 'data' => ''));
        }
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::with('user')
            ->where('id', $id)
            ->firstOrFail();

        $eventDetail = EventCustomer::with('event:title,id')->where('order_id', $invoice->order_id)->first();
        $invoiceData = [
            'invoice' => $invoice,
            'user' => $invoice->user,
            'event_title' => $eventDetail->event->title ?? 'N/A'
        ];
        $pdf = Pdf::loadView('invoice.event_invoice_pdf', $invoiceData)
            ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $invoice->order_id . '.pdf');
    }

    public function markAsAttended(Request $request)
    {
        $request->validate([
            'event_user_id' => 'required'
        ]);
        $res = EventCustomer::where('id', $request->event_user_id)->update(['is_attend' => 1]);
        if ($res) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'User has been marked as attended successfully!', 'data' => ''));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => ''));
        }
    }
    public function enrollUser(Request $request)
    {
        $request->validate([
            'event_user_id' => 'required',
            'ref_id'  => 'required|string|max:100',
            'amount'  => 'nullable|numeric|min:0',
            'points'  => 'nullable|numeric|min:0',
        ]);
        $res = EventCustomer::where('id', $request->event_user_id)->update([
            'is_enrolled' => 1,
            'ref_id' => $request->ref_id,
            'amount' => $request->amount ?? 0,
            'points' => $request->points ?? 0,
        ]);
        if ($res) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'User has been marked as enrolled successfully!', 'data' => ''));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => ''));
        }
    }


    public function updatePassword(Request $request)
    {
        $user = Customer::find($request->input('userid'));
        if ($user != null) {
            $request->validate([
                'new_password' => 'required',
                'retype_password' => 'required|same:new_password'
            ]);
            $result = $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            if ($result) {
                sendChangePasswordEmail($user->first_name . ' ' . $user->last_name, $user->email, $user->mobile_no, $request->input('new_password'));
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Password updated successfully', 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
            }
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'User not found!', 'data' => []));
        }
    }

    public function deactivateAccount(Request $request)
    {
        $user = Customer::find($request->input('userid'));
        if ($user) {
            $updateData = array('is_active' => $request->input('status'));
            $result = Customer::where('id', $request->input('userid'))->update($updateData);
            $message = '';
            if ($request->input('status') == 1) {
                $message = 'Account activated successfully';
            } else {
                $message = 'Account deactivate successfully';
            }
            if ($result > 0) {
                return response()->json(['type' => 'SUCCESS', 'message' => $message]);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong.']);
            }
        } else {
            return response()->json(['type' => 'ERROR', 'message' => 'Invalid user perform action!']);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $userId = $request->input('userid');
            DB::transaction(function () use ($userId) {
                Invoice::where('userid', $userId)->update(['is_delete' => 1]);
                Customer::where('id', $userId)->update(['is_delete' => 1]);
            });
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Customer remove successfully!'));
        } catch (\Exception $e) {
            Log::error('error', ['error' => $e->getMessage()]);
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.'));
        }
    }
}
