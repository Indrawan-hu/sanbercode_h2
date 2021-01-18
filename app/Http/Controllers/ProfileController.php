<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user) {
            return response()->json([
                'response_code' => '00',
                'response_message' => 'Profile Berhasil ditampilkan',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'response_code' => '01',
            'response_message' => 'Silahkan Melakukan Login'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'string|max:40',
            'photo' => 'mimes:jpeg,png|max:1014',
        ]);

        if ($request->file('photo')) {
            $photo = $request->file('photo')->store('photos/users', 'public');

            $id = auth()->user()->id;
            $user = User::find($id);
            $user->name = $request->name;
            $user->photo = $photo;
            $user->save();

            return response()->json([
                'response_code' => '00',
                'response_message' => 'Profile Berhasil diupdate',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'response_code' => '01',
            'response_message' => 'File Gambar tidak ditemukan',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
