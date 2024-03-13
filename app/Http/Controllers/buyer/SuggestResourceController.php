<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    SuggestResource
};
use Illuminate\Support\Facades\{
    Auth,
    Crypt,
    Validator
};
use Carbon\Carbon;
use Exception;

class SuggestResourceController extends Controller {

    /** + 
     * used to add suggest resource
     * @param Request $request - request type get/post
     * @return type
     */
    public function index(Request $request) {
        if ($request->isMethod('post')) {
            $responseArray = ['success' => false, 'message' => '', 'balance' => ''];
            $suggestResource = SuggestResource::create([
                        'user_id' => auth()->user()->id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'grade_id' => $request->grade_id,
                        'subject_id' => $request->subject_id,
                        'resource_id' => $request->resource_id,
                        'description' => $request->description,
                        'other_description' => $request->other_description,
            ]);
            if ($suggestResource->id > 0) {
                $responseArray['success'] = true;
            } else {
                $responseArray['success'] = false;
                $responseArray['message'] = "Something went wrong. Please try again later";
            }
            return response()->json($responseArray, 200);
        } else {
            $data = [];
            $data['title'] = 'Suggest a Resource';
            $data['home'] = 'Home';
            $data['breadcrumb1'] = 'Account Dashboard';
            $data['breadcrumb1_link'] = route('account.dashboard');
            $data['breadcrumb2'] = 'Suggest a Resource';
            $data['breadcrumb3'] = false;

            return view('account.account_dashboard_suggest_a_resource', compact('data'));
        }
    }

}
