<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    //create store izin request
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'reason' => 'required',
        ]);

        $izin = new Izin();
        $izin->user_id = auth()->user()->id;
        $izin->date_izin = $request->date;
        $izin->reason = $request->reason;
        $izin->image = $request->image;
        $izin->is_approved = 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/izin', $image->hashName());
            $izin->image = $image->hashName();
        }

        $izin->save();

        return response()->json(
            [
                'message' => 'Izin berhasil',
            ],
            201,
        );
    }
    public function index()
    {
        $user = auth()->user();

        $izins = Izin::where('user_id', $user->id)->get();

        return response()->json($izins, 200);
    }
}
