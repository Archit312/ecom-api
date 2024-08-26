<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Fetch all admin records
    public function index()
    {
        $admins = Admin::all();
        return response()->json($admins, 200);
    }

    // Fetch a specific admin by ID
    public function show($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        return response()->json($admin, 200);
    }

    // Store a new admin
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_email' => 'required|email|unique:admin,admin_email',
            'admin_password' => 'required|min:6',
            'additional_email' => 'nullable|email',
            'terms_and_conditions' => 'nullable|string',
            'about_us' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin = new Admin([
            'admin_email' => $request->input('admin_email'),
            'admin_password' => Hash::make($request->input('admin_password')),
            'additional_email' => $request->input('additional_email'),
            'terms_and_conditions' => $request->input('terms_and_conditions'),
            'about_us' => $request->input('about_us'),
        ]);

        $admin->save();

        return response()->json(['message' => 'Admin created successfully!', 'data' => $admin], 201);
    }

    // Update an existing admin by ID
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'admin_email' => 'sometimes|required|email|unique:admin,admin_email,' . $id,
            'admin_password' => 'sometimes|required|min:6',
            'additional_email' => 'nullable|email',
            'terms_and_conditions' => 'nullable|string',
            'about_us' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin->admin_email = $request->input('admin_email', $admin->admin_email);
        $admin->additional_email = $request->input('additional_email', $admin->additional_email);
        $admin->terms_and_conditions = $request->input('terms_and_conditions', $admin->terms_and_conditions);
        $admin->about_us = $request->input('about_us', $admin->about_us);

        if ($request->has('admin_password')) {
            $admin->admin_password = Hash::make($request->input('admin_password'));
        }

        $admin->save();

        return response()->json(['message' => 'Admin updated successfully!', 'data' => $admin], 200);
    }

    // Delete an admin by ID
    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully!'], 200);
    }
}
