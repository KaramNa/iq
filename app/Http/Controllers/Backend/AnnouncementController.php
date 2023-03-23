<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:announcements-create', ['only' => ['create', 'store']]);
        $this->middleware('can:announcements-read', ['only' => ['show', 'index']]);
        $this->middleware('can:announcements-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:announcements-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $announcements = Announcement::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }

            $q->where('title', 'LIKE', '%' . $request->key . '%');
        })->orderBy('id', 'DESC')->paginate();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $options = $this->getOptions();
        return view('admin.announcements.create', compact('options'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required'
        ]);
        $announcement = Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'url' => $request->url,
            'location' => $request->location,
            'open_url_in' => $request->open_url_in == "NEW_WINDOW" ? "NEW_WINDOW" : "CURRENT_WINDOW",
        ]);

        if ($request->hasFile('image')) {
            $image = $announcement->addMedia($request->image)->toMediaCollection('image');
            $announcement->update(['image' => $image->id . '/' . $image->file_name]);
        }

        toastr()->success(__('utils/toastr.store_success_message'));
        return redirect()->route('admin.announcements.index');
    }

    public function show(Announcement $announcement)
    {
    }

    public function edit(Announcement $announcement)
    {
        $options = $this->getOptions();
        return view('admin.announcements.edit', compact('announcement', 'options'));
    }


    public function update(Request $request, Announcement $announcement)
    {
        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'url' => $request->url,
            'location' => $request->location,
            'open_url_in' => $request->open_url_in == "NEW_WINDOW" ? "NEW_WINDOW" : "CURRENT_WINDOW",
        ]);
        if ($request->hasFile('image')) {
            $image = $announcement->addMedia($request->image)->toMediaCollection('image');
            $announcement->update(['image' => $image->id . '/' . $image->file_name]);
        }
        toastr()->success(__('utils/toastr.update_success_message'));
        return redirect()->route('admin.announcements.index');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        toastr()->success(__('utils/toastr.destroy_success_message'));
        return redirect()->route('admin.announcements.index');
    }

    private function getOptions()
    {
        return collect([
            (object) ['id' => 'HOME', 'name' => trans('admin.ad_select_location.main')],
            (object) ['id' => 'TOP', 'name' => trans('admin.ad_select_location.top')],
            (object) ['id' => 'ASIDE', 'name' => trans('admin.ad_select_location.aside')],
            (object) ['id' => 'FOOTER', 'name' => trans('admin.ad_select_location.footer')],
            (object) ['id' => 'POPUP', 'name' => trans('admin.ad_select_location.popup')],
        ]);
    }
}
