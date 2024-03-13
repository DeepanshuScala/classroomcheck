<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Session,
    Redirect,
    Validator
};
use \App\Models\{
    Faq,
    Featuretable
};

class FaqController extends Controller {

    /**
     * used to get list of FAQ
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        try {
            $pageHeading = "FAQ";
            $result = Faq::where('is_deleted', 0)->orderBy('id', 'DESC')->get();
            return view('admin.pages.faq.list', compact('result', 'pageHeading'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to activate/deactivate FAQ
     * @param type $faq_id - id of FAQ
     * @param type $status - status of FAQ(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivateFaq($faq_id, $status) {
        try {
            $result = Faq::where('id', $faq_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "FAQ not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($result->status == $status) {
                return redirect()->back()->with('error', "FAQ already $msgTxt");
            }
            Faq::where('id', $faq_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "FAQ $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to delete FAQ
     * @param type $faq_id - id of FAQ
     * @return type
     */
    public function deleteFaq($faq_id) {
        try {
            $result = Faq::where('id', $faq_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "FAQ not valid");
            }
            Faq::where('id', $faq_id)->update([
                'is_deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            if($result->tableid != 0){
                Featuretable::where('id',$result->tableid)->delete();
            }
            return redirect()->back()->with('success', "FAQ deleted successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to add new FAQ
     * @param Request $request - request type get/post
     * @return type
     */
    public function addFaq(Request $request) {
        try {
            $pageHeading = "Add FAQ";
            if ($request->isMethod('post')) {
                $result = Faq::where('question', trim($request->question))->where('is_deleted', 0)->get();
                if (count($result) > 0) {
                    return response()->json(['redirectTo' => '', 'msg' => "Question already exists"]);
                } else {
                    $table = 0;
                    $tableid = 0;
                    if(isset($request->add_table)){
                        $featureid = Featuretable::create($request->table);
                        $tableid = $featureid->id;
                        $table = 1;
                    }
                    $isAdded = Faq::create([
                                'question' => trim($request->question),
                                'answer' => trim($request->body),
                                'has_table' => $table,
                                'tableid' => $tableid,
                    ]);

                    if ($isAdded->id > 0) {
                        Session::flash('success', 'FAQ added Successfully');
                        return response()->json(['redirectTo' => url('admin/faq/list')]);
                    } else {
                        return response()->json(['redirectTo' => '', 'msg' => "Something went wrong"]);
                    }
                }
            } else {
                return view('admin.pages.faq.add', compact('pageHeading'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to update FAQ
     * @param Request $request - request type get/post
     * @param type $faq_id - id of FAQ
     * @return type
     */
    public function updateFaq(Request $request, $faq_id) {
        try {
            $pageHeading = "Update FAQ";
            $result = Faq::find($faq_id);
            if ($result == null) {
                return Redirect::to(URL('admin/faq/list'))->with('error', 'FAQ not valid');
            }
            if ($request->isMethod('post')) {
                $result = Faq::where('question', trim($request->question))->where('is_deleted', 0)->where('id', '!=', $faq_id)->get();
                if (count($result) > 0) {
                    return response()->json(['redirectTo' => '', 'msg' => "Question already exists"]);
                } else {
                    $result = Faq::find($faq_id);
                    $table = $result->has_table;
                    $tableid = $result->tableid;
                    if(isset($request->add_table) && !$tableid){
                        $featureid = Featuretable::create($request->table);
                        $tableid = $featureid->id;
                        $table = 1;
                    }
                    elseif(isset($request->add_table) && $tableid){
                       
                        Featuretable::where('id',$tableid)->update($request->table);
                    }
                    elseif(!isset($request->add_table) && $tableid){
                        Featuretable::where('id',$tableid)->delete();
                        $tableid = 0;
                        $table = 0;
                    }
                    Faq::where('id', $faq_id)->update([
                        'question' => trim($request->question),
                        'answer' => trim($request->body),
                        'has_table' => $table,
                        'tableid' => $tableid,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    Session::flash('success', 'FAQ updated Successfully');
                    return response()->json(['redirectTo' => url('admin/faq/list')]);
                }
            } else {
                return view('admin.pages.faq.update', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

}
