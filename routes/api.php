    <?php

    use App\Http\Controllers\Auth\API\AuthController;
    use App\Http\Controllers\Backend\API\BranchController;
    use App\Http\Controllers\Backend\API\DashboardController;
    use App\Http\Controllers\Backend\API\NotificationsController;
    use App\Http\Controllers\Backend\API\SettingController;
    use App\Http\Controllers\Backend\API\UserApiController;
    use App\Http\Controllers\Backend\API\AddressController;
    use App\Http\Controllers\Backend\API\AdminDashboardApiController;
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
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::get('branch-list', [BranchController::class, 'branchList']);
    Route::get('user-detail', [AuthController::class, 'userDetails']);
    Route::get('/user-list', [UserApiController::class, 'user_list'])->name('user_list');

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('social-login', 'socialLogin');
        Route::post('forgot-password', 'forgotPassword');
        Route::get('logout', 'logout');
    });

    Route::get('dashboard-detail', [DashboardController::class, 'dashboardDetail']);
    Route::get('firebase-detail', [DashboardController::class, 'firebaseDetails']);


    Route::get('pet-center-configuration', [BranchController::class, 'branchConfig']);
    Route::get('pet-center-detail', [BranchController::class, 'branchDetails']);
    Route::get('branch-service', [BranchController::class, 'branchService']);
    Route::get('branch-review', [BranchController::class, 'branchReviews']);
    Route::get('branch-employee', [BranchController::class, 'branchEmployee']);
    Route::get('branch-gallery', [BranchController::class, 'branchGallery']);


    Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('employee-dashboard', [DashboardController::class, 'employeeDashboard']);
    Route::get('admin-dashboard', [AdminDashboardApiController::class, 'dashboardDetail']);
    Route::get('admin-bookings', [AdminDashboardApiController::class, 'adminBookingsList']);
    Route::get('admin-orders', [AdminDashboardApiController::class, 'adminOrdersList']);
    Route::get('admin-booking-detail/{id}', [AdminDashboardApiController::class, 'bookingDetail']);
    Route::post('admin-booking-status-update/{id}', [AdminDashboardApiController::class, 'updateBookingStatus']);
    Route::get('admin-order-detail/{id}', [AdminDashboardApiController::class, 'orderDetail']);
    Route::post('admin-order-status-update/{id}', [AdminDashboardApiController::class, 'updateOrderStatus']);
    Route::get('admin-finance-details', [AdminDashboardApiController::class, 'financeDetails']);
    Route::get('admin-reports', [AdminDashboardApiController::class, 'adminReports']);

        Route::post('branch/assign/{id}', [BranchController::class, 'assign_update']);
        Route::apiResource('branch', BranchController::class);
        Route::apiResource('user', UserApiController::class);
        Route::apiResource('setting', SettingController::class);
        Route::apiResource('notification', NotificationsController::class);
        Route::get('notification-list', [NotificationsController::class, 'notificationList']);
        Route::get('notification-remove', [NotificationsController::class, 'notificationRemove']);
        Route::get('notification-deleteall', [NotificationsController::class, 'deleteAll']);
        Route::get('gallery-list', [DashboardController::class, 'globalGallery']);
        Route::get('search-list', [DashboardController::class, 'searchList']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);

        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('delete-account', [AuthController::class, 'deleteAccount']);

        Route::post('add-address', [AddressController::class, 'store']);
        Route::get('address-list', [AddressController::class, 'AddressList']);
        Route::get('remove-address', [AddressController::class, 'RemoveAddress']);
        Route::post('edit-address', [AddressController::class, 'EditAddress']);

        Route::post('verify-slot', [BranchController::class, 'verifySlot']);
        Route::post('one-day-service-price', [UserApiController::class, 'perdaypricestore']);
        Route::get('get-one-day-service-price', [UserApiController::class, 'getperdayprice']);
    });
    Route::get('app-configuration', [SettingController::class, 'appConfiguraton']);

    Route::get('clear', function() {
        \Modules\Product\Models\ProductCategory::where('status', 0)->update(['status' => 1]);
        \Artisan::call('optimize:clear');
        return 'Cache cleared successfully!';
    });

    Route::get('test-products', function () { return \Modules\Product\Models\Product::select('id', 'name', 'status')->where('name', 'like', '%Decra%')->orWhere('id', '>', 0)->take(20)->get(); });

    Route::get('clear', function () { \Modules\Product\Models\ProductCategory::where('status', 0)->update(['status' => 1]); \Modules\Product\Models\Product::where('status', 0)->update(['status' => 1]); return 'Cleaned both categories and products!'; });

    Route::get('test-canned', function () { $cat = \Modules\Product\Models\ProductCategory::where('name', 'like', '%canned%')->first(); if(!$cat) return 'No canned category'; $subcats = \Modules\Product\Models\ProductCategory::where('parent_id', $cat->id)->pluck('id')->toArray(); $allCats = array_merge([$cat->id], $subcats); return \Modules\Product\Models\Product::whereHas('categories', function($q) use ($allCats){ $q->whereIn('product_categories.id', $allCats); })->select('id', 'name', 'status')->get(); });
