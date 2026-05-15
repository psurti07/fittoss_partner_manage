<?php

namespace Modules\Partner\App\Http\Controllers;

use App\DataTables\PartnerDataTable;
use App\Http\Controllers\Controller;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Partner\App\Models\Company;
use Modules\Partner\App\Models\CompanyStaff;

class PartnerController extends Controller
{
    use HandlesImageUpload;

    public function index(PartnerDataTable $dataTable)
    {
        return $dataTable->render('partner::index');
    }

    public function create()
    {
        return view('partner::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_name' => 'required',
            'owner_email' => 'required|email|unique:companies,owner_email',
            'owner_mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',

            'company_type' => 'required',
            'company_name' => 'required',
            'company_mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'company_email' => 'required|email|unique:companies,company_email',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'project_name' => 'nullable',
            'website_url' => 'required|url',
            'company_gst_no' => 'nullable',
            'company_fssai' => 'nullable',
            'company_address' => 'nullable',
        ]);

        $companyData = [
            'company_code' => generateCompanyCode($request->company_name),
            'company_type' => $request->company_type,
            'company_name' => $request->company_name,
            'company_mobile_no' => $request->company_mobile_no,
            'company_email' => $request->company_email,
            'company_gst_no' => $request->company_gst_no ?? NULL,
            'company_fssai' => $request->company_fssai ?? NULL,
            'company_address' => $request->company_address ?? NULL,
            'city' => $request->city ?? NULL,
            'state' => $request->state ?? NULL,
            'pincode' => $request->pincode ?? NULL,
            'website_url' => $request->website_url ?? NULL,
            'project_name' => $request->project_name ?? NULL,
            'register_date' => date('Y-m-d H:i:s'),

            'owner_name' => $request->owner_name,
            'owner_email' => $request->owner_email,
            'owner_mobile_no' => $request->owner_mobile_no,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // if ($request->hasFile('logo')) {
        //     $companyData['company_logo'] = $this->uploadImage($request->file('logo'), Company::IMAGE_FOLDER);
        // }
        $company = Company::create($companyData);
        $password = substr(now()->format('His') . rand(10, 99), 0, 8);
        $staffData = [
            'company_id' => $company->id,
            'name' => $request->owner_name,
            'email' => $request->owner_email,
            'mobile_no' => $request->owner_mobile_no,
            'password' => Hash::make($password),
            'role' => CompanyStaff::ROLE_PARTNER,
            'position' => 'Owner',
            'staff_code' => generateStaffCode($request->owner_name),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $staff = CompanyStaff::create($staffData);
        if ($staff) {
            $emailContent = view('emails.partner_create', [
                'company_code' => $company->company_code,
                'name' => $staff->name,
                'mobile' => $staff->mobile_no,
                'email' => $staff->email,
                'password' => $password,
            ])->render();
            $subject = "Welcome to Fittoss Partner Portal - Your Account Has Been Created!";
            $maildata = array(
                'fullname' => $staff->name,
                'email' => $staff->email,
            );
            sendBrevoHtmlMail2($maildata, $subject, $emailContent);
        }
        return response()->json(array('type' => 'SUCCESS', 'message' => 'Partner Added Successfully', 'data' => []));
    }

    public function details(int|string $id)
    {
        try {
            $company = Company::where('id', decrypt($id))->first();
            return view('partner::detail', compact('company'));
        } catch (\Exception $e) {
            Log::error('details', ['error' => $e->getMessage()]);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:company_staff,id',
            'new_password' => 'required',
            'retype_password' => 'required|same:new_password'
        ]);

        $result = CompanyStaff::where('id', $request->partner_id)
            ->update([
                'password' => Hash::make($request->new_password),
            ]);
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Password updated successfully', 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong', 'data' => []));
        }
    }

    public function deactivateAccount(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'status' => 'required',
        ]);
        $updateData = array('is_active' => $request->status, 'updated_at' => date('Y-m-d H:i:s'));
        $result = Company::where('id', $request->company_id)->update($updateData);
        $message = '';
        if ($request->status == 1) {
            $message = 'Account activated successfully';
        } else {
            $message = 'Account deactivate successfully';
        }
        if ($result > 0) {
            return response()->json(['type' => 'SUCCESS', 'message' => $message, 'data' => encrypt($request->company_id)]);
        } else {
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong']);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);
        $res = Company::where('id', $request->company_id)->update(['is_delete' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
        if ($res) {
            $message = 'Account deleted successfully';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        }
        return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'company_type' => 'required',
            'company_name' => 'required',
            'company_mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'company_email' => 'required|email|unique:companies,company_email,' . $request->company_id . ',id',
            'website_url' => 'required|url',
            'register_date' => 'nullable|date',
            'company_live_date' => 'nullable|date',
            'company_gst_no' => 'nullable',
            'company_fssai' => 'nullable',
            'company_address' => 'nullable',
            'descriptions' => 'nullable',
            'royalty' => 'nullable',
            'project_name' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'pincode' => 'nullable',
            'company_logo' => 'nullable|image|mimes:png|max:1024',
            'company_icon' => 'nullable|image|mimes:png|max:512',
        ]);
        try {
            $updateData = [
                'company_type' => $request->company_type,
                'company_name' => $request->company_name,
                'company_mobile_no' => $request->company_mobile_no,
                'company_email' => $request->company_email,
                'company_gst_no' => $request->company_gst_no ?? NULL,
                'company_fssai' => $request->company_fssai ?? NULL,
                'company_address' => $request->company_address ?? NULL,
                'descriptions' => $request->descriptions ?? NULL,
                'royalty' => $request->royalty ?? NULL,
                'website_url' => $request->website_url ?? NULL,
                'register_date' => $request->register_date,
                'company_live_date' => $request->company_live_date ?? NULL,
                'project_name' => $request->project_name ?? NULL,
                'city' => $request->city ?? NULL,
                'state' => $request->state ?? NULL,
                'pincode' => $request->pincode ?? NULL,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if ($request->hasFile('company_logo')) {
                $oldLogo = Company::where('id', $request->company_id)->value('company_logo');
                $this->deleteImage($oldLogo, Company::IMAGE_FOLDER);
                $updateData['company_logo'] = $this->uploadImage($request->file('company_logo'), Company::IMAGE_FOLDER);
            }
            if ($request->hasFile('company_icon')) {
                $oldLogo = Company::where('id', $request->company_id)->value('company_icon');
                $this->deleteImage($oldLogo, Company::IMAGE_FOLDER);
                $updateData['company_icon'] = $this->uploadImage($request->file('company_icon'), Company::IMAGE_FOLDER);
            }

            $result = Company::where('id', $request->company_id)->update($updateData);

            if ($result > 0) {
                return response()->json(['type' => 'SUCCESS', 'message' => 'Company details updated successfully']);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'No changes detected or update failed']);
            }
        } catch (\Exception $e) {
            Log::error('updateCompany', ['error' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong while updating partner']);
        }
    }

    public function updatePersonal(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'owner_name' => 'required',
            'owner_email' => 'required|email|unique:companies,owner_email,' . $request->company_id,
            'owner_mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',
        ]);
        try {
            $ownerData = [
                'owner_name' => $request->owner_name,
                'owner_email' => $request->owner_email,
                'owner_mobile_no' => $request->owner_mobile_no,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $result = Company::where('id', $request->company_id)->update($ownerData);
            if ($result > 0) {
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Owner details updated successfully'));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong while adding partner'));
            }
        } catch (\Exception $e) {
            Log::error('updatePersonal', ['error' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong while adding partner'));
        }
    }

    public function updateCompanySocial(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'pinterest_url' => 'nullable|url'
        ]);
        try {
            $updateData = [
                'facebook_url' => $request->facebook_url,
                'instagram_url' => $request->instagram_url,
                'twitter_url' => $request->twitter_url,
                'linkedin_url' => $request->linkedin_url,
                'youtube_url' => $request->youtube_url,
                'pinterest_url' => $request->pinterest_url,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $result = Company::where('id', $request->company_id)->update($updateData);

            if ($result > 0) {
                return response()->json(['type' => 'SUCCESS', 'message' => 'Company social updated successfully']);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'No changes detected or update failed']);
            }
        } catch (\Exception $e) {
            Log::error('updateCompanySocial', ['error' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong while updating partner']);
        }
    }
}
