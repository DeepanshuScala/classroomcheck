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
    ResourceTypes
};
use \App\Http\Helper\Web;

class ResourceController extends Controller {

    /** + 
     * used to get list of resources
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        try {
            $pageHeading = "Resource";
            $result = ResourceTypes::where('is_deleted', 0)->orderBy('id', 'DESC')->get();
            return view('admin.pages.resource.list', compact('result', 'pageHeading'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * 
     * used to activate/deactivate resource
     * @param type $resource_id - id of resource
     * @param type $status - status of resource(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivateResource($resource_id, $status) {
        try {
            $result = ResourceTypes::where('id', $resource_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "Resource not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($result->status == $status) {
                return redirect()->back()->with('error', "Resource already $msgTxt");
            }
            ResourceTypes::where('id', $resource_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "Resource $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** +
     * used to add new resource
     * @param Request $request - request type get/post
     * @return type
     */
    public function addResource(Request $request) {
        try {
            $pageHeading = "Add Resource";
            if ($request->isMethod('post')) {
                $result = ResourceTypes::where('name', trim($request->name))->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', "Resource already exist")->withInput();
                }
                $isAdded = ResourceTypes::create([
                            'name' => trim($request->name)
                ]);
                if ($isAdded->id > 0) {
                    return Redirect::to(URL('admin/resource/list'))->with('success', 'Resource Added Successfully');
                } else {
                    return redirect()->back()->with('error', "Something went wrong")->withInput();
                }
            } else {
                return view('admin.pages.resource.add', compact('pageHeading'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * used to update resource
     * @param Request $request - request type get/post
     * @param type $resource_id - id of resource
     * @return type
     */
    public function updateResource(Request $request, $resource_id) {
        try {
            $pageHeading = "Update Resource";
            $result = ResourceTypes::find($resource_id);
            if ($result == null) {
                return Redirect::to(URL('admin/resource/list'))->with('error', 'Resource not valid');
            }
            if ($request->isMethod('post')) {
                $result = ResourceTypes::where('name', $request->name)->where('id', '!=', $resource_id)->get();
                if (count($result) > 0) {
                    return redirect()->back()->with('error', "Resource already exist")->withInput();
                }
                ResourceTypes::where('id', $resource_id)->update([
                    'name' => trim($request->name),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                return Redirect::to(URL('admin/resource/list'))->with('success', 'Resource Updated Successfully');
            } else {
                return view('admin.pages.resource.update', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }


    public function deleteResource(Request $request,$resource_id){
        try {
            $result = ResourceTypes::where('id', $resource_id)->first();
            if ($result == null) {
                return Redirect::to(URL('admin/resource/list'));
            }
            ResourceTypes::where('id', $resource_id)->update([
                'is_deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return Redirect::to(URL('admin/resource/list'))->with('success', 'Resource Deleted Successfully');
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }
}