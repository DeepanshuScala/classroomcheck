<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Session,
    Validator,
    Redirect
};
use \App\Models\{
    WebContents,
    AboutUs,
    Testimonials
};

class ContentController extends Controller {

    /**
     * used to show list of content management 
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        try {
            $pageHeading = "Content";
            $result = WebContents::get();
            return view('admin.pages.content_mgnt.list', compact('result', 'pageHeading'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * used to update content
     * @param Request $request - request type get/post
     * @param type $content_id - id of content
     * @return type
     */
    public function updateContent(Request $request, $content_id) {
        try {
            $pageHeading = "Update Content";
            $result = WebContents::where('id', $content_id)->first();
            if ($result == null) {
                return Redirect::to(URL('admin/content/list'))->with('error', 'Web content not valid');
            }
            if ($request->isMethod('post')) {
                WebContents::where('id', $content_id)->update([
                    'description' => trim($request->body),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'url_link'   => $request->url_link,
                ]);
                Session::flash('success', 'Content Updated Successfully');
                return response()->json(['redirectTo' => url('admin/content/list')]);
            } else {
                return view('admin.pages.content_mgnt.update', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to show and update about us content
     * @param Request $request - request type get/post
     * @return type
     */
    public function updateAboutUs(Request $request) {
        try {
            $pageHeading = "About Us";
            $result = AboutUs::first();
            if ($request->isMethod('post')) {
                $about_us_image = ($result != null) ? $result->about_us_image : '';
                $founding_story_image = ($result != null) ? $result->founding_story_image : '';
                if ($request->hasfile('about_us_image')) {
                    $file = $request->file('about_us_image');
                    $path = 'public/uploads/about_us';
                    $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                    $about_us_image = $name;
                    $file->storeAs($path, $name);
                    if ($result != null && $result->about_us_image != ''){
                        if(file_exists(storage_path('app/public/uploads/about_us/' . $result->about_us_image))){
                            unlink(storage_path('app/public/uploads/about_us/' . $result->about_us_image));
                        }
                    }
                }
                if ($request->hasfile('founding_story_image')) {
                    $file = $request->file('founding_story_image');
                    $path = 'public/uploads/about_us';
                    $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                    $founding_story_image = $name;
                    $file->storeAs($path, $name);
                    if ($result != null && $result->founding_story_image != ''){
                        if(file_exists(storage_path('app/public/uploads/about_us/' . $result->founding_story_image))){
                            unlink(storage_path('app/public/uploads/about_us/' . $result->founding_story_image));
                        }
                    }
                }
                $insertUpdatearr = [
                    'about_us' => $request->about_us,
                    'about_us_image' => $about_us_image,
                    'our_vision' => $request->our_vision,
                    'our_mission' => $request->our_mission,
                    'founding_story_description' => $request->founding_story_description,
                    'founding_story_image' => $founding_story_image
                ];
                if ($result == null) {
                    $aboutUs = AboutUs::create($insertUpdatearr);
                    if ($aboutUs->id > 0) {
                        Session::flash('success', 'About Us added Successfully');
                        return response()->json(['redirectTo' => url('admin/content/about-us')]);
                    } else {
                        return response()->json(['redirectTo' => '', 'msg' => "Something went wrong"]);
                    }
                } else {
                    $insertUpdatearr['updated_at'] = date('Y-m-d H:i:s');
                    AboutUs::where('id', $result->id)->update($insertUpdatearr);
                    Session::flash('success', 'About Us updated Successfully');
                    return response()->json(['redirectTo' => url('admin/content/about-us')]);
                }
            } else {
                return view('admin.pages.content_mgnt.about_us', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    public function testimonials(Request $request){
        try {
            $pageHeading = "Testimonial";
            $result = Testimonials::get();
            $allow_add = count($result) >= 4 ? false : true;
            return view('admin.pages.content_mgnt.testimonials_list', compact('result', 'pageHeading','allow_add'));
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    public function addtestimonials(Request $request){
        try {
            $pageHeading = "Add Testimonial";
            if ($request->isMethod('post')) {
                $result = Testimonials::get();
                if (count($result) >= 4) {
                    return redirect()->back()->with('error', "Only 4 Testimonials allowed")->withInput();
                }
                $image = '';
                if ($request->hasfile('image')) {
                    $file = $request->file('image');
                    $path = 'public/uploads/testimonials';
                    $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                    $image = $name;
                    $file->storeAs($path, $name);
                }
                $isAdded = Testimonials::create([
                            'name' => trim($request->name),
                            'content' => trim($request->content),
                            'image' => $image,
                ]);
                if ($isAdded->id > 0) {
                    Session::flash('success', 'Testimonial added Successfully');
                    return response()->json(['redirectTo' => url('admin/content/testimonials')]);
                } else {
                    return redirect()->back()->with('error', "Something went wrong")->withInput();
                }
            } else {
                return view('admin.pages.content_mgnt.add_testimonial', compact('pageHeading'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to update Testimonial
     * @param Request $request - request type get/post
     * @param type $faq_id - id of Testimonal
     * @return type
     */
    public function updatetestimonial(Request $request, $testimonial_id) {
        try {
            $pageHeading = "Update Testimonial";
            $result = Testimonials::find($testimonial_id);
            if ($request->isMethod('post')) {
                if ($result == null) {
                    Session::flash('success', 'Testimonial not valid');
                    return response()->json(['redirectTo' => url('admin/content/testimonials')]);
                } else {
                    $image = $result->image;
                   
                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $path = 'public/uploads/testimonials';
                        $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                        $image = $name;
                        $file->storeAs($path, $name);
                
                        if ($result->image != ''){
                            if(file_exists(storage_path('app/public/uploads/blogs/'.$result->image))){
                                unlink(storage_path('app/public/uploads/blogs/'.$result->image));
                            }
                        }
                    }
                    
                    Testimonials::where('id', $testimonial_id)->update([
                        'name' => trim($request->name),
                        "content" => trim($request->content),
                        "image" => $image,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    Session::flash('success', 'Testimonial updated Successfully');
                    return Redirect::to(URL('admin/content/testimonials'));
                }
            } else {
                if ($result == null) {
                    return Redirect::to(URL('admin/content/testimonials'))->with('error', 'Testimonial not valid');
                }
                return view('admin.pages.content_mgnt.update_testimonials', compact('pageHeading', 'result'));
            }
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /**
     * used to delete Testimonial
     * @param type $testimonial_id - id of Testimonial
     * @return type
     */
    public function deleteTestimonial($testimonial_id) {
        try {
            $result = Testimonials::where('id', $testimonial_id)->first();
            if ($result == null) {
                return redirect()->back()->with('error', "Testimonial not valid");
            }
            if ($result->image != ''){
                if(file_exists(storage_path('app/public/uploads/testimonials/' . $result->image))){
                    unlink(storage_path('app/public/uploads/testimonials/' . $result->image));
                }
            }
            Testimonials::where('id', $testimonial_id)->delete();
            return redirect()->back()->with('success', "Testimonial deleted successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }
}
