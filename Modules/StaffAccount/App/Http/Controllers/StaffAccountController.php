<?php

namespace Modules\StaffAccount\App\Http\Controllers;

use App\DataTables\StaffAccountDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Partner\App\Models\Company;
use Modules\Partner\App\Models\CompanyStaff;

class StaffAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StaffAccountDataTable $dataTable)
    {
        return $dataTable->render('staffaccount::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staffaccount::modals.addStaff');
    }

    public function staffDetails($staffId)
    {
        $staffDetails = CompanyStaff::where('id', $staffId)->first();
        $logs = DB::table('administrations_logs')
            ->where('staff_id', $staffId)
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();
        return view('staffaccount::staffdetails', compact('staffDetails', 'logs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:company_staff,email',
            'mobile_no' => ['required', 'numeric', 'regex:/^[6-9]\d{9}$/'],
            'password' => 'required|confirmed'
        ]);
        $companyId = $request->company_id;
        $staffData = [
            'company_id' => $companyId,
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'staff_code' => generateStaffCode(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $staff = CompanyStaff::create($staffData);
        if ($staff) {
            $emailContent = view('emails.partner_create', [
                'company_code' => Company::where('id', $companyId)->value('company_code'),
                'name' => $staff->name,
                'email' => $staff->email,
                'password' => $request->password,
            ])->render();
            $subject = "Welcome to Fittoss Partner Portal - Your Account Has Been Created!";
            $maildata = array(
                'fullname' => $staff->name,
                'email' => $staff->email,
            );
            sendBrevoHtmlMail2($maildata, $subject, $emailContent);
            $message = 'Staff created successfully';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong', 'data' => []));
        }
    }

    public function statusChange(Request $request)
    {
        $input = $request->all();
        $result = CompanyStaff::where('id', $input['id'])->first();
        CompanyStaff::where('id', $result['id'])->update(['is_active' => $input['status'] == 1 ? 0 : 1]);
        $message = 'Status changed successfully';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    public function updatePassword(Request $request)
    {
        $user = CompanyStaff::find($request->input('userid'));
        if ($user != null) {
            $request->validate([
                'new_password' => 'required',
                'retype_password' => 'required|same:new_password'
            ]);
            $result = $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Password updated successfully', 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong', 'data' => []));
            }
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'User not found', 'data' => []));
        }
    }

    public function deactivateAccount(Request $request)
    {
        $updateData = array('is_active' => $request->input('status'));
        $result = CompanyStaff::where('id', $request->input('userid'))->update($updateData);
        $message = '';
        if ($request->input('status') == 1) {
            $message = 'Account activated successfully';
        } else {
            $message = 'Account deactivate successfully';
        }
        if ($result > 0) {
            return response()->json(['type' => 'SUCCESS', 'message' => $message]);
        } else {
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong']);
        }
    }

    public function updateStaffDetails(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:company_staff,email,' . $request->input('userid'),
            'mobile_no' => ['required', 'numeric', 'regex:/^[6-9]\d{9}$/'],
        ]);
        $upd = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile_no' => $request->input('mobile_no'),
            'position' => $request->input('position'),
            'role' => $request->input('role'),
        ];
        $result = CompanyStaff::where('id', $request->input('userid'))->update($upd);
        if ($result > 0) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Staff data updated successfully'));
        } else {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Nothing for update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $res = CompanyStaff::where('id', $input['userid'])->update(['is_delete' => 1, 'is_active' => 0]);
        if ($res > 0) {
            $message = 'Staff Account deleted successfully';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        }
        return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
    }
}
