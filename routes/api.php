<?php

use App\Http\Controllers\HouseHoldController;
use App\Http\Controllers\HouseHoldAdressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//HouseHold API endpoints
Route::resource('household', HouseHoldController::class);
Route::get('/household/search/{household_name}', [HouseHoldController::class, 'search']);

//HouseHoldAdress API endpoints
Route::resource('householdadress', HouseHoldAdressController::class);
Route::get('/householdadress/search/{householdTypeId}', [HouseHoldAdressController::class, 'search']);

//HouseHoldMembership API endpoints
Route::resource('householdmembership', HouseHoldMembershipController::class);
Route::get('/householdmembership/search/{household_person_details_id}', [HouseHoldMembershipController::class, 'search']);

//HouseholdMemberType API endpoints
Route::resource('householdmembertype', HouseholdMemberTypeController::class);
Route::get('/householdmembertype/search/{household_membership_name}', [HouseholdMemberTypeController::class, 'search']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
