<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Auth,
    Validator,
    Session,
    Redirect
};
use \App\Models\{Contribution,contributionstransactions};
use Carbon\Carbon;

class ClassRoomContributionController extends Controller {

    /** + 
     * used to get all contributions
     * @param Request $request
     * @return type
     */
    public function index(Request $request) {
        $data = [];
        $data['title'] = 'View';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'Classroom Contributions';
        $data['result'] = Contribution::where('user_id', auth()->user()->id)->get();
        //dd($data['result']);

        return view('classroom_contribution.account_dashboard_contributions', compact('data'));
    }


    public function view(Request $request) {
        $data = [];
        $data['title'] = 'View';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'Classroom Contributions';
        $data['breadcrumb2_link'] = route('accountDashboard.contributions');
        $data['breadcrumb3'] = 'View Listing';
        $data['result'] = Contribution::where('user_id', auth()->user()->id)->get();
        //dd($data['result']);

        return view('classroom_contribution.account_dashboard_contributions_view', compact('data'));
    }

    public function viewwedit(Request $request) {
        $data = [];
        $data['title'] = 'View';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'Classroom Contributions';
        $data['breadcrumb2_link'] = route('accountDashboard.contributions');
        $data['breadcrumb3'] = 'Edit Listing';
        $data['result'] = Contribution::where('user_id', auth()->user()->id)->get();
        //dd($data['result']);

        return view('classroom_contribution.account_dashboard_contributions_edit_view', compact('data'));
    }

