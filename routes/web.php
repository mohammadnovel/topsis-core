<?php

use App\Http\Controllers\AlternativeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\CriteriaDetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 
Route::get('/', function () {
    return redirect()->route('login');
})->name('/');

Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () { 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// criteria
	Route::get('/criterias', [CriteriaController::class,'index'])->name('criteria.index');
	Route::get('/criteria/get-list', [CriteriaController::class,'getCriteriaList']);
	Route::get('/criteria/create', [CriteriaController::class,'create']);
	Route::post('/criteria/create', [CriteriaController::class,'store'])->name('create-criteria');
	Route::get('/criteria/{id}', [CriteriaController::class,'edit']);
	Route::post('/criteria/update', [CriteriaController::class,'update']);
	Route::get('/criteria/delete/{id}', [CriteriaController::class,'delete']);
	Route::post('/criteria-upload', [CriteriaController::class, 'importCriteria'])->name('upload-criteria');

	// alternative
	Route::get('/alternatives', [AlternativeController::class,'index'])->name('alternative.index');
	Route::get('/alternative/get-list', [AlternativeController::class,'getAlternativeList']);
	Route::get('/alternative/create', [AlternativeController::class,'create']);
	Route::post('/alternative/create', [AlternativeController::class,'store'])->name('create-alternative');
	Route::get('/alternative/{id}', [AlternativeController::class,'edit']);
	Route::post('/alternative/update', [AlternativeController::class,'update']);
	Route::get('/alternative/delete/{id}', [AlternativeController::class,'delete']);
	Route::post('/alternative-upload', [AlternativeController::class, 'import'])->name('upload-alternative');

	// transaction
	Route::get('/transactions', [TransactionController::class,'index'])->name('transaction.index');
	Route::get('/transaction/get-list', [TransactionController::class,'gettransactionList']);
	Route::get('/transaction/create', [TransactionController::class,'create']);
	Route::post('/transaction/create', [TransactionController::class,'store'])->name('store-transaction');
	Route::get('/transaction/{id}', [TransactionController::class,'edit']);
	Route::put('/transaction/update/{id}', [TransactionController::class, 'update']);

	Route::get('/transaction/delete/{id}', [TransactionController::class,'delete']);
	Route::post('/transaction-upload', [TransactionController::class, 'upload'])->name('upload-transaction');

	Route::post('/rank-serverside', [TransactionController::class, 'rankServerSide'])->name('transaction.rank-serverside');

	Route::prefix('criteria-detail')->group(function () {
		Route::get('/{criteriaId}', [CriteriaDetailController::class, 'index'])->name('criteria-detail.index');
		Route::get('/list/{criteriaId}', [CriteriaDetailController::class, 'getCriteriaList'])->name('criteria-detail.list');
		Route::post('/store/{criteriaId}', [CriteriaDetailController::class, 'store'])->name('criteria-detail.store');
		Route::get('/edit/{id}', [CriteriaDetailController::class, 'edit'])->name('criteria-detail.edit');
		Route::put('/update/{id}', [CriteriaDetailController::class, 'update'])->name('criteria-detail.update');
		Route::delete('/delete/{id}', [CriteriaDetailController::class, 'destroy'])->name('criteria-detail.destroy');
	});


	// dashboard route  
	Route::get('/dashboard', function () { 
		return view('pages.dashboard'); 
	})->name('dashboard');

	// calcluate topsis
	Route::get('/calculate-topsis', [TransactionController::class, 'topsis'])->name('calculate-topsis');
	Route::post('/upload-topsis', [TransactionController::class, 'upload'])->name('upload-topsis');

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


	// permission examples
    Route::get('/permission-example', function () {
    	return view('permission-example'); 
    });
    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	Route::get('/table-datatable-edit', function () { 
		return view('pages.datatable-editable'); 
	});

    // Themekit demo pages
	Route::get('/calendar', function () { return view('pages.calendar'); });
	Route::get('/charts-amcharts', function () { return view('pages.charts-amcharts'); });
	Route::get('/charts-chartist', function () { return view('pages.charts-chartist'); });
	Route::get('/charts-flot', function () { return view('pages.charts-flot'); });
	Route::get('/charts-knob', function () { return view('pages.charts-knob'); });
	Route::get('/forgot-password', function () { return view('pages.forgot-password'); });
	Route::get('/form-addon', function () { return view('pages.form-addon'); });
	Route::get('/form-advance', function () { return view('pages.form-advance'); });
	Route::get('/form-components', function () { return view('pages.form-components'); });
	Route::get('/form-picker', function () { return view('pages.form-picker'); });
	Route::get('/invoice', function () { return view('pages.invoice'); });
	Route::get('/layout-edit-item', function () { return view('pages.layout-edit-item'); });
	Route::get('/layouts', function () { return view('pages.layouts'); });

	Route::get('/navbar', function () { return view('pages.navbar'); });
	Route::get('/profile', function () { return view('pages.profile'); });
	Route::get('/project', function () { return view('pages.project'); });
	Route::get('/view', function () { return view('pages.view'); });

	Route::get('/table-bootstrap', function () { return view('pages.table-bootstrap'); });
	Route::get('/table-datatable', function () { return view('pages.table-datatable'); });
	Route::get('/taskboard', function () { return view('pages.taskboard'); });
	Route::get('/widget-chart', function () { return view('pages.widget-chart'); });
	Route::get('/widget-data', function () { return view('pages.widget-data'); });
	Route::get('/widget-statistic', function () { return view('pages.widget-statistic'); });
	Route::get('/widgets', function () { return view('pages.widgets'); });

	// themekit ui pages
	Route::get('/alerts', function () { return view('pages.ui.alerts'); });
	Route::get('/badges', function () { return view('pages.ui.badges'); });
	Route::get('/buttons', function () { return view('pages.ui.buttons'); });
	Route::get('/cards', function () { return view('pages.ui.cards'); });
	Route::get('/carousel', function () { return view('pages.ui.carousel'); });
	Route::get('/icons', function () { return view('pages.ui.icons'); });
	Route::get('/modals', function () { return view('pages.ui.modals'); });
	Route::get('/navigation', function () { return view('pages.ui.navigation'); });
	Route::get('/notifications', function () { return view('pages.ui.notifications'); });
	Route::get('/range-slider', function () { return view('pages.ui.range-slider'); });
	Route::get('/rating', function () { return view('pages.ui.rating'); });
	Route::get('/session-timeout', function () { return view('pages.ui.session-timeout'); });
	Route::get('/pricing', function () { return view('pages.pricing'); });
});


Route::get('/register', function () { return view('pages.register'); });
Route::get('/login-1', function () { return view('pages.login'); });
