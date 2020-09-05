<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['auth:sanctum'], function () {
    Route::get('donation/totalDonations','API\DonationController@totalDonations');
    Route::resource('donation','API\DonationController');
});

Route::resource('donation','API\DonationController')->middleware('auth:sanctum');

//Requesting sanctum token
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return [
            'status' => 'fail',
            'message'=> 'The provided credentials are incorrect.'
        ];
    }
    $user->tokens()->delete();

    return [
        'status' => 'success',
        'user'=>$user,
        'token'=>$user->createToken($request->device_name)->plainTextToken
    ];
});

Route::post('/sanctum/logout', function (Request $request) {

    $user = User::where('email', $request->email)->first();
    $user->tokens()->delete();
    return [
        'status' => 'token deleted',
    ];
});

