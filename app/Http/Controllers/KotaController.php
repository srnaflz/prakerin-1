<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Provinsi;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kota = Kota::with('provinsi')->get();
        return view('kota.index',compact('kota'));
    }

    public function create()
    {
        $provinsi = Provinsi::all();
        return view('kota.create',compact('provinsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kota' => 'required|numeric|max:4|unique:kotas',
            'nama_kota' => 'required|alpha|unique:kotas',
        ], [
            'kode_kota.required' => 'Kode Harus Di Isi!',
            'kode_kota.numeric' => 'Harus Input Menggunakan Angka!',
            'kode_kota.max' => 'Kode Maximal 4',
            'kode_kota.unique' => 'Kode Sudah Terpakai!',
            'nama_kota.required' => 'Nama Kota Harus Di Isi!',
            'nama_kota.alpha' => 'Harus Input Menggunakan Huruf!',
            'nama_kota.unique' => 'Nama Kota Sudah Terpakai!'
        ]);
        $kota = new Kota();
        $kota->kode_kota = $request->kode_kota;
        $kota->nama_kota = $request->nama_kota;
        $kota->id_provinsi = $request->id_provinsi;
        $kota->save();
        return redirect()->route('kota.index')->with('toast_success', 'Kabupaten/Kota berhasil dibuat!');
    }

    public function show($id)
    {
        $kota = Kota::findOrFail($id);
        return view('kota.show',compact('kota'));
    }

    public function edit($id)
    {
        $kota = Kota::findOrFail($id);
        $provinsi = Provinsi::all();
        return view('kota.edit',compact('kota','provinsi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kota' => 'required|numeric|max:4|unique:kotas',
            'nama_kota' => 'required|alpha|unique:kotas',
        ], [
            'kode_kota.required' => 'Kode Harus Di Isi!',
            'kode_kota.numeric' => 'Harus Input Menggunakan Angka!',
            'kode_kota.max' => 'Kode Maximal 4',
            'kode_kota.unique' => 'Kode Sudah Terpakai!',
            'nama_kota.required' => 'Nama Kota Harus Di Isi!',
            'nama_kota.alpha' => 'Harus Input Menggunakan Huruf!',
            'nama_kota.unique' => 'Nama Kota Sudah Terpakai!'
        ]);
        $kota = Kota::findOrFail($id);
        $kota->kode_kota = $request->kode_kota;
        $kota->nama_kota = $request->nama_kota;
        $kota->id_provinsi = $request->id_provinsi;
        $kota->save();
        return redirect()->route('kota.index')->with('toast_success', 'Kabupaten/Kota berhasil diedit!');
    }

    public function destroy($id)
    {
        $kota = Kota::findOrFail($id)->delete();
        return redirect()->route('kota.index')->with('success', 'Kabupaten/Kota berhasil dihapus!');
    }
}
