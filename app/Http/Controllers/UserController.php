<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getEdit (Request $request) {
        $id = $request->query('id');
        if (!$id) { 
            return response()->json(['success' => false, 'message' => "ID-$id is not found"], 400);
        };
        
        // $userEdit = User::where('id', $id)->first();
        
        // if ($userEdit) {
        //     return response()->json(['success' => false, 'message' => 'Cannot found data with id'], 400);
        // }
        
        $userEdit= [];
        $html = view('components.apis.user-modal-update', compact('userEdit'))->render();
        
        return response()->json(['success' => true, 'html' => $html], 200);
    }
    public function getDelete (Request $request) {
        $id = $request->query('id');
        if (!$id) { 
            return response()->json(['success' => false, 'message' => "ID-$id is not found"], 400);
        };
        
        // $userEdit = User::where('id', $id)->first();
        
        // if ($userEdit) {
        //     return response()->json(['success' => false, 'message' => 'Cannot found data with id'], 400);
        // }
        
        $userDelete= [];
        $html = view('components.apis.user-modal-delete', compact('userDelete'))->render();
        
        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
