<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Auth;

use App\Models\Address;


class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Address::orderBy('updated_at', 'DESC')->where('user_id', Auth::id())->get();
        return $data;
        // return Inertia::render('addresses', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'street1' => ['max:255'],
            'street2' => ['max:255', 'required'],
            'suburb' => ['max:255', 'required'],
            'state' => ['max:255', 'required'],
            'country' => ['max:255', 'required'],
            'postcode' => ['max:255', 'required']
        ])->validate();

        Address::create(array_merge(['user_id'=>Auth::id()], $request->all()));

        return redirect()->back()
            ->with('message', 'Address created succesfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'street1' => ['max:255'],
            'street2' => ['max:255', 'required'],
            'suburb' => ['max:255', 'required'],
            'state' => ['max:255', 'required'],
            'country' => ['max:255', 'required'],
            'postcode' => ['max:255', 'required']
        ])->validate();

        Address::find($id)
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->update(array_merge(['user_id'=>Auth::id()], $request->all()));
        
        return redirect()
            ->back()
            ->with('message', 'Address updated succesfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Address::find($id)
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();
        return redirect()->back();
    }
}
