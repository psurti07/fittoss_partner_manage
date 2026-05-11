<?php

namespace Modules\Partner\App\Http\Controllers;

use App\DataTables\PartnerDataTable;
use App\Http\Controllers\Controller;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Partner\App\Models\Company;
use Modules\Partner\App\Models\Partner;

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
            'name' => 'required',
            'email' => 'required|email|unique:partners,email',
            'mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'dob' => 'nullable|date',
            'address' => 'nullable',

            'company_type' => 'required',
            'company_name' => 'required',
            'company_mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'company_email' => 'required|email|unique:companies,company_email',
            'register_date' => 'required|date',
            'company_live_date' => 'nullable',
            'project_name' => 'nullable',
            'website_url' => 'required|url',
            'company_gst_no' => 'nullable',
            'company_fssai' => 'nullable',
            'company_address' => 'nullable',
        ]);

        $partnerData = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address ?? NULL,
            'dob' => $request->dob ?? NULL,
        ];
        // if ($request->hasFile('image')) {
        //     $partnerData['image'] = $this->uploadImage($request->file('image'), Partner::IMAGE_FOLDER);
        // }

        $partner = Partner::create($partnerData);

        $companyData = [
            'partner_id' => $partner->id,
            'company_code' => generateCompanyCode($request->company_name),
            'company_type' => $request->company_type,
            'company_name' => $request->company_name,
            'company_mobile_no' => $request->company_mobile_no,
            'company_email' => $request->company_email,
            'company_gst_no' => $request->company_gst_no ?? NULL,
            'company_fssai' => $request->company_fssai ?? NULL,
            'company_address' => $request->company_address ?? NULL,
            'register_date' => $request->register_date,
            'website_url' => $request->website_url ?? NULL,
            'company_live_date' => $request->company_live_date ?? NULL,
            'project_name' => $request->project_name ?? NULL,
        ];
        // if ($request->hasFile('logo')) {
        //     $companyData['company_logo'] = $this->uploadImage($request->file('logo'), Company::IMAGE_FOLDER);
        // }
        Company::create($companyData);
        if ($partner) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Partner Added Successfully', 'data' => encrypt($partner->id)));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong while adding partner'));
        }
    }

    public function details($partnerId)
    {
        try {
            $partner = Partner::with('company')->where('id', decrypt($partnerId))->first();
            return view('partner::detail', compact('partner'));
        } catch (\Exception $e) {
            Log::error('error', ['error' => $e->getMessage()]);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'new_password' => 'required',
            'retype_password' => 'required|same:new_password'
        ]);
        $partner = Partner::find($request->partner_id);
        if (!empty($partner)) {
            $result = $partner->update([
                'password' => Hash::make($request->new_password),
            ]);
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Password updated successfully', 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong', 'data' => []));
            }
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Partner not found', 'data' => []));
        }
    }

    public function deactivateAccount(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'status' => 'required',
        ]);
        $user = Partner::find($request->partner_id);
        if ($user) {
            $updateData = array('is_active' => $request->status);
            $result = Partner::where('id', $request->partner_id)->update($updateData);
            $message = '';
            if ($request->status == 1) {
                $message = 'Account activated successfully';
            } else {
                $message = 'Account deactivate successfully';
            }
            if ($result > 0) {
                return response()->json(['type' => 'SUCCESS', 'message' => $message, 'data' => encrypt($request->partner_id)]);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong']);
            }
        } else {
            return response()->json(['type' => 'ERROR', 'message' => 'Invalid user perform action']);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'status' => 'required',
        ]);
        $result = Partner::where('id', $request->partner_id)->first();
        if ($result) {
            $res = Partner::where('id', $result['id'])->update(['is_delete' => 1]);
            if ($res) {
                $message = 'Partner Account deleted successfully';
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
            }
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'company_type' => 'required',
            'company_name' => 'required',
            'company_mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'company_email' => 'required|email|unique:companies,company_email,' . $request->company_id . ',id',
            'register_date' => 'required|date',
            'website_url' => 'required|url',
            'company_gst_no' => 'nullable',
            'company_fssai' => 'nullable',
            'company_address' => 'nullable',
            'company_live_date' => 'nullable',
            'project_name' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'pincode' => 'nullable',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'company_icon' => 'nullable|image|mimes:ico,png|max:2048',
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
                'register_date' => $request->register_date,
                'website_url' => $request->website_url ?? NULL,
                'company_live_date' => $request->company_live_date ?? NULL,
                'project_name' => $request->project_name ?? NULL,
                'city' => $request->city ?? NULL,
                'state' => $request->state ?? NULL,
                'pincode' => $request->pincode ?? NULL,
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
                return response()->json(['type' => 'SUCCESS', 'message' => 'Partner Company details updated successfully']);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'No changes detected or update failed']);
            }
        } catch (\Exception $e) {
            Log::error('Company update error', ['error' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong while updating partner']);
        }
    }

    public function updatePersonal(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'name' => 'required',
            'email' => 'required|email|unique:partners,email,' . $request->partner_id,
            'mobile_no' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            'dob' => 'nullable|date',
            'address' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        try {
            $partnerData = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
                'dob' => $request->dob ?? NULL,
                'address' => $request->address ?? NULL,
            ];
            if ($request->hasFile('image')) {
                $oldImage = Partner::where('id', $request->partner_id)->value('image');
                $this->deleteImage($oldImage, Partner::IMAGE_FOLDER);
                $partnerData['image'] = $this->uploadImage($request->file('image'), Partner::IMAGE_FOLDER);
            }
            $result = Partner::where('id', $request->partner_id)->update($partnerData);
            if ($result > 0) {
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Partner Personal details updated successfully'));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong while adding partner'));
            }
        } catch (\Exception $e) {
            Log::error('error', ['error' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
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
