<?php

namespace Modules\IQTest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\IQTest\Models\TestTaker;

class TestTakerController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:test-takers-create', ['only' => ['create', 'store']]);
        $this->middleware('can:test-takers-read', ['only' => ['show', 'index']]);
        $this->middleware('can:test-takers-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:test-takers-delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        $testTakers = TestTaker::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }

            if ($request->q != null) {
                $q->where('username', 'LIKE', '%' . $request->q . '%');
            }
        })->orderBy('id', 'DESC')->paginate();

        return view('iqtest::admin.test-takers.index', compact('testTakers'));
    }

    public function create()
    {
        return view('iqtest::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('iqtest::show');
    }

    public function edit($id)
    {
        return view('iqtest::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $testTaker = TestTaker::find($id);
//        $testTaker->delete();
        toastr()->success(
            trans('utils/toastr.test-taker_destroy_success_message'),
            trans('utils/toastr.successful_process_message')
        );
        return back();
    }
}
