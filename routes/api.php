<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix("users")->group(function(){
    Route::post("createUser", "App\Http\Controllers\UserController@createRegularUser");
    Route::post("login", "App\Http\Controllers\UserController@userLogin");

    Route::middleware("jwt.auth")->group(function(){
        //Admin functionality
        Route::post("createAdminUser", "App\Http\Controllers\UserController@createAdminUser")
            ->middleware("can:createAdminUsers");
        Route::post("promoteRegularUserToAdmin/{email}", "App\Http\Controllers\UserController@promoteRegularUserToAdmin")
            ->middleware(["can:createAdminUsers"]);
            Route::post("getUserByEmail/{email}", "App\Http\Controllers\UserController@getUserByEmail")
                ->middleware(["can:createAdminUsers"]);

        Route::post("deleteUserByEmail/{email}", "App\Http\Controllers\UserController@deleteUserByEmail")
            ->middleware(["can:deleteUsers"]);

        Route::post("getUserById", "App\Http\Controllers\UserController@getUserById");
        //This is needed before updating password for user to enter old password then check if it tallies with the current password in the DB before updating it
        Route::post("deleteUserById", "App\Http\Controllers\UserController@deleteUserById");
        Route::post("oldPassword", "App\Http\Controllers\UserController@checkOldPasswordMatches");
        Route::post("updatePassword", "App\Http\Controllers\UserController@updateUserPassword");
    });
});

Route::prefix("api-keys")->group(function (){
    Route::middleware("auth:api")->group(function(){
        Route::post("createKey/{name}", "App\Http\Controllers\ApiKeyController@createApiKey");
    });
//    Route::post("activateKey", "App\Http\Controllers\ApiKeyController@activateApiKey")
//        ->middleware("can:modifyApiKeys");
//    Route::post("deactivateKey", "App\Http\Controllers\ApiKeyController@deactivateApiKey")
//        ->middleware("can:modifyApiKeys");
});
