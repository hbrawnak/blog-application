<?php
/**
 * Created by PhpStorm.
 * User: Habib
 * Date: 09-Apr-16
 * Time: 08:21 PM
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function getAdminDashboard()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(5);
        //$posts = Post::orderBy('created_at', 'desc')->get(); //it's without pagination.
        return view('admin.home', ['users' => $users]);
    }

    public function postAdminSignIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'user_status' => $request['user_status'], 'user_type' => $request['user_type']]))
        {
            if($request['user_status'] == '0' && $request['user_type'] == '1')
            {
                return redirect()->route('adminDashboard');
            }
            else
            {
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function getActiveUser($user_id)
    {
        DB::table('users')
            ->where('id', $user_id)
            ->update(['user_status' => 1]);

        return redirect()->route('adminDashboard')->with(['message' => 'User inactivated successfully!']);
    }

    public function getInactiveUser($user_id)
    {
        DB::table('users')
            ->where('id', $user_id)
            ->update(['user_status' => 0]);
        return redirect()->route('adminDashboard')->with(['message' => 'User activated successfully!']);
    }

    public function getDeleteUser($user_id)
    {
        DB::table('posts')
            ->where('user_id', $user_id)
            ->delete();
        DB::table('users')
            ->where('id', $user_id)
            ->delete();
        return redirect()->route('adminDashboard')->with(['message' => 'User has deleted successfully!']);
    }

    public function getUserData($user_id)
    {
        $posts = DB::table('posts')->where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(5);
        $users = DB::table('users')->where('id', $user_id)->get();
        return view('admin.userpost', ['posts' => $posts], ['users' => $users]);
    }

    public function postUserData(Request $request, $user_id)
    {
        $this->validate($request, [
            'password' => 'required|max:10|min:4|confirmed'
        ]);

        //print_r($request['password']);
        //die();

        $user = DB::table('users')->where('id', $user_id);
        if($request['password'] !== '') {
            $new_pass = bcrypt($request['password']);
            $user->password = $new_pass;
            DB::table('users')->where('id', $user_id)->update(['password' => $new_pass]);
            return redirect()->back()->with(['message' => 'User profile has updated!']);
        }
        else
        {
            return redirect()->back()->with(['message' => 'User profile did not update!']);
        }
    }

    public function getAdminLogin()
    {
        return view('admin.login');
    }

    public function getAdminLogout()
    {
        Auth::Logout();
        return redirect()->route('adminLogin');
    }
} 