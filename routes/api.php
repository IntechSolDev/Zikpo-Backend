<?php


use App\Http\Controllers\Api\ExpertiseController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\QuestionCommentController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionLikeController;
use App\Http\Controllers\Api\ResponseCommentController;
use App\Http\Controllers\Api\ResponseController;
use App\Http\Controllers\Api\ResponseLikeController;
use App\Http\Controllers\Api\ResponseShareController;
use App\Http\Controllers\Api\QuestionShareController;
use App\Http\Controllers\Api\UserCoinStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TopicController;




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

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

//User Auth Api Route
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('forgot', [UserController::class, 'forgot']);
Route::post('confirm-code', [UserController::class, 'confirmCode']);
Route::post('reset', [UserController::class, 'reset']);
Route::post('change-password', [UserController::class, 'changePassword']); //Bear Token Needed
Route::post('edit', [UserController::class, 'edit']);
Route::post('verify', [UserController::class, 'verifyEmail']);
Route::get('details', [UserController::class, 'details']); //Bear Token Needed
Route::get('delete-user', [UserController::class, 'delete']); //Delete All user
Route::post('update-fcm', [UserController::class, 'updateFcmToken']);
Route::get('topics', [TopicController::class, 'getAllTopic']); //All Topic
Route::get('expertise', [ExpertiseController::class, 'getAllExpertise']); //All Expertise
Route::get('create-expertise/{title}', [ExpertiseController::class, 'createExpertise']); //Create Expertise
// Video
Route::get('videos-list/{id}', [QuestionController::class, 'getAllVideoByCircuit']); //All Video By Circuit


Route::group(['middleware' =>'auth:api'], function () {

// Home
    Route::get('home', [HomeController::class, 'getHomeData']); //All Topic Detail

// Topic
    Route::get('topic-detail/{id}', [TopicController::class, 'getDetailTopic']); //All Topic Detail

// Question
    Route::post('create-question', [QuestionController::class, 'addQuestion']); //Add Question
    Route::get('question-list', [QuestionController::class, 'getAllQuestion']); //All Question
    Route::get('view-question/{id}', [QuestionController::class, 'getDetailQuestion']); //View Question
    Route::post('like-question', [QuestionLikeController::class, 'addLikeQuestion']); //Like Question
    Route::post('comment-question', [QuestionCommentController::class, 'addCommentQuestion']); //Comment Question
    Route::post('share-question', [QuestionShareController::class, 'addShareQuestion']); //Share Question

// Response
    Route::post('create-response', [ResponseController::class, 'addResponse']); //Add Response
    Route::get('view-response/{id}', [ResponseController::class, 'getDetailResponse']); //View Response
    Route::post('like-response', [ResponseLikeController::class, 'addLikeResponse']); //Like Response
    Route::post('comment-response', [ResponseCommentController::class, 'addCommentResponse']); //Comment Response
    Route::post('share-response', [ResponseShareController::class, 'addShareResponse']); //Share Response

//Foryou
    Route::get('foryou', [HomeController::class, 'getForyouData']); //All Foryou Data

//Latest
    Route::get('latest', [HomeController::class, 'getLatestData']); //All Latest Data

//Trending
    Route::get('trending', [HomeController::class, 'getTrendingData']); //All Trending Data

//One Time Payment
    Route::post('payment',[PaymentController::class,'payment'])->name('stripe.post');
    Route::post('confirm-payment',[PaymentController::class,'paymentConfirmation']);
    Route::post('payment-intent',[PaymentController::class,'paymentIntent']);

//Coin Api
     Route::post('insert-coin',[UserCoinStatusController::class,'userUpdateCoin']);
     Route::post('coin-transfer',[UserCoinStatusController::class,'addCoinStatus']);
     Route::get('user-coin-status',[UserCoinStatusController::class,'userCoinStatus']);





});

