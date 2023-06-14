<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HouseHoldController;
use App\Http\Controllers\HouseHoldAdressController;
use App\Http\Controllers\HouseHoldMembershipController;
use App\Http\Controllers\HouseholdMemberTypeController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\AdministrativeHierachyController;
use App\Http\Controllers\HouseHoldMuting;
use App\Http\Controllers\HouseHoldMutingController;
use App\Http\Controllers\PersonContactsController;
use App\Http\Controllers\PersonIdentificationTypeController;
use App\Http\Controllers\PersonNextOfKinController;
use App\Http\Controllers\UserController;


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

// Register endpoint
Route::post('register', [AuthController::class, 'register']);

// Login
Route::post('login', [AuthController::class, 'login']);

//HouseHold API endpoints
Route::post('/households', [HouseHoldController::class, 'saveHouseHoldAndAtleastOnePerson']);
Route::get('/households/{householdId}/members', [HouseHoldController::class, 'getHouseholdMembers']);
Route::get('/households', [HouseHoldController::class, 'getAllHouseholds']);
Route::get('/households/approved/{isApproved}', [HouseHoldController::class, 'getApprovedHouseholds']);
Route::post('/households/migration', [HouseHoldController::class, 'handleHouseHoldMigration']);
Route::get('/households/migration', [HouseHoldController::class, 'getAllMigratedHouseholds']);
Route::get('/households/migration/pending', [HouseHoldController::class, 'getAllPendingMigratedHouseholds']);

//muting a household
Route::post('/households/mute', [HouseHoldMutingController::class, 'searchAndMuteAHouseHold']);
Route::get('/households/mute', [HouseHoldMutingController::class, 'getAllMutedHouseHolds']);
Route::post('/households/mute/approve', [HouseHoldMutingController::class, 'approveHouseHoldMuting']);


//HouseHoldAdress API endpoints
Route::resource('householdadress', HouseHoldAdressController::class);
Route::get('/householdadress/search/{householdTypeId}', [HouseHoldAdressController::class, 'search']);

//HouseHoldMembership API endpoints
Route::resource('householdmembership', HouseHoldMembershipController::class);
Route::get('/householdmembership/search/{household_person_details_id}', [HouseHoldMembershipController::class, 'search']);

//HouseholdMemberType API endpoints
Route::resource('householdmembertype', HouseholdMemberTypeController::class);
Route::get('/householdmembertype/search/{household_membership_name}', [HouseholdMemberTypeController::class, 'search']);

// AdministrativeHierachy model CRUD endpoints
Route::post('administrativehierachy', [AdministrativeHierachyController::class, 'store']);
Route::get('administrativehierachy', [AdministrativeHierachyController::class, 'index']);
Route::get('administrativehierachy/{administrativeHierachy}', [AdministrativeHierachyController::class, 'show']);
Route::put('administrativehierachy/{administrativeHierachy}', [AdministrativeHierachyController::class, 'update']);
Route::patch('administrativehierachy/{administrativeHierachy}', [AdministrativeHierachyController::class, 'update']);
Route::delete('administrativehierachy/{administrativeHierachy}', [AdministrativeHierachyController::class, 'destroy']);

// PersonContacts model CRUD endpoints
Route::resource('personcontacts', PersonContactsController::class);


// PersonIdentificationType model CRUD endpoints
Route::resource('personidentificationtype', PersonIdentificationTypeController::class);


// PersonNextOfKin model CRUD endpoints
Route::resource('personnextofkin', PersonNextOfKinController::class);

//Residence model CRUD endpoints
// Create
Route::post('residence', [ResidenceController::class, 'store']);
Route::get('residence', [ResidenceController::class, 'index']);
Route::get('residence/{id}', [ResidenceController::class, 'show']);
Route::put('residence/{id}', [ResidenceController::class, 'update']);
Route::patch('residence/{id}', [ResidenceController::class, 'update']);
Route::delete('residence/{id}', [ResidenceController::class, 'destroy']);

// Personnext model CRUD endpoints
Route::resource('user', UserController::class);




Route::group(['middleware'=>['auth:sanctum']], function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout']);
});
