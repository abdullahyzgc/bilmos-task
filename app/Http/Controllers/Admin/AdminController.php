<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function apiDocs()
    {
        return view('admin.api-docs');
    }
}
