<?php

namespace App\Http\Helper;
use Spatie\Newsletter\Facades\Newsletter;

use App\Models\{
    GradeLevels,
    ResourceTypes,
    Languages,
    SubjectDetails,
    Type,
    Product
};

class ClassroomCopyHelper {

    /**
     * get product types
     * @return string
     */
    public static function getProductType() {
        $resArr = [];
        $types = Type::where([['is_deleted','=',0],['status','=',1]])->get();
        foreach($types as $typ){
            $resArr[] = $typ->name;
        }










        return $resArr;
    }

    /**
     * get grade levels
     * @return type
     */
    public static function getProductLevel() {
        $resArr = GradeLevels::where('status', 1)->get();
        return $resArr;
    }

    /**
     * used to get interest area
     * @return string
     */
    public static function getInterestAreas() {
        $resArr = ['English', 'Math', 'Humanities and Social Studies', 'Science', 'Special Education',
            'Foreign Language', 'The Arts', 'PE / Health', 'Technologies', 'Multiple Elementary Subjects',
            'Other'];

        return $resArr;
    }

    /**
     * used to get time duration
     * @return string
     */
    public static function getTimeDuration() {
        $teachingDurationArr = [
            'N/A',
            'Less than 30 Minutes',
            '30 Minutes', '40 Minutes', '45 Minutes', '50 Minutes',
            '1 Hour', '1.5 Hours', '2 Hours', '3 Hours',
            '1 Day', '2 Days', '3 Days', '4 Days',
            '1 Week', '2 Weeks', '3 Weeks',
            '1 Month', '2 Months', '3 Months',
            '1 Term', '1 Semester', '1 Year', 'Lifelong Tool', 'Other'
        ];
        return $teachingDurationArr;
    }

    /**
     * used to get gift card amount
     * @return string
     */
    public static function getGiftCardAmount() {
        $resArr = ['5.00', '10.00', '25.00', '50.00', '75.00', '100.00', '200.00', '500.00'];

        return $resArr;
    }

    /**
     * used to get resource types
     * @return type
     */
    public static function getResourceTypes() {
        $resArr = ResourceTypes::where('status', 1)->where('is_deleted', 0)->get();
        return $resArr;
    }

    /**
     * used to get resource types
     * @return type
     */
    public static function getLanguages() {
        $resArr = Languages::where('status', 1)->get();
        return $resArr;
    }

    /**
     * used to get feature listing category
     * @return string
     */
    public static function getFeatureListingCategory() {
        $Arr = [];
        $Arr['grdelvl'] = array();
        $Arr['subjects'] = array();
        /*
        $grdelvl = GradeLevels::where('status', 1)->get();
        if(!is_null($grdelvl)){
            $Arr['grdelvl'] = $grdelvl;
        }
        */
        $subject = SubjectDetails::where('status', 1)->where('parent_id',0)->where('is_deleted', 0)->get();
        if(!is_null($subject)){
            $Arr['subjects'] = $subject;
        }
        /*$Arr = [
            'English Language',
            'Mathematics',
            'Science',
            'Humanities and Social Sciences',
            'Technologies',
            'Health and Physical Education',
            'The Arts',
            'Languages other than English',
            'Holiday / Seasonal',
            'Classroom Management',
            'School Management',
            'Special Education',
            'Gifted and Talented',
            'Professional Development',
            'Products for Teacher Authors',
            'Specialty'
        ];
        */

        return $Arr;
    }

    /**
     * used to get subject area
     * @return string
     */
    public static function getProductSubjectArea($calltype = 'other') {
        if($calltype == 'other'){
            $resArr = SubjectDetails::where('status', 1)->where('parent_id',0)->where('is_deleted', 0)->get();
        }
        else{
            $resArr = SubjectDetails::where('status', 1)->where('is_deleted', 0)->get();
        }
        return $resArr;
    }

    /**
     * used to get subject sub area
     * @param type $subjectArea - area of subject
     * @return array
     */
    public static function getProductSubjectSubArea($subjectArea) {
        $resArr = SubjectDetails::where('parent_id', $subjectArea)->where('is_deleted', 0)->get();
        /*
            if ($subjectArea == 1) {
                $resArr = [
                    ['key' => 1, 'value' => 'Behaviour'],
                    ['key' => 2, 'value' => 'Differentiation'],
                    ['key' => 3, 'value' => 'Inclusion']
                ];
            } else if ($subjectArea == 2) {
                $resArr = [
                    ['key' => 1, 'value' => 'Behaviour'],
                    ['key' => 2, 'value' => 'Beginning Teachers'],
                    ['key' => 3, 'value' => 'Coaching'],
                    ['key' => 4, 'value' => 'Differentiation'],
                    ['key' => 5, 'value' => 'Duties / Rosters'],
                    ['key' => 6, 'value' => 'Forms'],
                    ['key' => 7, 'value' => 'Grant Proposals'],
                    ['key' => 8, 'value' => 'Inclusion'],
                    ['key' => 9, 'value' => 'Intervention'],
                    ['key' => 10, 'value' => 'Mentoring'],
                    ['key' => 11, 'value' => 'Professional Development'],
                    ['key' => 12, 'value' => 'School Policies / Documents'],
                    ['key' => 13, 'value' => 'Student Council'],
                    ['key' => 14, 'value' => 'Watching Others Work']
                ];
            } elseif ($subjectArea == 3) {
                $resArr = [
                    ['key' => 1, 'value' => 'Assemblies'],
                    ['key' => 2, 'value' => 'Games'],
                    ['key' => 3, 'value' => 'Library'],
                    ['key' => 4, 'value' => 'Gifted and Talented'],
                    ['key' => 5, 'value' => 'Life Skills'],
                    ['key' => 6, 'value' => 'Philosophy'],
                    ['key' => 7, 'value' => 'Religion'],
                    ['key' => 8, 'value' => 'Special Education'],
                    ['key' => 9, 'value' => 'Speech Therapy'],
                    ['key' => 10, 'value' => 'Study Skills'],
                    ['key' => 11, 'value' => 'Test Preparation'],
                    ['key' => 12, 'value' => 'Vocational Education'],
                    ['key' => 13, 'value' => 'Other (Specialty)']
                ];
            } elseif ($subjectArea == 4) {
                $resArr = [
                    ['key' => 1, 'value' => 'English Language'],
                    ['key' => 2, 'value' => 'Reading']
                ];
            } else {
                $resArr = [];
            }
        */
        return $resArr;
    }

    public static function Newsletter_subscribe($email,$fname,$lname){
        Newsletter::subscribeOrUpdate($email,['FNAME'=>$fname,'LNAME'=>$lname],'', ['tags' => ['newsletter']]);
    }

    public static function Newsletter_unsubscribe($email){
       Newsletter::unsubscribe($email); 
    }

    public static function getProducts(){
        $products = Product::where([['is_deleted', '=', 0], ['user_id', '=', auth()->user()->id]])->get();
        return $products;
    }
}