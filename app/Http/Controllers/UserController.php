<?php
namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function postSignUp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|max:10|min:4'
        ]);

        $email = $request['email'];
        $first_name = $request['first_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;

        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');

    }

    public function postSignIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'user_status' => $request['user_status'], 'user_type' => $request['user_type']])) {
            if ($request['user_status'] == '0' && $request['user_type'] == '0') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home')->with(['errorMessage' => 'You have no permission to login']);
            }
        }
        return redirect()->route('home')->with(['errorMessage' => 'Email or Password does not match']);
    }

    public function userAccount()
    {
        $user_id = Auth::user()->id;
        //print_r($user_id);
        //die();
        $posts = DB::table('posts')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('account', ['posts' => $posts]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:120'
        ]);
        $user = Auth::user();
        $old_name = $user->first_name;
        $user->first_name = $request['first_name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->id . '.jpg';
        $old_filename = $old_name . '-' . $user->id . '.jpg';
        $update = false;
        if (Storage::disk('local')->has($old_filename)) {
            $old_file = Storage::disk('local')->get($old_filename);
            Storage::disk('local')->put($filename, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }

    public function getUserProfile($user_id)
    {
        $posts = DB::table('posts')->where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(5);
        $users = DB::table('users')->where('id', $user_id)->get();
        return view('profile', ['posts' => $posts], ['users' => $users]);
    }

    public function getChangePassword()
    {
        return view('password');
    }

    public function postUpdatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|max:10|min:4|confirmed'
        ]);

		
        //print_r($request['password']);
        //die();

        $user = Auth::user();
        if($request['password'] !== ''){
            $new_pass = bcrypt($request['password']);
            $user->password = $new_pass;
        }
        $user->update();
        return redirect()->route('account')->with(['message' => 'Your password has updated!']);
    }
}