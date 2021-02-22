<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager ;
use Carbon\Carbon;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = Manager::all();
        return view('larasnap::manager.index', ['users' => $manager]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('larasnap::manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //dd($request->all());
        $request->validate([
            'first_name' => 'required|min:6|max:15',
            'last_name' => 'required|min:4|max:6',
            'email' => 'required|min:9|max:30|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mobile_phone' => 'required|required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|confirmed|min:6|regex:/^.+@.+$/i|max:15',
            'user_photo' => 'required|mimes:jpg, png, gif, svg, jpeg',
            ],[
            'first_name.required' => 'FirstName is Required',
            'first_name.min' => 'FirstName should be atleast :min characters',
            'first_name.max' => 'FirstName should not be greater than :max characters',
            'last_name.required' => 'LastName is Required',
            'last_name.min' => 'LastName should be atleast :min characters',
            'last_name.max' => 'LastName should not be greater than :max characters',
            'email.required' => 'email is Required',
            'email.min' => 'email should be atleast :min characters',
            'email.max' => 'email should not be greater than :max characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password should be atleast:min characters',
            'password.max' => 'Password should be atleast:max characters',
                ]);
        $timeStamp = Carbon::now()->format('Y_m_d_H_i_s');
        $fileExtension = $request->user_photo->extension();

        $fileName = $timeStamp.'.'.$fileExtension;
        $request->user_photo->storeAs('public/images', $fileName);
        $manager = new Manager;
        $manager->first_name = $request->first_name;
        $manager->last_name = $request->last_name;
        $manager->email = $request->email;
        $manager->mobile_phone = $request->mobile_phone;
        $manager->password = bcrypt($request->password);
        $manager->user_photo = $fileName;
        $manager->save();
        return redirect()->route('managers.index');
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
        $manager = Manager::find($id);
        return view('larasnap::manager.edit',['users' => $manager]);
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:6|max:15',
            'last_name' => 'required|min:6|max:15',
            'email' => 'required|min:9|max:30|unique:users,email,'.$id,
            'mobile_phone' => 'required|required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|confirmed|min:6|regex:/^.+@.+$/i|max:15',
            //'password_confirmation' => 'required_with:password|same:password',
            'user_photo' => 'required|mimes:jpg, png, gif, svg, jpeg',
            ],[
            'first_name.required' => 'FirstName is Required',
            'first_name.min' => 'FirstName should be atleast :min characters',
            'first_name.max' => 'FirstName should not be greater than :max characters',
            'last_name.required' => 'LastName is Required',
            'last_name.min' => 'LastName should be atleast :min characters',
            'last_name.max' => 'LastName should not be greater than :max characters',
            'email.required' => 'email is Required',
            'email.min' => 'email should be atleast :min characters',
            'email.max' => 'email should not be greater than :max characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password should be atleast:min characters',
            'password.max' => 'Password should be atleast:max characters',
                ]);
        //dd($request->all());
        $timeStamp = Carbon::now()->format('Y_m_d_H_i_s');
        $fileExtension = $request->user_photo->extension();

        $fileName = $timeStamp.'.'.$fileExtension;
        $request->user_photo->storeAs('public/images', $fileName);
        $manager = Manager::find($request->id);
        $manager->first_name = $request->first_name;
        $manager->last_name = $request->last_name;
        $manager->email = $request->email;
        $manager->mobile_phone = $request->mobile_phone;
        $manager->password = bcrypt($request->password);
        $manager->user_photo = $fileName;
        $manager->update();
        return redirect()->route('managers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manager = Manager::find($id);
        if (!empty($manager)){
            $manager->delete();
            }else{
    
            }
        return redirect()->route('managers.index');
    }
}
