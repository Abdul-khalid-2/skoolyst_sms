<?php

namespace App\Http\Controllers;

use App\Models\SidebarSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SidebarSettingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            SidebarSetting::query()->orderBy('sort_order')->get()
        );
    }

    public function update(Request $request, SidebarSetting $sidebarSetting): JsonResponse
    {
        $data = $request->validate([
            'label' => ['sometimes', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'route' => ['nullable', 'string', 'max:255'],
            'roles_visible' => ['nullable', 'array'],
            'roles_visible.*' => ['string'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ]);

        $sidebarSetting->update($data);

        return response()->json($sidebarSetting->fresh());
    }
}
