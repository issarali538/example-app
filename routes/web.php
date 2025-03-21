<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\UserLogginMiddleware;
use App\Http\Controllers\ApproveCommentController;
use App\Http\Middleware\UserloggedInAlreadyMiddlware;

//admin
Route::prefix('admin')->group(function(){
    Route::view('/', 'admin.login')->name("Login")->middleware([UserloggedInAlreadyMiddlware::class]);
    Route::post('/login', [UserController::class,'login'])->name("CheckLogin");
    Route::get('/logout', [UserController::class,'logOut'])->name("Logout");
    Route::view('/register', 'admin.register')->name("Register");
    Route::post('/register-user', [UserController::class,"register_user"])->name("RegisterUser");
    Route::get('/profile', [UserController::class, "viewUserData"])->name("Profile")
            ->middleware([UserLogginMiddleware::class]);
    Route::post('/update-profile/{id}', [UserController::class, "updateProfile"])->name("UpdateProfile");
    Route::post('/change-password/{id}', [UserController::class, "changePassword"])->name("ChangePassword");
    Route::post('/change-picture/{id}', [UserController::class, "changePicture"])->name("ChangePicture");
    Route::get('/dashboard', [UserController::class,'summary'])->name('Dashboard')->middleware([UserLogginMiddleware::class]);
//     post model routes 
    Route::get('/posts', [PostController::class, "index"])->name('Posts')
            ->middleware([UserLogginMiddleware::class]);
    Route::view('/add-post', 'admin.add-post')->name('AddPost')
                ->middleware([UserLogginMiddleware::class]);
    Route::post('/save-new-post', [PostController::class, "saveNewPost"])
            ->name('SaveNewPost')->middleware([UserLogginMiddleware::class]);
    Route::get('/view-post/{id}', [PostController::class, "viewPost"])->name('ViewPost')
            ->middleware([UserLogginMiddleware::class]);
    Route::get('/edit-post/{id}', [PostController::class, "editPost"])->name('EditPost')
            ->middleware([UserLogginMiddleware::class]);
    Route::post('/update-post/{id}', [PostController::class, "updatePost"])->name('UpdatePost')
            ->middleware([UserLogginMiddleware::class]);
    Route::get('/delete-post/{id}', [PostController::class, "postDestroy"])->name('DeletePost')
            ->middleware([UserLogginMiddleware::class]);
        // user model routes 
    Route::get('/users', [UserController::class, "index"])->name('Users')
                ->middleware([UserLogginMiddleware::class]);
    Route::view('/add-user', 'admin.add-user')->name('AddUser')->middleware([UserLogginMiddleware::class]);
    Route::get('/edit-user/{id}', [UserController::class, "editUser"])->name('editUser')->middleware([UserLogginMiddleware::class]);
    Route::get('/all-users', [UserController::class, "getAllUsers"])->name('getAllUsers')
                ->middleware([UserLogginMiddleware::class]);
    Route::post('/admin-add-user', [UserController::class, "adminAddUser"])->name('addUser')
                ->middleware([UserLogginMiddleware::class]);
    Route::view('/register-new-user','admin.manual-add-user')->name('manualAddUser')->middleware([UserLogginMiddleware::class]);
    Route::get('/delete-user/{id}',[UserController::class, "delete"])->name('deleteUser')->middleware([UserLogginMiddleware::class]);
    Route::post('/store-update-user/{id}',[UserController::class, "saveUpdateUser"])->name('saveUpdateUser')->middleware([UserLogginMiddleware::class]);
                //     comments model routes 
     Route::get('/comments', [CommentController::class, "index"])->name('Comments')->middleware([UserLogginMiddleware::class]);
     Route::post('/approve-comment/{id}', ApproveCommentController::class)->name('approveComment')->middleware([UserLogginMiddleware::class]);
     Route::get('/delete-comment/{id}', [CommentController::class, "destroy"])->name('deleteComment')->middleware([UserLogginMiddleware::class]);
     Route::get('/post-comments', [CommentController::class, "getComments"])->name('getComments');
                // category model routes 
      Route::view('/categories', 'admin.categories')->name('Categories')
                ->middleware([UserLogginMiddleware::class]);
      Route::get('/all-categories', [CategoryController::class, 'index'])->name('GetCategories')
                ->middleware([UserLogginMiddleware::class]);
                Route::post('/add-category', [CategoryController::class, 'addCategory'])->name('AddCategory')
                ->middleware([UserLogginMiddleware::class]);
       Route::get('/edit-category/{category_id}', [CategoryController::class, 'editCategory'])->name('editCategory')
                ->middleware([UserLogginMiddleware::class]);
        Route::post('/store-updated-category/{category_id}', [CategoryController::class, 'updateCategory'])->name('storeCategory')
                ->middleware([UserLogginMiddleware::class]);
        Route::post('/delete-category/{category_id}', [CategoryController::class, 'deletCategory'])->name('deletCategory')
                ->middleware([UserLogginMiddleware::class]);
        Route::get('/get-categories', [CategoryController::class, "selectCategory"])->name('GetAllCategories')
                ->middleware([UserLogginMiddleware::class]);
                // reply model routes 
        Route::post("reply/{comment_id}", [ReplyController::class, 'reply'])->name('Reply')
                ->middleware([UserLogginMiddleware::class]);
        Route::post("send-reply", [ReplyController::class, 'reply'])->name('commentReply')
                ->middleware([UserLogginMiddleware::class]);
        Route::view('/replies', "admin.reply")->name('Replies')->middleware([UserLogginMiddleware::class]);
        Route::get('/settings', [SettingController::class, "index"])->name('Settings')->middleware([UserLogginMiddleware::class]);
        Route::post('/save-settings', [SettingController::class, "saveSettings"])->name('saveSettings')->middleware([UserLogginMiddleware::class]);
});


// test routes 
Route::get('r', function(){
        // return DB::table('comments')->latest('created_at')->first()->post_id;
         DB::table("comments")->insert([
                'comment' => "comment of post 1",
                'comment_status' => 1,
                'post_id' => 1,
                'subscriber_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
});