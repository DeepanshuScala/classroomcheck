<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Redirect,
    Auth,
    Mail
};
use \App\Models\{
    WebContents,
    Faq,
    Blogs,
    ContactUs,
    AboutUs,
    Subscribers
};

class WebContentController extends Controller {

    /**
     * used to show web page content
     * @param Request $request - request type get
     * @param type $slug - slug of web page
     * @return type
     */
    public function index($slug) {
        if (Auth::check() && auth()->user() != null && auth()->user()->role_id == 3) {
            return redirect('/admin/dashboard');
        }
        $result = WebContents::where('slug', $slug)->first();
        if ($result == null) {
            return redirect()->back();
        } else {
            $data = [];
            $data['title'] = $result->web_page;
            $data['home'] = 'Home';
            $data['breadcrumb1'] = $result->parent_page;  
            if($data['breadcrumb1'] == 'Help & FAQ'){
                $data['breadcrumb1_link'] = route('help.faq');
            }
            elseif ($data['breadcrumb1'] == 'Documents & Policies') {
                $data['breadcrumb1_link'] = route('document.and.policies');
            }      
            $data['breadcrumb2'] = $result->web_page;
            $data['breadcrumb3'] = false;
            $data['result'] = $result;

            return view('web_content', compact('data'));
        }
    }

    /**
     * used to get FAQ
     * @return type
     */
    public function getFaq() {
        if (Auth::check() && auth()->user() != null && auth()->user()->role_id == 3) {
            return redirect('/admin/dashboard');
        }
        //$result = Faq::where('is_deleted', 0)->where('status', 1)->orderBy('id', 'DESC')->get();
        $result = Faq::where('is_deleted', 0)->where('status', 1)->orderBy('order', 'asc')->get();
        $data = [];
        $data['title'] = "FAQ";
        $data['home'] = 'Home';
        $data['breadcrumb1'] = "Help & FAQ";
        $data['breadcrumb1_link'] = route('help.faq');
        $data['breadcrumb2'] = "FAQ";
        $data['breadcrumb3'] = false;
        $data['result'] = $result;

        return view('faq', compact('data'));
    }

    /**
     * used to show blogs list
     * @param Request $request - request type get
     * @return type
     */
    public function getBlogs(Request $request) {
        if (Auth::check() && auth()->user() != null && auth()->user()->role_id == 3) {
            return redirect('/admin/dashboard');
        }
        $result = Blogs::where('status', 1)->orderBy('id', 'DESC')->get();
        $data = [];
        $data['title'] = "Blogs";
        $data['home'] = 'Home';
        $data['breadcrumb1'] = "Blogs";
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;
        $data['result'] = $result;

        return view('blogs', compact('data'));
    }

    /**
     * used to show blog details
     * @param Request $request - request type get
     * @param type $blog_id - id of blog
     * @return type
     */
    public function getBlogDetails(Request $request, $blog_id) {
        if (Auth::check() && auth()->user() != null && auth()->user()->role_id == 3) {
            return redirect('/admin/dashboard');
        }
        $result = Blogs::where('status', 1)->where('id', $blog_id)->first();
        if ($result == null) {
            return Redirect::to('/blogs');
        } else {
            $data = [];
            $data['title'] = "Blogs";
            $data['home'] = 'Home';
            $data['breadcrumb1'] = "Blogs";
            $data['breadcrumb1_link'] = route('blog.list');
            $data['breadcrumb2'] = $result->title;
            $data['breadcrumb3'] = false;
            $imageArr = [];
            if ($result->image1 != '' && $result->image1 != null)
                $imageArr[] = $result->image1;
            if ($result->image2 != '' && $result->image2 != null)
                $imageArr[] = $result->image2;
            if ($result->image3 != '' && $result->image3 != null)
                $imageArr[] = $result->image3;
            $result->imageArr = $imageArr;
            $data['result'] = $result;

            return view('blog_details', compact('data'));
        }
    }

