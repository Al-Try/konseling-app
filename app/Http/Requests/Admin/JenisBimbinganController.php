<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJenisBimbinganRequest;
use App\Http\Requests\Admin\UpdateJenisBimbinganRequest;
use App\Models\JenisBimbingan;
use Illuminate\Http\Request;

class JenisBimbinganController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $data = JenisBimbingan::when($q, fn($w)=>$w->where('nama_jenis','like',"%$q%"))
            ->orderBy('nama_jenis')->paginate(15);

        // backend only → bisa return JSON
        return response()->json($data);
    }

    public function store(StoreJenisBimbinganRequest $request)
    {
        $jenis = JenisBimbingan::create($request->validated());
        return response()->json(['message'=>'created','data'=>$jenis], 201);
    }

    public function update(UpdateJenisBimbinganRequest $request, JenisBimbingan $jenis)
    {
        $jenis->update($request->validated());
        return response()->json(['message'=>'updated','data'=>$jenis]);
    }

    public function destroy(JenisBimbingan $jenis)
    {
        $jenis->delete();
        return response()->json(['message'=>'deleted']);
    }
}
