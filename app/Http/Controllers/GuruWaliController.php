<?php

namespace App\Http\Controllers;

use App\Models\GuruWali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruWaliController extends Controller
{
    public function index()
    {
        return GuruWali::all();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        return GuruWali::create($data);
    }

    public function show($id)
    {
        return GuruWali::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $gw = GuruWali::findOrFail($id);
        $data = $request->all();
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $gw->update($data);
        return $gw;
    }

    public function destroy($id)
    {
        return GuruWali::destroy($id);
    }
}