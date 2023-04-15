<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:test-results-read', ['only' => ['show', 'index']]);
        $this->middleware('can:test-results-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $testResults = TestResult::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
        })->orderBy('id', 'DESC')->paginate();


        return view('admin.test-results.index', compact('testResults'));
    }

    public function destroy($id)
    {
        TestResult::find($id)->delete();

        toastr()->success(
            trans('utils/toastr.test-result_destroy_success_message'),
            trans('utils/toastr.successful_process_message')
        );
        return back();
    }
}
