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
    Type,
};

class TypeController extends Controller {
    
    public function index(Request $request){
        try {
            $pageHeading = "File Type";
            $result = Type::get();
            return view('admin.pages.type.list', compact('result', 'pageHeading'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to activate/deactivate File Type
     * @param type $type_id - id of File Type
     * @param type $status - status of File Type(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivateType($type_id, $status) {
        try {
            $result = Type::where('id', $type_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "File Type not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($result->status == $status) {
                return redirect()->back()->with('error', "File Type already $msgTxt");
            }
            Type::where('id', $type_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "File Type $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to delete File Type
     * @param type $type_id - id of File Type
     * @return type
     */
    public function deleteType($type_id) {
        try {
            $result = Type::where('id', $type_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "File Type not valid");
            }
            Type::where('id', $type_id)->delete();
            if($result->tableid != 0){
                Type::where('id',$result->tableid)->delete();
            }
            return redirect()->back()->with('success', "File Type deleted successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to add new File Type
     * @param Request $request - request type get/post
     * @return type
     */
    public function addType(Request $request) {
        try {
            $pageHeading = "File Type";
            if ($request->isMethod('post')) {
                $result = Type::where('name', trim($request->name))->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', 'File Type already exists')->withInput();
                } else {
                    $table = 0;
                    $tableid = 0;
                    $isAdded = Type::create([
                                'name' => trim($request->name),
                    ]);

                    if ($isAdded->id > 0) {
                        Session::flash('success', 'File Type added Successfully');
                        return Redirect::to(URL('admin/type/list'))->with('success', 'File Type Added Successfully');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong')->withInput();
                    }
                }
            } else {
                return view('admin.pages.type.add', compact('pageHeading'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to update File Type
     * @param Request $request - request type get/post
     * @param type $type_id - id of File Type
     * @return type
     */
    public function updateType(Request $request, $type_id) {
        try {
            $pageHeading = "update File Type";
            $result = Type::find($type_id);
            if ($result == null) {
                return Redirect::to(URL('admin/type/list'))->with('error', 'File Type not valid');
            }
            if ($request->isMethod('post')) {
                $result = Type::where('name', trim($request->name))->where('id', '!=', $type_id)->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', 'File Type already exists')->withInput();
                } else {
                    $result = Type::find($type_id);
                    
                    Type::where('id', $type_id)->update([
                        'name' => trim($request->name),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    return Redirect::to(URL('admin/type/list'))->with('success', 'File Type Updated Successfully');
                }
            } else {
                return view('admin.pages.type.update', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }
}