<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Review;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $location = $request->geo;
        
        
        $business = Business::where('city', 'like',"%$location%")
        ->orWhere('address', 'like', "%$location%")
        ->limit(12)
        ->get();


        
        return view('business.search', compact('business', 'location'))->with('business', $business);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $business = Business::where('business_id', $id)->first();
        
        $review = Review::where('business_id', $id)->get();
        
        dd($business);
        $business = Business::where('business_id', $id)->first();
        return view('business.show', compact('business', 'review'));
    }
}
