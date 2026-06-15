<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class NoticeController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('my-notices.index');
    }
}
