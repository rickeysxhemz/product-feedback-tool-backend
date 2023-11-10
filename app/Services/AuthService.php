<?php

namespace App\Services;

use App\Libs\Response\GlobalApiResponseCodeBook;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Exception;
use App\Helper\Helper;

class AuthService extends BaseService
{
    public function adminRegister($request)
    {     
        try{
            DB::beginTransaction();
            $user = new User(); 
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->profile_photo_path = $request->profile_photo_path;
            $user->password = Hash::make($request->password);
            $user->save();
            $user_role = Role::findByName('admin');
            $user_role->users()->attach($user->id);
            DB::commit();
            return $user;
        }catch(Exception $e){
            DB::rollback();
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AuthService: register", $error);
            return false;
        }
    }
    public function userRegister($request)
    {     
        try{
            DB::beginTransaction();
            $user = new User(); 
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->profile_photo_path = $request->profile_photo_path;
            $user->password = Hash::make($request->password);
            $user->save();
            $user_role = Role::findByName('user');
            $user_role->users()->attach($user->id);
            DB::commit();
            return $user;
        }catch(Exception $e){
            DB::rollback();
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AuthService: register", $error);
            return false;
        }
    }
    public function login($request)
    {
        try {
            
            $credentials = $request->only('email', 'password');

            $user = User::where('email', '=', $credentials['email'])
                ->first();
            // if(isset($user->email_verified_at) && $user->email_verified_at !== null){
                if (
                    Hash::check($credentials['password'], isset($user->password) ? $user->password : null)
                    &&
                    $token = $this->guard()->attempt($credentials)
                ) {
                    
                    $roles = Auth::user()->roles->pluck('name');
                    $data = Auth::user()->toArray();
                    unset($data['roles']);
    
                    $data = [
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'expires_in' => $this->guard()->factory()->getTTL() * 60,
                        'user' => Auth::user()->only('id', 'name', 'email', 'phone_no','profile_image'),
                        'roles' => $roles,
                    ];
                    return Helper::returnRecord(GlobalApiResponseCodeBook::SUCCESS['outcomeCode'], $data);
                }
                // return Helper::returnRecord(GlobalApiResponseCodeBook::INVALID_CREDENTIALS['outcomeCode'], []);
            // }
            return Helper::returnRecord(GlobalApiResponseCodeBook::INVALID_CREDENTIALS['outcomeCode'], []);
        } catch (Exception $e) {
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AuthService: login", $error);
            return false;
        }
    
    }
    public function logout()
    {
        try {
            Auth::logout();
            return true;
        } catch (Exception $e) {

            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AuthService: logout", $error);
            return false;
        }
    }
       /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}