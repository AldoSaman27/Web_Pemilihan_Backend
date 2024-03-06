<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use App\Models\Kandidat;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Validator;

class VotingController extends Controller
{
    public function __construct() {
        $this->middleware("auth:sanctum", ["except" => ["store"]]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voting = Voting::all();
        if ($voting) return response()->json([
            "message" => "Voting index success",
            "voting" => $voting,
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
            "voting_code" => "required|string",
            "kandidats_id" => "required",
        ]);

        if ($validator->fails()) return response()->json([
            "message" => "Invalid field",
            "errors" => $validator->errors(),
        ], 422);

        $pemilih = Pemilih::where("uniqcode", $request->voting_code)->first();
        if (!$pemilih) return response()->json(["message" => "Invalid voting code!"]);

        if ($pemilih && $pemilih->is_voting === 1) return response()->json(["message" => "Anda sudah memilih sebelumnya!"]);

        $kandidat = Kandidat::where("id", $request->kandidats_id)->first();
        if (!$kandidat) return response()->json(["message" => "Invalid kandidat id!"]);

        $voting = Voting::create([
            "kandidats_id" => $request->kandidats_id,
        ]);

        $pemilih = $pemilih->update([
            "is_voting" => 1,
        ]);

        if ($voting && $pemilih) return response()->json([
            "message" => "Voting store success",
            "voting" => $voting,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Voting $voting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voting $voting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voting $voting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voting $voting)
    {
        //
    }
}
