<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    // index
    public function index()
    {
        $data = [
            'title' => 'Laporan',
        ];
        return view('report.index', $data);
    }
}
