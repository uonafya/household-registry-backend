<?php

use App\Http\Controllers\HouseHoldController;
use App\Http\Controllers\HouseHoldAddressController;
use App\Http\Controllers\HouseHoldMembershipController;
use App\Http\Controllers\HouseholdMemberTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//HouseHold API endpoints
Route::resource('household', HouseHoldController::class);
Route::get('/household/search/{household_name}', [HouseHoldController::class, 'search']);

//HouseHoldAddress API endpoints
Route::resource('HouseHoldAddress', HouseHoldAddressController::class);
Route::get('/HouseHoldAddress/search/{householdTypeId}', [HouseHoldAddressController::class, 'search']);

//HouseHoldMembership API endpoints
Route::resource('householdmembership', HouseHoldMembershipController::class);
Route::get('/householdmembership/search/{household_person_details_id}', [HouseHoldMembershipController::class, 'search']);

//HouseholdMemberType API endpoints
Route::resource('householdmembertype', HouseholdMemberTypeController::class);
Route::get('/householdmembertype/search/{household_membership_name}', [HouseholdMemberTypeController::class, 'search']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
