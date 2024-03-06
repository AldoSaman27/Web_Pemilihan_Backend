<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use Illuminate\Http\Request;
use Validator;

class PemilihController extends Controller
{
    public function __construct() {
        $this->middleware("auth:sanctum", ["expcet"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemilih = Pemilih::all();
        if ($pemilih) return response()->json([
            "message" => "Pemilih index success",
            "pemilih" => $pemilih,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|string|unique:pemilihs",
        ]);

        if ($validator->fails()) return response()->json([
            "message" => "Invalid field",
            "errors" => $validator->errors(),
        ], 422);

        // Membuat kode acak dengan panjang tertentu
        function generateRandomCode($length) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            do {
                $randomCode = substr(str_shuffle($characters), 0, $length);
            } while (Pemilih::where("uniqcode", $randomCode)->exists());
            return $randomCode;
        }

        $randomCode = generateRandomCode(8);

        $pemilih = Pemilih::create([
            "nama" => $request->nama,
            "uniqcode" => $randomCode,
            "is_voting" => 0,
        ]);

        if ($pemilih) return response()->json([
            "message" => "Pemilih store success",
            "pemilih" => $pemilih,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemilih $pemilih, $id)
    {
        $pemilih = Pemilih::where("id", $id)->first();
        if ($pemilih) return response()->json([
            "message" => "Pemilih show success",
            "pemilih" => $pemilih,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemilih $pemilih)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemilih $pemilih, $id)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|string|unique:pemilihs",
        ]);

        if ($validator->fails()) return response()->json([
            "message" => "Invalid field",
            "errors" => $validator->errors(),
        ], 422);

        $pemilih = Pemilih::where("id", $id)->first();
        $pemilih = $pemilih->update([
            "nama" => $request->nama,
        ]);

        if ($pemilih) return response()->json([
            "message" => "Pemilih update success",
            "pemilih" => Pemilih::where("id", $id)->first(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemilih $pemilih, $id)
    {
        $pemilih = Pemilih::where("id", $id)->delete();
        if ($pemilih) return response()->json(["message" => "Pemilih destroy success"]);
    }
}