    /**
     * used to show contact us page & send message to admin and user
     * @param Request $request - request type get/post
     * @return type
     */
    public function getContactUs(Request $request) {
        if ($request->isMethod('post')) {
            $userID = 0;
            $message = '';
            $success = false;
            if (Auth::check() && auth()->user() != null) {
                $userID = auth()->user()->id;
            }
            $isAdded = ContactUs::create([
                        'user_id' => $userID,
                        'topic' => $request->topic,
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'message' => $request->message,
                        'status'=>0,
            ]);
            if ($isAdded->id > 0) {
                $success = 1;
                $adminEmail = env('ADMIN_EMAIL');
                $emailData = [
                    "name" => $request->name,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "mail_message" => $request->message,
                    "subject" => 'Contact Us',
                    "content" => '',
                    'adminEmail' => $adminEmail
                ];
                //send email to admin
                try {
                    $send_mail = Mail::send('emails/contact_us/admin_mail', $emailData, function ($message)use ($emailData) {
                                $message->to('admin@classroomcopy.com');
                                $message->subject($emailData['subject']);
                            });
                } catch (Exception $e) {
                    $success = 0;
                    $message = $e->getMessage();
                }
                //send email to user
                try {
                    $send_mail = Mail::send('emails/contact_us/user_mail', $emailData, function ($message)use ($emailData) {
                                $message->to($emailData['email']);
                                // $message->cc('admin@classroomcopy.com');
                                $message->subject('ClassroomCopy - CONTACT RECEIVED');
                            });
                } catch (Exception $e) {
                    $success = 0;
                    $message = $e->getMessage();
                }
            } else {
                $success = 0;
            }
            echo json_encode(array('success' => $success, 'message' => $message));
        } else {
            if (Auth::check() && auth()->user() != null && auth()->user()->role_id == 3) {
                return redirect('/admin/dashboard');
            }
            $data = [];
            $data['title'] = "Contact Us";
            $data['home'] = 'Home';
            $data['breadcrumb1'] = "Contact Us";
            $data['breadcrumb2'] = false;
            $data['breadcrumb3'] = false;

            return view('contact_us', compact('data'));
        }
    }

    /**
     * used to show about us page
     * @param Request $request - request type get
     * @return type
     */
    public function aboutUs(Request $request) {
        if (Auth::check() && auth()->user() != null && auth()->user()->role_id == 3) {
            return redirect('/admin/dashboard');
        }
        $result = AboutUs::first();
        $data = [];
        $data['title'] = 'About Us';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'About Us';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;
        $data['result'] = $result;

        return view('about_us', compact('data'));
    }

    /**
     * used to subscribe on website
     * @param Request $request - request type get/post
     * @return type
     */
    public function subscribeOnWeb(Request $request) {
        if ($request->isMethod('post')) {
            $message = '';
            $success = false;
            $isAdded = Subscribers::create([
                        'email' => $request->email
            ]);
            if ($isAdded->id > 0) {
                $adminEmail = env('ADMIN_EMAIL');
                $success = 1;
                $emailData = [
                    "email" => $request->email,
                    "subject" => 'Classroom Copy - Newletter Subscribed',
                    "content" => '',
                    'adminEmail' => $adminEmail
                ];
                //send email to admin
                try {
                    $send_mail = Mail::send('emails/newsletter_subscribe/admin_subscribe_mail', $emailData, function ($message)use ($emailData) {
                                $message->to($emailData['adminEmail']);
                                $message->subject($emailData['subject']);
                            });
                } catch (Exception $e) {
                    $success = 0;
                    $message = $e->getMessage();
                }
                //send email to user
                try {
                    $send_mail = Mail::send('emails/newsletter_subscribe/user_subscribe_mail', $emailData, function ($message)use ($emailData) {
                                $message->to($emailData['email']);
                                $message->cc('admin@classroomcopy.com');
                                $message->subject($emailData['subject']);
                            });
                } catch (Exception $e) {
                    $success = 0;
                    $message = $e->getMessage();
                }
            } else {
                $success = 0;
            }
            echo json_encode(array('success' => $success, 'message' => $message));
        } else {
            if (Auth::check() && auth()->user() != null && auth()->user()->role_id == 3) {
                return redirect('/admin/dashboard');
            }
            $data = [];
            $data['title'] = "Newsletter Subscribe";
            $data['home'] = 'Home';
            $data['breadcrumb1'] = "Newsletter Subscribe";
            $data['breadcrumb2'] = false;
            $data['breadcrumb3'] = false;

            return view('web_subscribe', compact('data'));
        }
    }

}
