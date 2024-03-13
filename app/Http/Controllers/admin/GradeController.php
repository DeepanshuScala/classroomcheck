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
    Grade,
    Featuretable,
    GradeLevels
};

class GradeController extends Controller {
    
    public function index(Request $request){
        try {
            $pageHeading = "Grade";
            $result = GradeLevels::get();
            return view('admin.pages.grade.list', compact('result', 'pageHeading'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to activate/deactivate Grade
     * @param type $grade_id - id of Grade
     * @param type $status - status of Grade(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivateGrade($grade_id, $status) {
        try {
            $result = GradeLevels::where('id', $grade_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "Grade not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($result->status == $status) {
                return redirect()->back()->with('error', "Grade already $msgTxt");
            }
            GradeLevels::where('id', $grade_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "Grade $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to delete Grade
     * @param type $grade_id - id of Grade
     * @return type
     */
    public function deleteGrade($grade_id) {
        try {
            $result = GradeLevels::where('id', $grade_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "Grade not valid");
            }
            GradeLevels::where('id', $grade_id)->delete();
            if($result->tableid != 0){
                GradeLevels::where('id',$result->tableid)->delete();
            }
            return redirect()->back()->with('success', "Grade deleted successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to add new Grade
     * @param Request $request - request type get/post
     * @return type
     */
    public function addGrade(Request $request) {
        try {
            $pageHeading = "Grade";
            if ($request->isMethod('post')) {
                $result = GradeLevels::where('grade', trim($request->name))->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', 'Grade already exists')->withInput();
                } else {
                    $table = 0;
                    $tableid = 0;
                    $isAdded = GradeLevels::create([
                                'grade' => trim($request->name),
                    ]);

                    if ($isAdded->id > 0) {
                        Session::flash('success', 'Grade added Successfully');
                        return Redirect::to(URL('admin/grade/list'))->with('success', 'Grade Added Successfully');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong')->withInput();
                    }
                }
            } else {
                return view('admin.pages.grade.add', compact('pageHeading'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to update Grade
     * @param Request $request - request type get/post
     * @param type $grade_id - id of Grade
     * @return type
     */
    public function updateGrade(Request $request, $grade_id) {
        try {
            $pageHeading = "update Grade";
            $result = GradeLevels::find($grade_id);
            if ($result == null) {
                return Redirect::to(URL('admin/grade/list'))->with('error', 'Grade not valid');
            }
            if ($request->isMethod('post')) {
                $result = GradeLevels::where('grade', trim($request->name))->where('id', '!=', $grade_id)->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', 'Grade already exists')->withInput();
                } else {
                    $result = GradeLevels::find($grade_id);
                    
                    GradeLevels::where('id', $grade_id)->update([
                        'grade' => trim($request->name),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    return Redirect::to(URL('admin/grade/list'))->with('success', 'Grade Updated Successfully');
                }
            } else {
                return view('admin.pages.grade.update', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }
}