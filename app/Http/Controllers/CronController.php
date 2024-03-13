<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB
};
use App\Models\FeatureList;

class CronController extends Controller {

    /**
     * used to expire feature products
     * @param Request $request - request type get
     */
    public function cronForFeatureProductExpire(Request $request) {
        $date = date('Y-m-d');
        $result = FeatureList::whereIn('status', [0, 1])
                ->where('date', '<', $date)->get();
        if (count($result) > 0) {
            foreach ($result as $row) {
                FeatureList::where('id', $row->id)->update([
                    'status' => 2,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            echo "Updated";
        } else {
            echo "No data found";
        }
    }

}