    /** + 
     * used to add classroom contribution
     * @param Request $request - request type get/post
     * @return type
     */
    public function accountDashClassroomContributions(Request $request) {
        $data = [];
        $data['title'] = 'Set Up';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'Classroom Contributions';
        $data['breadcrumb2_link'] = route('accountDashboard.contributions');
        $data['breadcrumb3'] = 'Set Up';
        if ($request->isMethod('post')) {
            try {
                $responseArray = ['success' => false, 'message' => ''];
                $validation = Validator::make($request->all(), Contribution::$classroomContributionValidation, Contribution::$classroomContributionCustomMessage);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                    return $responseArray;
                }
                $fundraising_banner = '';
                if ($request->hasfile('fundraising_banner')) {
                    $file = $request->file('fundraising_banner');
                    $path = 'public/uploads/contributions';
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $fundraising_banner = $name;
                    $file->storeAs($path, $name);
                }
                $contributions = Contribution::create([
                            "user_id" => auth()->user()->id,
                            'user_name' => $request->user_name,
                            "first_name" => $request->first_name,
                            "surname" => $request->surname,
                            "fundraising_title" => $request->fundraising_title,
                            "fundraising_slogan" => $request->fundraising_slogan,
                            "about_fundraiser" => $request->about_fundraiser,
                            "target_amount" => $request->target_amount,
                            'fundraising_banner' => $fundraising_banner,
                            "exp_date" => Carbon::now()->addDays(30)->format('Y-m-d')
                ]);
                if ($contributions->id > 0) {
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Contribution Created Successfully';
                } else {
                    $responseArray['success'] = false;
                    $responseArray['message'] = 'Something went wrong';
                }
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                $responseArray['message'] = $message;
            }
            return response()->json($responseArray, 200);
        } else {
            return view('classroom_contribution.account_dashboard_contributions_setup', compact('data'));
        }
    }

    /** + 
     * used to edit classroom contribution
     * @param Request $request - request type get/post
     * @param type $contribution_id - id of contribution
     * @return type
     */
    public function accountDashContributionsEdit(Request $request, $contribution_id) {
        $data = [];
        $data['title'] = 'Edit';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'Classroom Contributions';
        $data['breadcrumb2_link'] = route('accountDashboard.contributions');
        $data['breadcrumb3'] = 'Edit Listing';
        $result = Contribution::find($contribution_id);
        $data['result'] = $result;
        if ($request->isMethod('post')) {
            try {
                $responseArray = ['success' => false, 'message' => ''];
                $fundraising_banner = $result->fundraising_banner;
                $validation = Validator::make($request->all(), Contribution::$classroomContributionValidation, Contribution::$classroomContributionCustomMessage);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                    return $responseArray;
                }
                if ($request->hasfile('fundraising_banner')) {
                    if ($result->fundraising_banner != '')
                        unlink(storage_path('app/public/uploads/contributions/' . $result->fundraising_banner));
                    $file = $request->file('fundraising_banner');
                    $path = 'public/uploads/contributions';
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $fundraising_banner = $name;
                    $file->storeAs($path, $name);
                }
                $contributions = Contribution::where('id', $request->contribution_id)->update([
                    "first_name" => $request->first_name,
                    "surname" => $request->surname,
                    "fundraising_title" => $request->fundraising_title,
                    "fundraising_slogan" => $request->fundraising_slogan,
                    "about_fundraiser" => $request->about_fundraiser,
                    "target_amount" => $request->target_amount,
                    'fundraising_banner' => $fundraising_banner,
                        //"exp_date" => Carbon::now()->addDays(30)->format('Y-m-d')
                ]);
                if ($contributions) {
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Contribution Updated Successfully';
                } else {
                    $responseArray['success'] = false;
                    $responseArray['message'] = 'Something went wrong';
                }
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                $responseArray['message'] = $message;
            }
            return response()->json($responseArray, 200);
        } else {
            return view('classroom_contribution.account_dashboard_contributions_edit', compact('data'));
        }
    }

    /** + 
     * used to get classroom contribution detail
     * @param Request $request - request type get/post
     * @param type $contribution_id - id of contribution
     * @return type
     */
    public function accountDashContributionsViewDetails(Request $request, $contribution_id) {
        $data = [];
        $data['title'] = 'View';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'Classroom Contributions';
        $data['breadcrumb2_link'] = route('accountDashboard.contributions');
        $data['breadcrumb3'] = 'View Listing';
        $result = Contribution::find($contribution_id);
        $data['result'] = $result;
        return view('classroom_contribution.account_dashboard_contributions_detail', compact('data'));
    }

    /** + 
     * used to show details of contribution
     * @param Request $request - request type get
     * @param type $contribution_id - id of contribution
     * @return type
     */
    public function contributionViewDetails(Request $request, $contribution_id) {
        $data = [];
        $data['title'] = 'Contribution';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Classromm Contribution';
        $data['result'] = Contribution::find($contribution_id);
        return view('classroom_contribution.single_contribution', compact('data'));
    }

    /** + 
     * used to show details of contribution
     * @param Request $request - request type get
     * @param type $contribution_id - id of contribution
     * @return type
     */
    public function contributionPay(Request $request) {
        $responseArray = ['success' => false,'message'=> ''];
        try {
            $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET_KEY'),
            ]);

            $token = $stripe->tokens->create([
                      'card' => [
                        'number' => $request->get('card_number'),
                        'exp_month' => $request->get('card_expiry_month'),
                        'exp_year' => $request->get('card_expiry_year'),
                        'cvc' => $request->get('cvv'),
                      ],
                    ]);

            $price = number_format((float) $request->amount, 2, '.', '');
            
            $charge = $stripe->charges->create([
                    'amount' => $price*100,
                    'currency' => env('CURRENCY'),
                    'source' => $token->id,
            ]);
            if (!($charge->id)){
                $responseArray['message'] = 'There is an issue with payment. Please try after sometime';
                return $responseArray;
            }
            else{
                //Capture transaction in db
                $txnData = [
                    'contribution_id' => $request->contribution_id,
                    'txn_ref' => $charge->id,
                    'txn_raw' => json_encode($charge),
                    'amount' => $price,
                    'status' => $charge->status == 'succeeded' ? 'success' : 'failed',
                ];
                $trnxCreate = contributionstransactions::create($txnData);
                
                //update amount in transaction
                $ctri = Contribution::where('id',$request->contribution_id)->first();
                if(!empty($ctri)){
                    $update = Contribution::where('id',$request->contribution_id)->update(['funded_amount' => ($ctri->funded_amount+$price) ]);
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Payment Successfull';
                    $responseArray['charge'] = $charge;
                    return response()->json($responseArray, 200);
                }
                else{
                    $responseArray['message'] = 'Please refresh the page';
                    return $responseArray; 
                }
            }
            
        }catch (\Stripe\Exception\CardException $e) {
            $responseArray['message'] = $e->getMessage();
            return $responseArray;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $responseArray['message'] = $e->getMessage();
            return $responseArray;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $responseArray['message'] = $e->getMessage();
            return $responseArray;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $responseArray['message'] = $e->getMessage();
            return $responseArray;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $responseArray['message'] = $e->getMessage();
            return $responseArray;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $responseArray['message'] = $e->getMessage();
            return $responseArray;
        } catch (\Exception $e) {
            $responseArray['message'] = $e->getMessage();
            return $responseArray;
        }
    }
}   