<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()->get();
        return view('pages.notices.index', compact('notices'));
    }

    public function show(Notice $notice)
    {
        return view('pages.notices.show', compact('notice'));
    }
} 