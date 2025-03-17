<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Setting;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\NewUserRegistered;
use App\Events\PasswordChangeEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(){
        $users = User::where("role", "<>" , "1")->get();
        // return $users;
        if(!Gate::allows('isAdmin')){
            return abort(403, "un-authorized access");
        }
        return view('admin.users', compact("users"));
    }

    // this function will get all the users except admin of role == 1 
    public function getAllUsers(){
        $users = User::where('role' , '<>', '1')->get();
        // $dataTable = [];
        $data = [];
        foreach($users as $user){
            $user->role = $user->role == 0 ? "Author" : "Admin";
            $user->picture = $user->picture == 
                "profile" ? "<img width='50px' height='50px' src='".asset('images/profile-avatar.jpeg')."' />" : "<img width='50px' height='50px' src='".asset('storage/'.$user->picture)."' />";
            $data[] = $user; 
        }
        $dataTable["data"] = $data;
        return response()->json($dataTable);
    }

    // edit user 
    public function editUser($id){
        $user = User::findOrFail($id);
        return view("admin.edit-user", compact("user"));
    }
    
    // edit store user 
    public function saveUpdateUser(Request $request, $id){
        Gate::authorize('isAdmin');
        $request->validate([
            "username" => "required", 
            "fullname" => "required", 
            "email" => "required", 
        ]);
        $user = User::findOrFail($id);
        $path = $user->picture;
        if($request->hasFile('picture')){
            $existingPath = storage_path('app/public/' . $path);
            if(file_exists($existingPath)) {
                @unlink($existingPath);
                $path = $request->file("picture")->store("images", "public");
            }
        }
        $update = $user->update([
            "username" => $request->username, 
            "fullname" => $request->fullname, 
            "email" => $request->email, 
            "picture" => $path, 
        ]);        
        if($update){
            return back()->with('user_status' , "User Update Sucesffully");
        }
    }

    // delete user 
    public function delete($id){
        $user = User::findOrFail($id);
        $path = storage_path("app/public/".$user->picture);
        // return $path;
        if(file_exists($path)){
            unlink($path);
        }
        if($user->delete()){
            return back()->with('delete_status', 'User Delete successfully');
        }
    }

    // this function will add the new user 
    public function adminAddUser(Request $request){
        $request->validate([
            "fullname" => "required",
            "username" => "required",
            "password" => "required",
            "picture" => "required|mimes:png,jpg,jpeg",
            "email" => "required|email|unique:users,email",
        ]);
        $path = $request->file('picture')->store('images', 'public');
        $store = User::create([
            "username" => $request->username,
            "email" => $request->email,
            "fullname" => $request->fullname,
            "role" => 0, 
            "password" => $request->password, 
            "picture" => $path
        ]);
        return back()->with("save_status", "User added successfully.");
    }

    public function register_user(Request $request){
        $request->validate([
            "email" => "required|unique:users",
            "username" => "required|min:3|max:20",
            "first_name" => "required",
            "last_name" => "required",
            "password" => "required|min:6|max:15|confirmed:confirmed_password"
        ]);
        $user_data = [];
        $user_data["email"] = $request->input('email');
        $user_data["username"] = $request->input('username');
        $user_data["fullname"] = $request->input('first_name') . " " . $request->input('last_name');
        $user_data["password"] = $request->input('password');
        $user_store = User::create($user_data);
        if($user_store){
            event(new NewUserRegistered($user_store));
            return redirect()->route('Login');
        }
        return abort(403);
    }

    public function login(Request $request){
        $credendials = $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required"
        ]);
        
        if(Auth::attempt(["email" => $request->email, "password" => $request->password])){
            $loggin_data = User::where("email", $credendials["email"])->get(['username', 'picture']);
            // Get the panel name and the picture logo 
            $panel_name = Setting::get()[0]->panel_name;
            $logo = Setting::get()[0]->logo;
            $username = $loggin_data[0]->username;
            $picture = $loggin_data[0]->picture;
            $request->session()->put('username', $username);
            $request->session()->put('picture', $picture);
            $request->session()->put('logo', $logo);
            $request->session()->put('panel_name', $panel_name);
            $request->session()->regenerate();
            return redirect()->route('Dashboard')->with('loginSuccessfully', 'Logged In Successfully');
        }
        return redirect()->back()->withErrors(["Please Enter valid credentials"]);
    }

    public function viewUserData(){
        $user_data = User::whereUsername(Auth::user()->username)->withCount("posts")
                    ->get();
        // return $user_data;
        $user_id = $user_data[0]->id;
        $username = $user_data[0]->username;
        $email = $user_data[0]->email;
        $picture = $user_data[0]->picture;
        $full_name = $user_data[0]->fullname;
        $role = $user_data[0]->role;
        $posts_count = $user_data[0]->posts_count;
        $explode = explode(" ", $full_name);
        if(sizeof($explode) == 2){
            $first_name = explode(" ", $full_name)[0];
            $last_name = explode(" ", $full_name)[1];
        }else{
            $first_name = explode(" ", $full_name)[0];
            $last_name = "";
            for($i = 1; $i < sizeof($explode); $i++){
                $last_name .= $explode[$i] . " "; 
            }
            $last_name = trim($last_name);
        }
        $view_profile_data = ["user_id" => $user_id,"username" => $username, "email" =>$email, "first_name" => $first_name, "last_name" => $last_name, "picture" => $picture, 'role' => $role, "posts_count" => $posts_count];
        return view('admin.profile', ["user_data" => $view_profile_data]);
    }

    public function updateProfile(Request $request, $user_id){ 
        // return $request->all();
        $user = User::find($user_id);
       $request->validate([
            "email" => ["required", Rule::unique('users')->ignore($user->id)],
            "username" => ["required", Rule::unique('users')->ignore($user->id)],
            "first_name" => "required",
            "last_name" => "required",
       ]);
        $user->username = $request->username;
        $user->fullname = $request->first_name . " " . $request->last_name;
        $user->email = $request->email;
        if($user->save()){
            return redirect()->route('Profile')->with('updated', 'Profile updated successfully');
        }
    }

    public function changePassword(Request $request, $user_id){
        $user = User::findOrFail($user_id);
        $request->validate([
            "existing_password" => ["required", function ($attribute, $value, $fail) use ($user) {
                if (!empty($value) && !Hash::check($value, $user->password)) {
                    $fail("The old password is incorrect.");
                }}],
                "new_password" => ["required","min:6","max:15", "confirmed:confirmed_password"],
            ]);
        $user->password = $request->new_password;
        if($user->save()){
            event(new PasswordChangeEvent($user));
            return redirect()->route('Profile')->with('updated', 'Password changed successfully');
        }

    }
    
    public function changePicture(Request $request, $user_id){
        $request->validate(["picture" => "required"]);
        $user = User::find($user_id);
        $path = $user->picture;
        if($request->hasFile('picture')){
            $ext = $request->file('picture')->extension();
            $old_img = public_path("storage/".$user->picture);
            if(file_exists($old_img)){
                @unlink($old_img);
                $path = $request->file('picture')->store('images', 'public');
            }else{
                $path = $request->file('picture')->store('images', 'public');
            }
            $user->picture = $path;
            if($user->save()){
                event(new PasswordChangeEvent($user));
                return redirect()->route('Profile')->with('updated', 'Picture changed successfully');
            }
        }
    }


    public function summary(){
        $summary = [];
        $summary["total_post"] = Post::where("user_id", "=" ,Auth::id())->count();
        $summary["total_views"] = Post::where("user_id", Auth::id())->sum("total_views");
        $summary["total_comments"] = Post::where("user_id", Auth::id())->sum("total_comments");
        $summary["total_subscribers"] = Subscriber::all()->count();
        // return $summary;
        return view('admin.dashboard', compact("summary"));
    }

    public function logOut(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('Login')->with(['logoutMsg' => 'Logout Successfully.']);
    }
}
