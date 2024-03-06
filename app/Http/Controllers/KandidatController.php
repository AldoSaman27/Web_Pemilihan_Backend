<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;
use Validator;

class KandidatController extends Controller
{
    public function __construct() {
        $this->middleware("auth:sanctum", ["except" => ["index"]]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kandidat = Kandidat::all();
        if ($kandidat) return response()->json([
            "message" => "Kandidat index success",
            "kandidat" => $kandidat,
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
            "ketua" => "required|string|unique:kandidats",
            "wakil" => "required|string|unique:kandidats",
            "motto" => "required|string",
            "visi_misi" => "required|string",
            "gambar" => "required|image|max:20000",
            "video" => "required|mimes:mp4,mov|max:20000",
        ]);

        if ($validator->fails()) return response()->json([
            "message" => "Invalid field",
            "errors" => $validator->errors(),
        ], 422);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            @$fileNameGambar = date('Ymd') . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('uploads/gambar'), $fileNameGambar);
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            @$fileNameVideo = date('Ymd') . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('uploads/video'), $fileNameVideo);
        }

        $kandidat = Kandidat::create([
            "ketua" => $request->ketua,
            "wakil" => $request->wakil,
            "motto" => $request->motto,
            "visi_misi" => $request->visi_misi,
            "gambar" => $fileNameGambar,
            "video" => $fileNameVideo,
        ]);

        if ($kandidat) return response()->json([
            "message" => "Kandidat store success",
            "kandidat" => $kandidat,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kandidat $kandidat, $id)
    {
        $kandidat = Kandidat::where("id", $id)->first();
        if ($kandidat) return response()->json([
            "message" => "Kandidat show success",
            "kandidat" => $kandidat,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kandidat $kandidat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kandidat $kandidat, $id)
    {
        $validator = Validator::make($request->all(), [
            "ketua" => "nullable|string|unique:kandidats",
            "wakil" => "nullable|string|unique:kandidats",
            "motto" => "nullable|string",
            "visi_misi" => "nullable|string",
            "gambar" => "nullable|image|max:20000",
            "video" => "nullable|mimes:mp4,mov|max:20000",
        ]);

        if ($validator->fails()) return response()->json([
            "message" => "Invalid field",
            "errors" => $validator->errors(),
        ], 422);

        $kandidat = Kandidat::where("id", $id)->first();
        if (!$kandidat) return response()->json(["message" => "Invalid kandidat id!"]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $fileNameGambar = date('Ymd') . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('uploads/gambar'), $fileNameGambar);
            $kandidat = $kandidat->update(["gambar" => $fileNameGambar]);
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            $fileNameVideo = date('Ymd') . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('uploads/video'), $fileNameVideo);
            $kandidat = $kandidat->update(["video" => $fileNameVideo]);
        }

        if ($request->ketua) $kandidat = $kandidat->update(["ketua" => $request->ketua]);
        if ($request->wakil) $kandidat = $kandidat->update(["wakil" => $request->wakil]);
        if ($request->motto) $kandidat = $kandidat->update(["motto" => $request->motto]);
        if ($request->visi_misi) $kandidat = $kandidat->update(["visi_misi" => $request->visi_misi]);

        if ($kandidat) return response()->json([
            "message" => "Kandidat update success",
            "kandidat" => Kandidat::where("id", $id)->first(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kandidat $kandidat, $id)
    {
        $kandidat = Kandidat::where("id", $id)->delete();
        if ($kandidat) return response()->json(["message" => "Kandidat destroy success"]);
    }
}
