<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of all companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager load the user relationship to avoid N+1 query problem
        $companies = Company::with('user')->get();
        return response()->json($companies);
    }

    /**
     * Display the specified company.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::with('user')->find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        return response()->json($company);
    }

    /**
     * Update the specified company in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'denomination' => 'sometimes|required|string|max:255',
            'contact' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $company->user_id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the company's information
        $company->update($request->only(['firstname', 'lastname', 'denomination', 'contact', 'type']));

        // Update the associated user's email if provided
        if ($request->has('email')) {
            $user = User::find($company->user_id);
            $user->email = $request->email;
            $user->save();
        }

        return response()->json(['message' => 'Company updated successfully', 'company' => $company]);
    }

    /**
     * Remove the specified company from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        // Delete the associated user
        $user = User::find($company->user_id);
        if ($user) {
            $user->delete();
        }

        // Delete the company
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
