<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $categories = MenuCategory::where('is_visible', true)
            ->orderBy('position')
            ->with(['dishes' => function ($query) {
                $query->where('is_visible', true)->orderBy('position');
            }])
            ->get();

        return view('menu.index', compact('categories'));
    }
}
