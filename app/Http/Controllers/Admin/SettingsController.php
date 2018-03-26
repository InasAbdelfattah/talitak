<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Company;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostsRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Auth;
use Config;
use Image;
use Session;
use UploadImage;

class SettingsController extends Controller
{

    /**
     * @var string
     * @ public variable to save path.
     */
    public $public_path;

    function __construct()
    {
        $this->public_path = 'files/settings/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $settings = Setting::all();
        return view('admin.settings.setting')->withSettings($settings);
    }


    public function commission()
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $settings = Setting::all();
        return view('admin.settings.commission')->withSettings($settings);
    }


    public function commentsProjects()
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $settings = Setting::all();
        $companies = Company::where('is_active', 1)->get();
        return view('admin.settings.projects')->withSettings($settings)->withCompanies($companies);
    }


    public function commentsProjectsSettings(Request $request)
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        foreach ($request->all() as $key => $value) {
            if ($key != '_token' && $key != 'companies'):
                Setting::updateOrCreate(['key' => $key], ['body' => $value]);
            endif;
        }
        //DISABLES COMMENTS FOR CERTAIN COMPANIES
        if ($request->comment_setting == 2) {

            $companies = Company::where('is_active', 1)->get();
            foreach ($companies as $company) {
                $company->is_comment = 1;
                $company->save();
            }


            if ($request->companies != '') {

                foreach ($request->companies as $id) {
                    $company = Company::find($id);
                    $company->is_comment = 0;
                    $company->save();
                }

            }
            //disables comments for all
        }elseif ($request->comment_setting == 2) {

            $companies = Company::where('is_active', 1)->get();
            foreach ($companies as $company) {
                $company->is_comment = 0;
                $company->save();
            }
            //enables comments for all
        }else{
            $companies = Company::where('is_active', 1)->get();
            foreach ($companies as $company) {
                $company->is_comment = 1;
                $company->save();
            }
        }


        return response()->json([
            'status' => true,
            'message' => 'لقد حفظ تعديلات بيانات االتعليقات بنجاح.'
        ]);

    }


    public function ratingProjectsSettings(Request $request)
    {

        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        foreach ($request->all() as $key => $value) {
            if ($key != '_token' && $key != 'companies'):
                Setting::updateOrCreate(['key' => $key], ['body' => $value]);
            endif;
        }


        if ($request->rate_setting == 2) {

            $companies = Company::where('is_active', 1)->get();
            foreach ($companies as $company) {
                $company->is_rate = 1;
                $company->save();
            }

            if ($request->companies != '') {

                foreach ($request->companies as $id) {
                    $company = Company::find($id);
                    $company->is_rate = 0;
                    $company->save();
                }

            }
        }elseif ($request->rate_setting == 0) {

            $companies = Company::where('is_active', 1)->get();
            foreach ($companies as $company) {
                $company->is_rate = 0;
                $company->save();
            }
            //enables rate for all
        }else{
            $companies = Company::where('is_active', 1)->get();
            foreach ($companies as $company) {
                $company->is_rate = 1;
                $company->save();
            }
        }


        return response()->json([
            'status' => true,
            'message' => 'لقد حفظ تعديلات بيانات التقييمات بنجاح.'
        ]);
    }


    public function aboutus()
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $settings = Setting::all();
        return view('admin.settings.aboutus')->withSettings($settings);
    }

    public function socialLinks()
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $settings = Setting::all();
        return view('admin.settings.socials')->withSettings($settings);
    }


    public function terms()
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $settings = Setting::all();
        return view('admin.settings.terms')->withSettings($settings);
    }


    public function prohibitedgoods()
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $settings = Setting::all();
        return view('admin.settings.prohibitedgoods')->withSettings($settings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        return view('admin.settings.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }
        
        foreach ($request->all() as $key => $value) {
            if ($key != '_token' && $key != 'about_app_image_old'):
                Setting::updateOrCreate(['key' => $key], ['body' => $value]);
            endif;
        }

        if ($request->hasFile('about_app_image')):
            Setting::updateOrCreate(['key' => 'about_app_image'], ['body' => $this->public_path . UploadImage::uploadMainImage($request, 'about_app_image', $this->public_path)]);

            if ($request->about_app_image_old) {
                if (\File::exists(public_path($request->about_app_image_old))):
                    \File::delete(public_path($request->about_app_image_old));
                endif;
            }
        endif;

        return redirect()->back()->with('success', 'تم الحفظ بنجاح');

    }


}