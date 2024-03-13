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
use \App\Models\Blogs;
use Exception;

class BlogController extends Controller {

    /**
     * used to get list of Blogs
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        try {
            $pageHeading = "Blogs";
            $result = Blogs::orderBy('id', 'DESC')->get();
            return view('admin.pages.blogs.list', compact('result', 'pageHeading'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to activate/deactivate Blog
     * @param type $blog_id - id of Blog
     * @param type $status - status of Blog(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivateBlog($blog_id, $status) {
        try {
            $result = Blogs::where('id', $blog_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "Blog not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($result->status == $status) {
                return redirect()->back()->with('error', "Blog already $msgTxt");
            }
            Blogs::where('id', $blog_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "Blog $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to delete Blog
     * @param type $blog_id - id of Blog
     * @return type
     */
    public function deleteBlog($blog_id) {
        try {
            $result = Blogs::where('id', $blog_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "Blog not valid");
            }
            if ($result->image1 != ''){
                try{
                    unlink(storage_path('app/public/uploads/blogs/' . $result->image1));
                }catch(Exception $e){

                }
            }

            if ($result->image2 != ''){
                try{
                    unlink(storage_path('app/public/uploads/blogs/' . $result->image2));
                }catch(Exception $e){

                }
            }
            if ($result->image3 != ''){
                try{
                    unlink(storage_path('app/public/uploads/blogs/' . $result->image3));
                }catch(Exception $e){

                }
            }
            Blogs::where('id', $blog_id)->delete();
            return redirect()->back()->with('success', "Blog deleted successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to add new Blog
     * @param Request $request - request type get/post
     * @return type
     */
    public function addBlog(Request $request) {
        try {
            $pageHeading = "Add Blog";
            if ($request->isMethod('post')) {
                $image1 = $image2 = $image3 = '';
                if ($request->hasfile('image1')) {
                    $file = $request->file('image1');
                    $path = 'public/uploads/blogs';
                    $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                    $image1 = $name;
                    $file->storeAs($path, $name);
                }
                if ($request->hasfile('image2')) {
                    $file = $request->file('image2');
                    $path = 'public/uploads/blogs';
                    $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                    $image2 = $name;
                    $file->storeAs($path, $name);
                }
                if ($request->hasfile('image3')) {
                    $file = $request->file('image3');
                    $path = 'public/uploads/blogs';
                    $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                    $image3 = $name;
                    $file->storeAs($path, $name);
                }
                $isBlogAdded = Blogs::create([
                            'title' => trim($request->title),
                            "short_description" => trim($request->short_description),
                            "long_description" => trim($request->body),
                            "image1" => $image1,
                            "image2" => $image2,
                            "image3" => $image3
                ]);
                if ($isBlogAdded->id > 0) {
                    Session::flash('success', 'Blog added Successfully');
                    return response()->json(['redirectTo' => url('admin/blog/list')]);
                } else {
                    return response()->json(['redirectTo' => '', 'msg' => "Something went wrong"]);
                }
            } else {
                return view('admin.pages.blogs.add', compact('pageHeading'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to update Blog
     * @param Request $request - request type get/post
     * @param type $faq_id - id of Blog
     * @return type
     */
    public function updateBlog(Request $request, $blog_id) {
        try {
            $pageHeading = "Update Blog";
            $result = Blogs::find($blog_id);
            if ($request->isMethod('post')) {
                if ($result == null) {
                    Session::flash('success', 'Blog not valid');
                    return response()->json(['redirectTo' => url('admin/blog/list')]);
                } else {
                    $image1 = $result->image1;
                    $image2 = $result->image2;
                    $image3 = $result->image3;
                    if ($request->hasfile('image1')) {
                        $file = $request->file('image1');
                        $path = 'public/uploads/blogs';
                        $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                        $image1 = $name;
                        $file->storeAs($path, $name);
                        if ($result->image1 != ''){
                            try{
                               unlink(storage_path('app/public/uploads/blogs/' . $result->image1));
                            }catch(Exception $e){

                            }
                        }
                    }
                    if ($request->hasfile('image2')) {
                        $file = $request->file('image2');
                        $path = 'public/uploads/blogs';
                        $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                        $image2 = $name;
                        $file->storeAs($path, $name);
                        if ($result->image2 != ''){
                            try{
                               unlink(storage_path('app/public/uploads/blogs/' . $result->image2));
                            }catch(Exception $e){

                            }
                            
                        }
                    }
                    if ($request->hasfile('image3')) {
                        $file = $request->file('image3');
                        $path = 'public/uploads/blogs';
                        $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                        $image3 = $name;
                        $file->storeAs($path, $name);
                        if ($result->image3 != ''){
                            try{
                               unlink(storage_path('app/public/uploads/blogs/' . $result->image3));
                            }catch(Exception $e){

                            } 
                        }
                    }
                    Blogs::where('id', $blog_id)->update([
                        'title' => trim($request->title),
                        "short_description" => trim($request->short_description),
                        "long_description" => trim($request->body),
                        "image1" => $image1,
                        "image2" => $image2,
                        "image3" => $image3,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    Session::flash('success', 'Blog updated Successfully');
                    return response()->json(['redirectTo' => url('admin/blog/list')]);
                }
            } else {
                if ($result == null) {
                    return Redirect::to(URL('admin/blog/list'))->with('error', 'Blog not valid');
                }
                return view('admin.pages.blogs.update', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

}
