<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Subscriber;
use App\Models\Reply;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    public function replaceUploadFile(Request $request, $inputFile ,$old_path, $new_path){
        $old_img = public_path("storage/".$old_path);
        @unlink($old_path);
        $path = $request->file($inputFile)->store($new_path, "public");
        return $path; 
    }
    
    public function tagsJson($tagsString){
        $tag_json = [];
        if(is_array(explode(',', $tagsString))){
            $tag_explode = explode(',', $tagsString);
            foreach($tag_explode as $tag){
                if(is_array(explode(' ', $tag))){
                        $tag_json_key = Str::lower(implode("_",explode(' ', $tag)));
                        $tag_json[$tag_json_key] = $tag;
                    }else{
                        $tag_json[Str::lower($tag)] = $tag;
                    }
            }
        }else{
            $tag_json_key = is_array(explode(" ",$tagsString)) ? implode("_",explode(" ",$tagsString)) : Str::lower($tagsString); 
            $tag_json[$tag_json_key] = $tagsString;
        }
        return json_encode($tag_json);
    }
    
    public function index(){
        $role = Auth::user()->role;
        $posts = $role == 1 ? 
                           Post::with('user')->with("category")->get() : 
                           Post::whereUserId(Auth::user()->id)->with('user')->get();
        // return $posts;
        return view('admin.posts', ["posts" => $posts]);
    }

    public function saveNewPost(Request $request){
        // return var_dump($request->tags);
        $request->validate([
            "post_title" => ["required", "min:10"],
            "tags" => ["required"],
            "post_desc" => ["required", "min:10"],
            "category" => ["required"],
            "post_pic" => ["required", "extensions:jpg,png,jpeg"],
        ]);
        $path = $request->file("post_pic")->store('uploads', 'public');
        $post_title = $request->post_title;
        $post_desc = $request->post_desc;
        $category = $request->category;
        $tags = $this->tagsJson($request->tags);
        $save_data = [
            "title" => $post_title,
            "desc" => $post_desc,
            "picture" => $path,
            "tags" => $tags,
            "category_id" => $category,
            "user_id" => Auth::id()
        ];

        if(Post::create($save_data)){
            return redirect()->route('Posts')->with('post_status', "Post Save Successfully");
        }
    }

    public function viewPost($post_id){
        $post_data = Post::with(
                        ["user","comments", "comments.subscriber", "comments.replies"]
                            )->withCount("comments")->findOrFail($post_id);
        // return $post_data;
        return view('admin.view-post', compact('post_data'));
    }

    public function editPost($post_id){
        $post_data = Post::with("user")->find($post_id);
        if(!$post_data){
            return abort(403, "Un-Authorized Access");
        }
        if(!Gate::allows("update",$post_data->user_id)){
            return abort(403, "Un-Authorized Access");
        }
        // return $post_data;
        $view_data = [];
        $view_data['id'] = $post_data->id;
        $view_data['title'] = $post_data->title;
        $view_data['desc'] = $post_data->desc;
        $view_data['picture'] = $post_data->picture;
        $view_data['tags'] = json_decode($post_data->tags);
        // return $view_data;
        return view('admin.edit-post', ["post_data" => $view_data]);
    }

    public function updatePost(Request $request, $post_id){
        // return $request->all();
        $post_data = Post::find($post_id);
        if(!$post_data){
            return abort(204, 'Un-Authorized Access');
        }
        $request->validate([
            "post_title" => ["min:10"],
            "post_desc" => ["min:10"],
            "tags" => ["required"],
            "category" => ["required"],
            "post_pic" => ["extensions:jpg,png,jpeg"],
        ]);
        $post_data->title = $request->post_title;
        $post_data->desc = $request->desc;
        $post_data->category_id = $request->category;
        $post_data->tags = $this->tagsJson($request->tags);
        // change file code 
        if($request->hasFile('post_pic')){
            $post_data->picture = $this->replaceUploadFile($request,"post_pic", $post_data->picture, "uploads/");
        }
        if($post_data->save()){
            return redirect()->route('ViewPost', $post_data->id)->with('updated', 'Post Updated successfully');
        }
    }

    public function postDestroy($post_id){
        $post = Post::find($post_id);
        if(!$post){
            return abort(403, 'Un-Authorized Access');
        }
        // Gate::authorize('delete', $post);
        if(!Gate::allows('delete', $post->user_id)){
            return abort(403, 'Un-Authorized Access');
        }
        $thumnail_path = storage_path("app/public/" . $post->picture);
        if(file_exists($thumnail_path)){
            @unlink($thumnail_path);
        }
        $post->delete();
        return redirect()->route('Posts')->with('post_status', "Post Deleted Successfully");
    }
}
