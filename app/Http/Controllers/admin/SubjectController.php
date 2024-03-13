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
    User,
    SubjectDetails,
    GradeLevels
};
use \App\Http\Helper\Web;

class SubjectController extends Controller {

    /** + 
     * used to get list of subjects
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        try {
            $pageHeading = "Subject";
            $result = SubjectDetails::with('gradeLevel')->join('crc_subject_details AS s2', 'crc_subject_details.parent_id', '=', 's2.id', 'left outer')
                            ->where('crc_subject_details.is_deleted', 0)
                            ->select('crc_subject_details.grade_id', 'crc_subject_details.parent_id', 'crc_subject_details.name', 'crc_subject_details.id', 'crc_subject_details.status', 's2.name as parent_name')->get();
            return view('admin.pages.subject.list', compact('result', 'pageHeading'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * 
     * used to activate/deactivate subject
     * @param type $subject_id - id of subject
     * @param type $status - status of subject(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivateSubject($subject_id, $status) {
        try {
            $result = SubjectDetails::where('id', $subject_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "Subject not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($result->status == $status) {
                return redirect()->back()->with('error', "Subject already $msgTxt");
            }
            SubjectDetails::where('id', $subject_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "Subject $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** +
     * used to add new subject
     * @param Request $request - request type get/post
     * @return type
     */
    public function addSubject(Request $request) {
        try {
            $pageHeading = "Add Subject";
            if ($request->isMethod('post')) {
                $result = SubjectDetails::where('name', $request->name)->where('parent_id', 0)->where('grade_id', $request->grade_id)->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', "Subject already exist")->withInput();
                }
                $subjectAdded = SubjectDetails::create([
                            'name' => trim($request->name)
                ]);
                if ($subjectAdded->id > 0) {
                    return Redirect::to(URL('admin/subject/list'))->with('success', 'Subject Added Successfully');
                } else {
                    return redirect()->back()->with('error', "Something went wrong")->withInput();
                }
            } else {
                return view('admin.pages.subject.add_subject', compact('pageHeading'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** +
     * used to add new sub subject
     * @param Request $request - request type get/post
     * @return type
     */
    public function addChildSubject(Request $request) {
        try {
            $pageHeading = "Add Subject";
            if ($request->isMethod('post')) {
                $parent_id = (int) $request->parent_id;
                $result = SubjectDetails::where('name', $request->name)->where('parent_id', $parent_id)->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', "Subject already exist")->withInput();
                }
                $subjectAdded = SubjectDetails::create([
                            'parent_id' => $parent_id,
                            'name' => trim($request->name)
                ]);
                if ($subjectAdded->id > 0) {
                    return Redirect::to(URL('admin/subject/list'))->with('success', 'Subject Added Successfully');
                } else {
                    return redirect()->back()->with('error', "Something went wrong")->withInput();
                }
            } else {
                $spacing = '';
                $subjectArr = array();
                $categories = SubjectDetails::where('parent_id', '=', 0)->where('is_deleted', 0)->where('status', 1)->orderBy('parent_id')->get();
                foreach ($categories as $item) {
                    $subjectArr[] = ['id' => $item->id, 'name' => $spacing . $item->name, 'parent_id' => $item->parent_id];
                    $subjectArr = Web::getSubjectTreeArray($item->id, $spacing . '--', $subjectArr);
                }
                return view('admin.pages.subject.add_sub_subject', compact('pageHeading', 'subjectArr'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * used to update subject name
     * @param Request $request - request type get/post
     * @param type $subject_id - id of subject
     * @return type
     */
    public function updateSubject(Request $request, $subject_id) {
        try {
            $pageHeading = "Update Subject";
            $result = SubjectDetails::find($subject_id);
            if ($result == null) {
                return Redirect::to(URL('admin/subject/list'))->with('error', 'Subject not valid');
            }
            if ($request->isMethod('post')) {
                $updateArr = [
                    'name' => trim($request->name),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                if ($result->parent_id == 0) {
                    $result = SubjectDetails::where('name', $request->name)->where('parent_id', $result->parent_id)
                                    ->where('grade_id', $request->grade_id)->where('id', '!=', $subject_id)->get();
                    $updateArr['grade_id'] = $request->grade_id;
                } else {
                    $result = SubjectDetails::where('name', $request->name)->where('parent_id', $result->parent_id)->where('id', '!=', $subject_id)->get();
                }
                if (count($result) > 0) {
                    return redirect()->back()->with('error', "Subject already exist")->withInput();
                }
                SubjectDetails::where('id', $subject_id)->update($updateArr);
                return Redirect::to(URL('admin/subject/list'))->with('success', 'Subject Updated Successfully');
            } else {
                $subjectArr = array();
                if ($result->parent_id != 0) {
                    $spacing = '';
                    $categories = SubjectDetails::where('parent_id', '=', 0)->where('is_deleted', 0)->where('status', 1)->orderBy('parent_id')->get();
                    foreach ($categories as $item) {
                        $subjectArr[] = ['id' => $item->id, 'name' => $spacing . $item->name];
                        $subjectArr = Web::getSubjectTreeArray($item->id, $spacing . '--', $subjectArr);
                    }
                }
                return view('admin.pages.subject.update_subject', compact('pageHeading', 'subjectArr', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }   

    public function deleteSubject(Request $request, $subject_id){
         try {
            $subjectData = SubjectDetails::where('id', $subject_id)->first();
            if ($subjectData == null) {
                return Redirect::to(URL('admin/subject/list'));
            }
            SubjectDetails::where('id', $subject_id)->update([
                'is_deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return Redirect::to(URL('admin/subject/list'))->with('success', 'Subject Deleted Successfully');
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }
}