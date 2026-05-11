<?php

namespace Modules\Faq\App\Http\Controllers;

use App\DataTables\FaqDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Faq\App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FaqDataTable $datatable)
    {
        return $datatable->render('faq::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = get_category();

        return view('faq::modals.addfaq', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'question' => 'required',
                'answer' => 'required',
                'category' => 'required',
            ]);

            $faq = Faq::create([
                'question' => $request['question'],
                'answer' => $request['answer'],
                'category_id' => $request['category'],
            ]);

            return response()->json(['type' => 'success', 'message' => 'Faq created successfully.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            dd($e);

            return response()->json(['type' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('faq::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Faq::findOrFail($id);
        $categories = get_category();

        return view('faq::modals.editfaq', compact('data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'question' => 'required',
                'answer' => 'required',
                'category' => 'required',
            ]);

            $faq = Faq::findOrFail($id);
            $faq->question = $validatedData['question'];
            $faq->answer = $validatedData['answer'];
            $faq->category_id = $validatedData['category'];
            $faq->save();

            return response()->json(['type' => 'success', 'message' => 'Faq Updated successfully.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['type' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();

            return response()->json(['type' => 'success', 'message' => 'Faq deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['type' => 'error', 'message' => 'Something Went Wrong.']);
        }
    }
}
