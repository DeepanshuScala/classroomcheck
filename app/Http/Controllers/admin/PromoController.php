<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Validator,
    Session,
    Redirect
};
use \App\Models\{
    PromoDetails,
    User
};
use \App\Http\Helper\Web;

class PromoController extends Controller {

    /** + 
     * used to get list of promo code
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        try {
            $promos = PromoDetails::orderBy('id', 'DESC')->get();
            return view('admin.pages.promos.list', compact('promos'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * 
     * used to activate/deactivate promos
     * @param type $promo_id - id of promo
     * @param type $status - status of promo(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivatePromotion($promo_id, $status) {
        try {
            $promoData = PromoDetails::where('id', $promo_id)->first();
            if ($promoData == null) {
                return redirect()->back()->with('error', "Promotion not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($promoData->status == $status) {
                return redirect()->back()->with('error', "Promotion already $msgTxt");
            }
            PromoDetails::where('id', $promo_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "Promotion $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * used to generate auto promotion code
     */
    public function generatePromotionAutoCode() {
        $random_number = Web::getAlphaNumericNumber();
        echo json_encode(array('random_number' => $random_number));
    }

    /** +
     * used to add new promotion for store and user
     * @param Request $request - request type get/post
     * @return type
     */
    public function addPromotion(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $start_end_date = explode(' - ', $request->start_end_date);
                $start_date = date('Y-m-d', strtotime($start_end_date[0]));
                $end_date = date('Y-m-d', strtotime($start_end_date[1]));
                $insertArr = [
                    // 'type' => (int) $request->type,
                    // 'promo_usage_for' => (int) $request->promo_usage_for,
                    'title' => $request->title,
                    'description' => $request->description,
                    'promo_code' => $request->promo_code,
                    'start_at' => $start_date,
                    'end_at' => $end_date,
                    'discount_in' => (int) $request->discount_in,
                    'amount' => $request->amount,
                ];
                $promoAdded = PromoDetails::create($insertArr);
                if ($promoAdded) {
                    return Redirect::to(URL('admin/promo/list'))->with('success', 'Promotion Added Successfully');
                } else {
                    return redirect()->back()->with('error', 'Something went wrong')->withInput();
                }
            } else {
                return view('admin.pages.promos.add_promo');
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * used to update promotion
     * @param Request $request - request type get/post
     * @param type $promo_id - id of promotion
     * @return type
     */
    public function updatePromotion(Request $request, $promo_id) {
        try {
            $promos = PromoDetails::find($promo_id);
            if ($promos == null) {
                return Redirect::to(URL('admin/promo/list'))->with('error', 'Promotion not valid');
            }
            $startDate = $promos->start_at;
            $endDate = $promos->end_at;
            //$startEndDate = date('Y/m/d', strtotime($startDate)) . " - " . date('Y/m/d', strtotime($endDate));
            $startEndDate = date('m/d/Y', strtotime($startDate)) . " - " . date('m/d/Y', strtotime($endDate));
            if ($request->isMethod('post')) {
                $start_end_date = explode(' - ', $request->edit_start_end_date);
                $start_date = date('Y-m-d', strtotime($start_end_date[0]));
                $end_date = date('Y-m-d', strtotime($start_end_date[1]));
                $updateArr = [
                    // 'type' => (int) $request->type,
                    // 'promo_usage_for' => (int) $request->promo_usage_for,
                    'title' => $request->title,
                    'description' => $request->description,
                    'promo_code' => $request->promo_code,
                    'start_at' => $start_date,
                    'end_at' => $end_date,
                    'discount_in' => (int) $request->discount_in,
                    'amount' => $request->amount,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $promoUpdated = PromoDetails::where('id', $promo_id)->update($updateArr);
                if ($promoUpdated) {
                    return Redirect::to(URL('admin/promo/list'))->with('success', 'Promotion Updated Successfully');
                } else {
                    return redirect()->back()->with('error', 'Something went wrong')->withInput();
                }
            } else {
                return view('admin.pages.promos.edit_promo', compact('promos', 'startEndDate'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

}