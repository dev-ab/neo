<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NasaService;
use App\Neo;
use DB;

class NeoController extends Controller {

    /**
     * Request past 3 days asteroids data from nasa api and save them to the database
     * 
     * @param NasaService $nasa
     * @return array
     */
    public function index(NasaService $nasa) {
        $feed = $nasa->feed(date('Y-m-d'), date('Y-m-d', strtotime('-3 days')));

        // Return the error message if there was error
        if (isset($feed['error']))
            return $feed;

        //Save feed to database
        $nasa->saveToDatabase();

        return ['number_of_asteroids' => $feed['element_count'], 'saved_to_database' => true];
    }

    /**
     * Get the hazardous asteroids from the database
     * 
     * @return array
     */
    public function hazardous() {
        return Neo::where('is_hazardous', 1)->get();
    }

    /**
     * Get the fastest asteroid from the database and also choose hazardous asteroids only or not 
     * 
     * @param Request $request
     * @return Neo
     */
    public function fastest(Request $request) {
        if ($request->input('hazardous') && $request->input('hazardous') == 'true') {

            $result = Neo::where('is_hazardous', 1)->orderBy('speed', 'desc')->take(1)->get();
            return $result->count() > 0 ? $result[0] : null;
        } else {

            $result = Neo::orderBy('speed', 'desc')->take(1)->get();
            return $result->count() > 0 ? $result[0] : null;
        }
    }

    /**
     * Get the year with most asteroids from the database
     * 
     * @param Request $request
     * @return string
     */
    public function bestYear(Request $request) {
        if ($request->input('hazardous') && $request->input('hazardous') == 'true') {

            $result = Neo::where('is_hazardous', 1)->select(DB::raw('YEAR(`date`) AS `year`, COUNT(*) AS `total`'))->groupBy(DB::raw('YEAR(`date`)'))->orderBy('total', 'desc')->get();

            return $result->count() > 0 ? $result[0]['year'] : null;
        } else {

            $result = Neo::select(DB::raw('YEAR(`date`) AS `year`, COUNT(*) AS `total`'))->groupBy(DB::raw('YEAR(`date`)'))->orderBy('total', 'desc')->get();
            return $result->count() > 0 ? $result[0]['year'] : null;
        }
    }

    /**
     * Get the month with most asteroids (without specifying the year)
     * 
     * @param Request $request
     * @return string
     */
    public function bestMonth(Request $request) {
        if ($request->input('hazardous') && $request->input('hazardous') == 'true') {

            $result = Neo::where('is_hazardous', 1)->select(DB::raw('MONTH(`date`) AS `month`, COUNT(*) AS `total`'))->groupBy(DB::raw('MONTH(`date`)'))->orderBy('total', 'desc')->get();
            return $result->count() > 0 ? $result[0]['month'] : null;
        } else {

            $result = Neo::select(DB::raw('MONTH(`date`) AS `month`, COUNT(*) AS `total`'))->groupBy(DB::raw('MONTH(`date`)'))->orderBy('total', 'desc')->get();
            return $result->count() > 0 ? $result[0]['month'] : null;
        }
    }

}
