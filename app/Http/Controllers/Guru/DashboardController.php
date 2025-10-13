<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guruWali;

        $bimbinganCount = Bimbingan::where('guru_id', $guru->id)->count();

        return view('guru_wali.dashboard', compact('guru', 'bimbinganCount'));
    }
}
