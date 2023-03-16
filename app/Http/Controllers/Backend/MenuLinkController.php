<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuLink;
use App\Models\Page;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MenuLinkController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:menu-links-create', ['only' => ['create', 'store']]);
        $this->middleware('can:menu-links-read', ['only' => ['show', 'index']]);
        $this->middleware('can:menu-links-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:menu-links-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('menu-links-read')) {
            abort(403);
        }
        $menuLinks = MenuLink::where(function ($q) use ($request) {
            if ($request->menu_id != null) {
                $q->where('menu_id', $request->menu_id);
            }
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
            if ($request->q != null) {
                $q->where('type', 'LIKE', '%' . $request->q . '%')->orWhere('url', 'icon', '%' . $request->q . '%');
            }
        })->orderBy('order', 'ASC')->orderBy('id', 'DESC')->paginate(100);
        return view('admin.menu-links.index', compact('menuLinks'));
    }

    public function create(Request $request)
    {
        if (!auth()->user()->can('menu-links-create')) {
            abort(403);
        }
        $request->validate(['menu_id' => "required|exists:menus,id"]);
        return view('admin.menu-links.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('menu-links-create')) {
            abort(403);
        }
        $this->validateMenuLink($request);

        $menuLink = new MenuLink();

        $this->saveMenuLink($request, $menuLink);

        toastr()->success('تمت العملية بنجاح');
        return redirect()->route('admin.menu-links.index', ['menu_id' => $request->menu_id]);
    }

    public function show(MenuLink $menuLink)
    {
        if (!auth()->user()->can('menu-links-read')) {
            abort(403);
        }
    }

    public function edit(MenuLink $menuLink)
    {
        if (!auth()->user()->can('menu-links-update')) {
            abort(403);
        }
        return view('admin.menu-links.edit', compact('menuLink'));
    }

    public function update(Request $request, MenuLink $menuLink)
    {
        if (!auth()->user()->can('menu-links-update')) {
            abort(403);
        }

        $this->validateMenuLink($request);

        $this->saveMenuLink($request, $menuLink);

        toastr()->success('تمت العملية بنجاح');
        return redirect()->route('admin.menu-links.index', ['menu_id' => $request->menu_id]);
    }

    public function destroy(MenuLink $menuLink)
    {
        if (!auth()->user()->can('menu-links-delete')) {
            abort(403);
        }
        $menu_id = $menuLink->menu_id;
        $menuLink->delete();
        toastr()->success('تمت العملية بنجاح');
        return redirect()->route('admin.menu-links.index', ['menu_id' => $menu_id]);
    }


    public function order(Request $request)
    {
        if (!auth()->user()->can('menu-links-update')) {
            abort(403);
        }
        //return dd($request->order);
        foreach ($request->order as $key => $value) {
            MenuLink::where('id', $value)->update(['order' => $key]);
        }
    }

    public function getType(Request $request)
    {
        if (!auth()->user()->can('menu-links-read')) {
            abort(403);
        }
        if ($request->type == "PAGE") {
            return Page::where(function ($q) use ($request) {
                if ($request->id != null) {
                    $q->where('id', $request->id);
                }
            })->orderBy('id', 'DESC')->get();
        }
        if ($request->type == "CATEGORY") {
            return Category::where(function ($q) use ($request) {
                if ($request->id != null) {
                    $q->where('id', $request->id);
                }
            })->orderBy('id', 'DESC')->get();
        }
    }

    private function validateMenuLink(Request $request)
    {
        $rules = RuleFactory::make([
            'menu_id' => "required|exists:menus,id",
            '%title%' => 'required',
            'type' => "required|in:CUSTOM_LINK,PAGE,CATEGORY",
            'type_id' => "nullable|integer",
            'url' => "required_if:type,CUSTOM_LINK",
            'icon' => "nullable",
        ]);

        $request->validate($rules);
    }

    private function saveMenuLink(Request $request, MenuLink $menuLink)
    {
        $menuLink->menu_id = $request->menu_id;
        $menuLink->type = $request->type;
        $menuLink->type_id = $request->type_id;
        $menuLink->icon = $request->icon;
        $menuLink->url = $request->url;

        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($request->{$key}['title']) {
                $menuLink->translateOrNew($key)->title = $request->{$key}['title'];
            }
        }

        $menuLink->save();

        $link = MenuLink::find($menuLink->id);
        $link->update([
            'url' => MainHelper::menuLinkGenerator($link)
        ]);
    }
}
