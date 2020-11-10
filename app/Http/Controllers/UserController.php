<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Validator;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
                    ->orderBy('name','asc')
                    ->get();
        return view('users.index',['data_users' => $users]);
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
        $rules = array(
            'add_name'                  => 'required',
            'add_address'               => 'required',
            'add_gender'                => 'required',
            'add_email'                 => 'required|unique:users,email',
            'add_password'              => 'required|confirmed|min:8',
            'add_password_confirmation' => 'required',
            'add_photo'                 => 'mimes:jpeg,bmp,png'
        );

        $customMessages = array(
            'add_name.required'                  => 'The name field is required.',
            'add_address.required'               => 'The address field is required.',
            'add_gender.required'                => 'Gender is required',
            'add_email.required'                 => 'The email field is required.',
            'add_email.unique'                   => 'The email already exist.',
            'add_password.required'              => 'The password field is required.',
            'add_password.confirmed'             => 'Password and confirmation password not match.',
            'add_password.min'                   => 'The password must be at least 8 characters.',
            'add_password_confirmation.required' => 'The password confirmation field is required.',
            'add_photo.mimes'                    => 'File must be an image'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }   
        
        if($request->add_photo != null){
            $image    = $request->file('add_photo');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('display_picture'), $new_name);
        } else {
            $new_name = 'default_image.png';
        }
       
        DB::table('users')->insert([
            'name'       => $request -> add_name,
            'address'    => $request -> add_address,
            'gender'     => $request -> add_gender,
            'email'      => $request -> add_email,
            'password'   => bcrypt($request -> add_password),
            'photo'      => $new_name,
            'role'       => $request -> add_role,
            'status'     => $request -> add_status,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
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
    public function updateProfile(Request $request)
    {
        $email = DB::table('users')
                    ->where('id',$request -> edit_id)
                    ->value('email');

        $rules = array(
            'edit_name'    => 'required',
            'edit_address' => 'required',
            'edit_gender'  => 'required',
            'edit_email'   => 'required',
            'edit_photo'    => 'mimes:jpeg,bmp,png'
        );

        $customMessages = array(
            'edit_name.required'    => 'The name field is required.',
            'edit_address.required' => 'The address field is required.',
            'edit_gender.required'  => 'Gender is required',
            'edit_email.required'   => 'The email field is required.',
            'edit_photo.mimes'       => 'File must be an image'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }   
        
        if($request -> edit_email != $email){
            $checkEmail = array(
                'edit_email' => 'unique:users,email'
            );
        
            $checkEmailCustomMessages = array(
                'edit_email.unique' => 'The email already exist.',
            );

            $error = Validator::make($request->all(), $checkEmail, $checkEmailCustomMessages);

            if ($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
        } 

        if($request->edit_photo != null){
            $image    = $request->file('edit_photo');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('display_picture'), $new_name);

            DB::table('users')->where('id',$request->edit_id)->update([
                'name'       => $request -> edit_name,
                'address'    => $request -> edit_address,
                'gender'     => $request -> edit_gender,
                'email'      => $request -> edit_email,
                'photo'      => $new_name,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        } else {
            DB::table('users')->where('id',$request->edit_id)->update([
                'name'       => $request -> edit_name,
                'address'    => $request -> edit_address,
                'gender'     => $request -> edit_gender,
                'email'      => $request -> edit_email,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        return response()->json(['success' => 'data']);
    }
    

    public function update(Request $request)
    {
        $rules = array(
            'edit_name'     => 'required',
            'edit_address'  => 'required',
            'edit_gender'   => 'required'
        );

        $customMessages = array(
            'edit_name.required'      => 'The name field is required.',
            'edit_address.required'   => 'The address field is required.',
            'edit_gender.required'    => 'Gender is required'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if($request -> edit_password != null ){
            $rules = array(
                'edit_password' => 'confirmed|min:8',
                'edit_password_confirmation' => 'required'
            );
    
            $customMessages = array(
                'edit_password.confirmed' => 'Password and confirmation password not match.',
                'edit_password.min'       => 'The password must be at least 8 characters.',
                'edit_password_confirmation.required' => 'The password confirmation field is required.'
            );
    
            $error = Validator::make($request->all(), $rules, $customMessages);
    
            if ($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
            DB::table('users')->where('id',$request->edit_id)->update([
                'name'       => $request -> edit_name,
                'address'    => $request -> edit_address,
                'gender'     => $request -> edit_gender,
                'password'   => bcrypt($request -> edit_password),
                'status'     => $request -> edit_status,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
        else {
            DB::table('users')->where('id',$request->edit_id)->update([
                'name'       => $request -> edit_name,
                'address'    => $request -> edit_address,
                'gender'     => $request -> edit_gender,
                'status'     => $request -> edit_status,
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
        
        return response()->json(['success' => 'data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $photo = DB::table('users')
        //              ->where('id',$id)
        //              ->value('photo');
        // File::delete('display_picture/'.$photo);
        DB::table('users')->where('id',$id)->delete();
        return back();
    }

    public function userProfile()
    {
        $userProfile = DB::table('users')
                    ->where('id', '=', Auth::user()->id)
                    ->get();
        return view('users.profile',['data_user_profile' => $userProfile]);
    }

    public function changePassword(Request $request)
    {
        $rules = array(
            'edit_old_password'               => 'required',
            'edit_new_password'               => 'required|confirmed|min:8',
            'edit_new_password_confirmation'  => 'required'
        );

        $customMessages = array(
            'edit_old_password.required'     => 'The old password field is required.',
            'edit_new_password.required'     => 'The new password field is required.',
            'edit_new_password.confirmed'    => 'Password and confirmation password not match.',
            'edit_new_password.min'          => 'The password must be at least 8 characters.',
            'edit_new_password_confirmation.required' => 'The password confirmation field is required.'
        );

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if (!(Hash::check($request->edit_old_password, Auth::user()->password))) {
            return response()->json(['notmatch' => 'data']);
        }

        if(strcmp($request->edit_old_password, $request->edit_new_password) == 0){
            return response()->json(['matchold' => 'data']);
        }

        DB::table('users')->where('id',Auth::user()->id)->update([
            'password'   => bcrypt($request -> edit_new_password),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return response()->json(['success' => 'data']);
    }
}
