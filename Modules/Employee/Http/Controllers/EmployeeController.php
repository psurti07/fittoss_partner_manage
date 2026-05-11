<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Employee;
use App\DataTables\EmployeeDataTable;
use App\Models\Attendance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(EmployeeDataTable $dataTable)
    {
        return $dataTable->render('employee::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employee::modals.addEmployee');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        Log::info('Store method called', ['request' => $request->all()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|digits:10|regex:/^[6-9]\d{9}$/|unique:employees,mobile_no',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required',
            'department' => 'required|string|max:255',
            'dob' => 'required|date',
            'doj' => 'required|date',
            'resign_date' => 'nullable|date',
            'address' => 'nullable',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'reference_name' => 'nullable|string|max:255',
            'reference_mobile' => 'nullable|digits:10|regex:/^[6-9]\d{9}$/',
            'reference_dob' => 'nullable|date',
            'punching_code' => 'nullable',
            'salary' => 'nullable|numeric',
            'remarks' => 'nullable',
            'bonus_start_date' => 'nullable|date',
            'bonus_end_date' => 'nullable|date',
            'bonus_eligible_date' => 'nullable|date',
            'probation_start_date' => 'nullable|date',
            'probation_end_date' => 'nullable|date',
            'aadhaar_card' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'pan_card' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'cancel_cheque' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'address_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        try {
            $employee = Employee::create([
                'rec_date' => now(),
                'name' => $validated['name'],
                'mobile_no' => $validated['mobile_no'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'department' => $validated['department'],
                'dob' => $validated['dob'],
                'doj' => $validated['doj'],
                'resign_date' => $validated['resign_date'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'reference_name' => $validated['reference_name'] ?? null,
                'reference_mobile' => $validated['reference_mobile'] ?? null,
                'reference_dob' => $validated['reference_dob'] ?? null,
                'punching_code' => random_code_num(6),
                'salary' => $validated['salary'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
                'bonus_start_date' => $validated['bonus_start_date'] ?? null,
                'bonus_end_date' => $validated['bonus_end_date'] ?? null,
                'bonus_eligible_date' => $validated['bonus_eligible_date'] ?? null,
                'probation_start_date' => $validated['probation_start_date'] ?? null,
                'probation_end_date' => $validated['probation_end_date'] ?? null,
                'isActive' => 1,
                'isDelete' => 0,
            ]);

            $folder = public_path("upload/employees/{$employee->id}");
            if (!file_exists($folder)) {
                mkdir($folder, 0775, true);
            }

            if ($request->hasFile('aadhar_card')) {
                $image = $request->file('aadhar_card');
                $fileName = 'aadhar_card.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $employee->aadhar_card = "upload/employees/{$employee->id}/{$fileName}";
            }

            if ($request->hasFile('pan_card')) {
                $image = $request->file('pan_card');
                $fileName = 'pan_card.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $employee->pan_card = "upload/employees/{$employee->id}/{$fileName}";
            }

            if ($request->hasFile('passport_photo')) {
                $image = $request->file('passport_photo');
                $fileName = 'passport_photo.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $employee->passport_photo = "upload/employees/{$employee->id}/{$fileName}";
            }

            if ($request->hasFile('cancel_cheque')) {
                $image = $request->file('cancel_cheque');
                $fileName = 'cancel_cheque.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $employee->cancel_cheque = "upload/employees/{$employee->id}/{$fileName}";
            }

            if ($request->hasFile('address_proof')) {
                $image = $request->file('address_proof');
                $fileName = 'address_proof.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $employee->address_proof = "upload/employees/{$employee->id}/{$fileName}";
            }

            $employee->save();

            return response()->json(['type' => 'SUCCESS', 'message' => 'Employee added successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Error storing Employee ', ['error' => $e->getMessage()]);
            return response()->json(['type' => 'error', 'message' => 'Failed to add Employee !'], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('employee::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $attendance = Attendance::where('emp_id', $id)->orderBy('rec_date', 'desc')->get();
        return view('employee::employeedetails', [
            'data' => $employee,
            'attendance' => $attendance,
        ]);
    }

    public function update(Request $request, $id)
    {
        Log::info('Update method called', ['request' => $request->all()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|digits:10|regex:/^[6-9]\d{9}$/|unique:employees,mobile_no,' . $id,
            'email' => 'required|email|unique:employees,email,' . $id,
            'password' => 'nullable',
            'department' => 'required|string|max:255',
            'dob' => 'required|date',
            'doj' => 'required|date',
            'resign_date' => 'nullable|date',
            'address' => 'nullable',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'reference_name' => 'nullable|string|max:255',
            'reference_mobile' => 'nullable|digits:10|regex:/^[6-9]\d{9}$/',
            'reference_dob' => 'nullable|date',
            'punching_code' => 'nullable',
            'salary' => 'nullable|numeric',
            'remarks' => 'nullable',
            'bonus_start_date' => 'nullable|date',
            'bonus_end_date' => 'nullable|date',
            'bonus_eligible_date' => 'nullable|date',
            'probation_start_date' => 'nullable|date',
            'probation_end_date' => 'nullable|date',
            'aadhaar_card' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'pan_card' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'cancel_cheque' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'address_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        try {
            $employee = Employee::findOrFail($id);

            $updateData = [
                'rec_date' => now(),
                'name' => $validated['name'],
                'mobile_no' => $validated['mobile_no'],
                'email' => $validated['email'],
                'department' => $validated['department'],
                'dob' => $validated['dob'],
                'doj' => $validated['doj'],
                'resign_date' => $validated['resign_date'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'reference_name' => $validated['reference_name'] ?? null,
                'reference_mobile' => $validated['reference_mobile'] ?? null,
                'reference_dob' => $validated['reference_dob'] ?? null,
                'punching_code' => random_code_num(6),
                'salary' => $validated['salary'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
                'bonus_start_date' => $validated['bonus_start_date'] ?? null,
                'bonus_end_date' => $validated['bonus_end_date'] ?? null,
                'bonus_eligible_date' => $validated['bonus_eligible_date'] ?? null,
                'probation_start_date' => $validated['probation_start_date'] ?? null,
                'probation_end_date' => $validated['probation_end_date'] ?? null,
                'isActive' => 1,
                'isDelete' => 0,
            ];

            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $folder = public_path("upload/employees/{$employee->id}");
            if (!file_exists($folder)) {
                mkdir($folder, 0775, true);
            }

            // Aadhar Card
            if ($request->hasFile('aadhaar_card')) {
                if (!empty($employee->aadhaar_card) && file_exists(public_path($employee->aadhaar_card))) {
                    unlink(public_path($employee->aadhaar_card));
                }
                $image = $request->file('aadhaar_card');
                $fileName = 'aadhaar_card.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $updateData['aadhaar_card'] = "upload/employees/{$employee->id}/{$fileName}";
            }

            // PAN Card
            if ($request->hasFile('pan_card')) {
                if (!empty($employee->pan_card) && file_exists(public_path($employee->pan_card))) {
                    unlink(public_path($employee->pan_card));
                }
                $image = $request->file('pan_card');
                $fileName = 'pan_card.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $updateData['pan_card'] = "upload/employees/{$employee->id}/{$fileName}";
            }

            // Passport
            if ($request->hasFile('passport_photo')) {
                if (!empty($employee->passport_photo) && file_exists(public_path($employee->passport_photo))) {
                    unlink(public_path($employee->passport_photo));
                }
                $image = $request->file('passport_photo');
                $fileName = 'passport_photo.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $updateData['passport_photo'] = "upload/employees/{$employee->id}/{$fileName}";
            }

            // Cancel Cheque
            if ($request->hasFile('cancel_cheque')) {
                if (!empty($employee->cancel_cheque) && file_exists(public_path($employee->cancel_cheque))) {
                    unlink(public_path($employee->cancel_cheque));
                }
                $image = $request->file('cancel_cheque');
                $fileName = 'cancel_cheque.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $updateData['cancel_cheque'] = "upload/employees/{$employee->id}/{$fileName}";
            }

            // Address Proof
            if ($request->hasFile('address_proof')) {
                if (!empty($employee->address_proof) && file_exists(public_path($employee->address_proof))) {
                    unlink(public_path($employee->address_proof));
                }
                $image = $request->file('address_proof');
                $fileName = 'address_proof.' . $image->getClientOriginalExtension();
                $image->move($folder, $fileName);
                $updateData['address_proof'] = "upload/employees/{$employee->id}/{$fileName}";
            }

            $employee->update($updateData);

            return response()->json(['type' => 'SUCCESS', 'message' => 'Employee updated successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Error updating Employee', ['error' => $e->getMessage()]);
            return response()->json(['type' => 'error', 'message' => 'An error occurred while updating the Employee. Please try again.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Log::info('Destroy method called', ['id' => $id]);
        try {
            $employee = Employee::findOrFail($id);
            $employee->update(['isDelete' => 1, 'isActive' => 0]);
    
            Log::info('Employee deleted successfully', ['employee' => $employee]);
    
            return response()->json(['type' => 'SUCCESS', 'message' => 'Employee deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting Employee', ['error' => $e->getMessage()]);
    
            return response()->json(['type' => 'error', 'message' => 'An error occurred while deleting the Employee. Please try again.'], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->isActive = !$employee->isActive;
            $employee->save();

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Employee status updated successfully',
                'status' => $employee->isActive
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    public function toggleKycApproval($id)
    {
        Log::info('toggleKycApproval method called', ['id' => $id]);
        try {
            $employee = Employee::findOrFail($id);
            $employee->isApproved = !$employee->isApproved;
            $employee->save();

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'KYC approval status updated successfully',
                'status' => $employee->isApproved ? 'Approved' : 'Pending'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error toggling KYC approval status', ['error' => $e->getMessage()]);
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to update KYC status'
            ], 500);
        }
    }

    public function deleteKycFile(Request $request, $id)
    {
        $field = $request->input('field');

        if (!in_array($field, ['aadhaar_card', 'pan_card', 'passport_photo', 'cancel_cheque', 'address_proof'])) {
            return response()->json(['type' => 'error', 'message' => 'Invalid field.'], 400);
        }

        try {
            $employee = Employee::findOrFail($id);

            if ($employee->$field && file_exists(public_path($employee->$field))) {
                unlink(public_path($employee->$field));
            }

            $employee->$field = null;
            $employee->save();

            return response()->json([
                'type' => 'SUCCESS',
                'message' => ucfirst(str_replace('_', ' ', $field)) . ' deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to delete file.'
            ], 500);
        }
    }
}
