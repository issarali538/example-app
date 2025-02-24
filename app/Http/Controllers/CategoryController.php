<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount('posts')->get();
        $tbl = "";
        foreach($categories as $category){
            if($category->id == 1){
                continue;
            }
            $tbl .= "<tr>";
            $tbl .= "<td>$category->id</td><td>$category->category_name</td><td>$category->posts_count</td><td><button class='btn btn-sm btn-primary' data-category='$category->id' id='editBtn'><i class='bi bi-pencil-fill'></i></button></td><td><button data-category='$category->id' class='btn btn-sm btn-primary' id='delBtn'><i class='bi bi-trash-fill'></i></button></td>";
            $tbl .= "</tr>";
        }    
        return $tbl;
    }


    public function selectCategory(){
        $catagories = Category::get(['id', 'category_name']);
        // return $catagories;
        $option = "";
        foreach($catagories as $category){
            $option .= "<option value='$category->id'>$category->category_name</option>";
        }
        return $option;
        // return view('admin.add-post', compact("catagories"));
    }
    
    
    public function addCategory(Request $request){
        $data = json_decode($request->getContent(), true); 
        $categoryName = $data['category'];
        $category = Category::create(['category_name' => $categoryName]);
        if($category){
            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully!',
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ],500);
        }
    }

    public function editCategory(string $id){
        $category = Category::find($id);
        if($category){
            return $category->category_name;
        }
    }

    public function updateCategory(Request $request, string $category_id){
        $category = Category::find($category_id);
        $category->category_name = $request->category;
        if($category->save()){
            return response()->json([
                "success" => true,
                "message" => "Category Updated Successfully"
            ]);
        }
    }
    
    public function deletCategory($category_id){
        $category = Category::find($category_id);
        if($category->destroy($category->id)){
            return response()->json([
                "success" => true,
                "message" => "Category Deleted Successfully"
            ]);
        }
    }
}
