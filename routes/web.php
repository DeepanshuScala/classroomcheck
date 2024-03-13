<?php

use Illuminate\Support\Facades\{Route,Auth};
use Illuminate\Http\Request;
use App\Http\Controllers\admin;

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
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
//    Artisan::call('cache:clear');
//    Artisan::call('config:cache');
//    Artisan::call('config:clear');
    return "Cache is cleared";
});
//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/test-view', [App\Http\Controllers\TestController::class, 'testView'])->name('test.view');
Route::post('/test-profile-image-update', [App\Http\Controllers\TestController::class, 'imageUpdateTest'])->name('profileImage.update.test');

Route::post('/add-question', [App\Http\Controllers\HomeController::class, 'addQuestion'])->name('add-question');

//for load more data user adeed question
Route::post('/load-more', [App\Http\Controllers\HomeController::class, 'loadMore'])->name('loadmore');
Route::any('/account-my-inbox-load-more', [App\Http\Controllers\HomeController::class, 'accountMyInboxLoadMore'])->name('account-my-inbox-load-more');

Route::any('/store-my-inbox-load-more', [App\Http\Controllers\HomeController::class, 'storeMyInboxLoadMore'])->name('store-my-inbox-load-more');
// Route::post('/load-more', 'loadMore')->name('loadmore');


/* * ******** Footer Web Page Routing *************** */
Route::controller(App\Http\Controllers\WebContentController::class)->group(function () {
    Route::get('/web/{slug}', 'index');
    Route::get('/faq', 'getFaq');
    Route::get('/blogs', 'getBlogs')->name('blog.list');
    Route::get('/blog-details/{blog_id}', 'getBlogDetails');
    Route::get('/contact-us', 'getContactUs');
    Route::post('/contact-us', 'getContactUs');
    Route::get('/about-us', 'aboutUs')->name('about.us');
    Route::get('/subscribe', 'subscribeOnWeb');
    Route::post('/subscribe', 'subscribeOnWeb');
});

Route::get('/contribution/{contribution_id}', [App\Http\Controllers\buyer\ClassRoomContributionController::class, 'contributionViewDetails']);

Route::post('/contributionpay', [App\Http\Controllers\buyer\ClassRoomContributionController::class, 'contributionPay']);

Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
    Route::get('/', 'viewLogin')->name('classroom.index');
    Route::get('/dashboard/{type}', 'redirectAccountDashboard');
    Route::get('/add-admin-relative', 'addSellerAdminRelative');
    Route::post('/auth-login', 'authLogin')->name('auth.login.post');
    Route::post('/forget-password', 'forgetPasswordPost')->name('forget.password.post');
    Route::get('/reset-password/{token}', 'getPassword')->name('reset.password');
    Route::post('/reset-password', 'updatePassword')->name('update.password');
    Route::get('/account-dash-join-now', 'accountUserRegister')->name('account.dashboard.join.now')->middleware('preventBackHistory');
    Route::post('/account-user-register', 'accountUserRegisterPost')->name('accountUser.Register.Post');
    Route::get('/store-dash-join-now', 'storeUserRegister')->name('store.dashboard.join.now')->middleware('preventBackHistory');
    Route::post('/store-user-register', 'storeUserRegisterPost')->name('storeUser.Register.Post');
});
//================= HomeController Controller ===================== //
Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
    Route::get('register/user/verify/{token}', 'verifyUser');
    Route::get('relative/{token}', 'getAdminRelativeDetails');
    Route::post('verify/relative', 'verifyAdminRelative');
    Route::get('/help-and-faq', 'helpFaq')->name('help.faq');
    Route::get('/document-and-policies', 'documentAndPolicies')->name('document.and.policies');
    Route::get('/become-a-seller', 'becomeAseller')->name('become.a.seller');
    Route::get('/gift-account', 'giftinaccount')->name('gift.in.account');
    Route::any('/product-search', 'productSearchView')->name('product.search.view');
    //Route::post('/product-search', 'productSearchView')->name('product.search.view');
    Route::post('/product-filter-search', 'getProductFilterSearchShowMore')->name('product.filterSearch.get');
    Route::any('/product-filter-search-paginate', 'getProductFilterSearchPaginate')->name('product.filterSearchPaginate.get');
    //Countries && States API:
    Route::post('/get-countries-list', 'getCountriesList')->name('get.allCountries.list');
    Route::post('/get-states-by-country', 'getStatesByCountry')->name('get.statesByCountry.list');

    ///////////////////////
    Route::get('/account-dashboard-view-for-store-user', 'accountDashboardViewForStore')->name('accountDashboard.for.storeUser');
    Route::get('/store-dashboard-view-for-account-user', 'storeDashboardViewForAccount')->name('storeDashboard.for.accountUser');
    ///////////////////////
    //RESOURCES YOU MAY LIKE:
    Route::post('/home/resources-you-may-like', 'homeResourcesYouMayLike')->name('home.resourcesYouMayLike.get');
    
    //Top Sellers
    Route::post('/home/get-top-seller-product', 'getTopsellerproducts')->name('home.getTopsellerproducts.get');
    //Product description:
    Route::get('/product-description/{id}', 'productDescription')->name('product.description');
    Route::any('jobs','executejobs')->name('execute.jobs');

    //Single author page
    Route::get('/seller-profile/{id}','getsingleauthorInfo')->name('get.singleauthor.Info');

    //Delete Account
    Route::any('delete-account/{id}','deleteaccount')->name('delete.account');
    Route::any('deactivate-account/{id}','deactivateaccount')->name('deactivate.account');
    
    Route::get('download/{id?}', 'downloadFile')->name('download.file');
    Route::any('storeDashboard-removeselleroffer','storeDashboardremoveselleroffer')->name('storeDashboard.removeselleroffer');
    
});

// ================= Auth protected Route groups: ===================== //
Route::group(['middleware' => ['authCheck']], function () {
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
    Route::any('/total-cart-item-count', [App\Http\Controllers\AccountController::class, 'totalCartItemCount'])->name('totalCartItem.count');
    // ================= AccountController Controller ===================== //
    Route::controller(App\Http\Controllers\AccountController::class, ['middleware' => 'authCheck'])->group(function () {
        Route::middleware('RoleCheck:account')->group(function () {
            Route::get('/account-dashboard', 'accountDashboard')->name('account.dashboard');
            Route::get('/account-dashboard-my-inbox', 'accountDashboardMyInbox')->name('accountDashboard.myInbox');
            Route::get('/account-dashboard/my-profile', 'accountDashMyProfile')->name('accountDashboard.myProfile');
            Route::get('/account-dashboard/my-purchase-history', 'accountDashMyPurchaseHistory')->name('accountDashboard.myPurchaseHistory');
            Route::get('/account-dashboard/my-wishlist', 'accountDashMyWishlist')->name('accountDashboard.myWishlist');
            Route::get('/account-dashboard/my-cart', 'accountDashMyCart')->name('accountDashboard.myCart');
            Route::any('/account-dashboard/change-orderitem-download', 'changeorderitemdownload')->name('change.orderitem.download');
            
            //Basic profile updae:
            Route::post('/profile/personal-details-update', 'personalDetailsUpdate')->name('personalDetails.update');
            Route::any('/add-to-favourite', 'addTofavourite')->name('addToFavourite');
            Route::any('/remove-favourite-item', 'removeFavouriteItem')->name('removeFavourite');
            //Favourite item list:
            Route::post('/favourite-item-show-more', 'getFavouriteItemShowMore')->name('showMore.favouriteItem.get');
            Route::any('/favourite-item-paginate-get', 'getFavouriteItemsPaginate')->name('favouriteItemPaginate.get');
            //Cart item list:
            //            Route::post('/cart-item-show-more', 'getCartItemShowMore')->name('showMore.cartItem.get');
            Route::any('/cart-item-paginate-get', 'getCartItemsPaginate')->name('cartItemPaginate.get');
            Route::any('/add-to-cart', 'addToCart')->name('addToCart');
            Route::any('/remove-cart-item', 'removeCartItem')->name('removeCartItem');

            Route::any('/check-if-already-purached','checkifalreadypurached')->name('check.if.alreadypurached');
            // Route::any('/total-cart-item-count', 'totalCartItemCount')->name('totalCartItem.count');
            Route::any('change-quantity-cart','changequantitycart')->name('change.quantity.cart');
            //Cart Checkout payment:
            Route::any('/checkout/item-details', 'checkoutItemsDetails')->name('checkout.cartItems.details');
            //Purchase History:
            Route::post('/purchase-history-show-more', 'getPurchaseHistoryShowMore')->name('showMore.purchaseHistory.get');
            Route::any('/purchase-history-paginate-get', 'getPurchaseHistoryPaginate')->name('purchaseHistoryPaginate.get');

            //Create order for free product 
            Route::any('/create-order-freeproduct','createorderfreeproduct')->name('create.order.freeproduct');

        }); //RoleCheck:account middleware ends here
    }); //AccountController Controller ends here

    Route::controller(App\Http\Controllers\AuthController::class, ['middleware' => 'authCheck'])->group(function () {
        Route::middleware('RoleCheck:account')->group(function () {
            Route::post('/account-dashboard/my-profile/change-password', 'accountDashChangePassword')->name('accountDashboard.changePwd.post');
        });
        Route::post('/profile-image-update', 'profileImageUpdate')->name('profileImage.update');
    });

    // ================= StoreController Controller ===================== //
    Route::controller(App\Http\Controllers\StoreController::class, ['middleware' => 'authCheck'])->group(function () {
        Route::middleware('RoleCheck:store')->group(function () {
            Route::post('/store-dashboard/review/reply', 'reviewReply')->name('storeDashboard.reviewReply');
            Route::post('/store-profile/update', 'storeProfileUpdate')->name('storeDashboard.update');
            Route::get('/store-dashboard', 'storeDashboard')->name('store.dashboard');
            Route::get('/store-dashboard-my-inbox', 'storeDashboardMyInbox')->name('storeDashboard.myInbox');

            //Send Email to buyers
            Route::post('/send-email-to-buyers','sendemailtobuyers')->name('send.email.to.buyers');
            
            Route::get('/store-dashboard-reports', 'storeDashboardReports')->name('storeDashboard.reports');
            //Reports:
            Route::get('/store-dashboard-reports-sales-report', 'storeDashboardReportsSalesReport')->name('storeDashboard.reports.salesReport');
            Route::get('/store-dashboard-reports-sales-tax', 'storeDashboardReportsSalesTax')->name('storeDashboard.reports.salesTax');
            Route::get('/store-dashboard-reports-products', 'storeDashboardReportsProducts')->name('storeDashboard.reports.products');
            Route::get('/store-dashboard-reports-marketing', 'storeDashboardReportsMarkets')->name('storeDashboard.reports.marketing');
            Route::get('/store-dashboard-reports-sales-by-country', 'storeDashboardReportsSalesByCountry')->name('storeDashboard.reports.SalesByCountry');

            Route::get('/store-dashboard-about-selling', 'storeDashAboutSelling')->name('storeDashboard.aboutSelling');
            Route::get('/store-dashboard-marketing-dashboard', 'storeDashMarketingDashboard')->name('storeDashboard.marketingDashboard');
            Route::get('/store-dashboard-host-a-sale/{id?}', 'storeDashHostAsale')->name('storeDashboard.HostAsale');

            //store routes
            Route::any('/store-dashboard/become-a-seller/store-setup', 'storeDashStoreSetup')->name('storeDashboard.storeSetup');
            //Route::post('/store-dashboard/become-a-seller/store-setup', 'storeDashStoreSetup')->name('storeDashboard.storeSetup');
            Route::post('/store-dashboard/become-a-seller/checkStoreNameAvailability', 'checkStoreNameExist')->name('storeDashboard.checkStoreNameAvailability');
            
            Route::get('/store-products', 'storeProducts')->name('store.products');

            Route::post('/get-reviews-sorted','getreviewsorted')->name('get.reviews.sorted');

            Route::post('/host-a-sale','hostasale')->name('host-a-sale.post');
            Route::post('/host-a-sale-delete','hostasaledelete')->name('host-a-sale.delete');

            Route::post('/get_product_list','getstoreproductlist')->name('get_product_list.post');
            Route::get('/show-single-sale/{id?}','getsinglesale')->name('viewsale');

            Route::post('storeDashboard-applyselleroffer','storeDashboardapplyselleroffer')->name('storeDashboard.applyselleroffer');
        
        }); //RoleCheck:store middleware ends here
    });
    //StoreController Controller middleware ends here
    //Payment routes
    Route::post('/payment/getCardStatus', [App\Http\Controllers\PaymentController::class, 'checkCardStatus']);
    Route::post('/checkout/payment', [App\Http\Controllers\PaymentController::class, 'cartPayment']);
    Route::any('/checkout/payment/{id}', [App\Http\Controllers\PaymentController::class, 'checkoutPage'])->name('checkout.payment');
    /* Route::any('/checkout/payment/{id}', function (Request $request, $id) {
      $data = [];
      $data['checkout_price'] = $request->checkout_price;
      $data['form_url'] = '/checkout/payment';
      $data['title'] = 'Payment';
      $data['home'] = 'Home';
      $data['breadcrumb1'] = 'My Cart';
      $data['breadcrumb2'] = "Payment";
      $data['breadcrumb3'] = false;
      return view('payment.payment_form', ['data' => $data]);
      })->name('checkout.payment'); */

    /*     * ******** Buyer Routing *************** */
    //Classroom Contribution Routes
    Route::middleware(['RoleCheck:account'])->group(function () {
        //Classroom Contribution Routes
        Route::controller(App\Http\Controllers\buyer\ClassRoomContributionController::class)->group(function () {
            Route::get('/account-dashboard/contributions', 'index')->name('accountDashboard.contributions');
            Route::get('/account-dashboard/contributions-view', 'view')->name('accountDashboard.contributionsView');
            Route::get('/account-dashboard/contributions-editview', 'viewwedit')->name('accountDashboard.contributionsEditView');
            Route::any('/account-dashboard/contributions-setup', 'accountDashClassroomContributions')->name('accountDashboard.classroomContributions');
            //Route::post('/account-dashboard/contributions-setup', 'accountDashClassroomContributions')->name('accountDashboard.classroomContributions');
            Route::any('/account-dashboard/contributions-edit/{contribution_id}', 'accountDashContributionsEdit')->name('accountDashboard.contributionsEdit');
            //Route::post('/account-dashboard/contributions-edit/{contribution_id}', 'accountDashContributionsEdit')->name('accountDashboard.contributionsEdit');
            Route::get('/account-dashboard/contributions-view-details/{contribution_id}', 'accountDashContributionsViewDetails');
        });
        //Suggest Resource Routes
        Route::controller(App\Http\Controllers\buyer\SuggestResourceController::class)->group(function () {
            Route::any('/account-dashboard/suggest-a-resource', 'index')->name('accountDashboard.suggestAresource');
            //Route::post('/account-dashboard/suggest-a-resource', 'index')->name('accountDashboard.suggestAresource');
        });
        //Follow-Unfollow Routes
        Route::controller(App\Http\Controllers\buyer\FollowController::class)->group(function () {
            Route::post('/buyer/follow-unfollow', 'followUnfollowSeller');
            Route::post('/buyer/notifyupdate', 'notifyUpdate');
            Route::get('/account-dashboard/preferred-seller', 'accountDashPreferredSeller')->name('accountDashboard.preferredSeller');
        });
        //Update User Setting Routes
        Route::controller(App\Http\Controllers\buyer\UserSettingController::class)->group(function () {
            Route::post('/buyer/update-user-settings', 'updateUserSettings');
        });
        //Payment System Routes
        Route::controller(\App\Http\Controllers\buyer\PaymentController::class)->group(function () {
            Route::get('/buyer/payment-system', 'index')->name('buyer.paymentsystem');
            Route::get('/buyer/card-list', 'getCardList');
            Route::get('/buyer/remove-card/{card_id}', 'removeCard');
            Route::get('/buyer/add-card', 'addCard');
            Route::post('/buyer/save-card', 'saveCard');
            Route::get('/buyer/update-card/{card_id}', 'updateCard');
        });
        //Rate & Review Routes
        Route::controller(\App\Http\Controllers\buyer\RateReviewController::class)->group(function () {
            Route::post('/buyer/rate-review', 'index');
            Route::post('/buyer/get-rate-review', 'getReviewData');
        });
        //Report an issue
        Route::controller(\App\Http\Controllers\Issuereport::class)->group(function () {
            Route::post('/buyer/issue-report', 'store_issue');
        });
        //payment setup
        Route::controller(App\Http\Controllers\buyer\StripeConnectController::class, ['middleware' => 'authCheck'])->group(function () {
            Route::get('/buyer/store-payment-setup', 'createStripeAccount')->middleware('preventBackHistory');
            Route::get('/buyer/refresh_url', 'refreshUrl')->name('buyer.refresh.url');
            Route::get('/buyer/return_url', 'returnUrl')->name('buyer.return.url');
            Route::get('/buyer/stripe_connect_express_login_link_create', 'stripeExpressConnectLoginLink')->name('buyer.stripeConnect.loginLink.create');
        });
    });

    /*     * ************ Seller Routing ******************* */
    //Store Payment Setup Routes
    Route::middleware('RoleCheck:store')->group(function () {
        //seller store, payment setup
        Route::controller(App\Http\Controllers\seller\StripeConnectController::class, ['middleware' => 'authCheck'])->group(function () {
            Route::get('/store-payment-setup', 'createStripeAccount')->middleware('preventBackHistory');
            Route::get('/refresh_url', 'refreshUrl')->name('refresh.url');
            Route::get('/return_url', 'returnUrl')->name('return.url');
            Route::get('/stripe_connect_express_login_link_create', 'stripeExpressConnectLoginLink')->name('stripeConnect.loginLink.create');
        });
        //Payment System Routes
        Route::controller(\App\Http\Controllers\seller\PaymentController::class)->group(function () {
            Route::get('/seller/payment-system', 'index')->name('seller.paymentsystem');
            Route::get('/seller/card-list', 'getCardList');
            Route::get('/seller/remove-card/{card_id}', 'removeCard');
            Route::get('/seller/add-card', 'addCard');
            Route::post('/seller/save-card', 'saveCard');
            Route::get('/seller/update-card/{card_id}', 'updateCard');
        });
        //Product Routes
        Route::controller(\App\Http\Controllers\seller\ProductController::class)->group(function () {
            
            Route::get('/product-dashboard', 'storeDashProductDashboard')->name('storeDashboard.productDashboard');
            Route::get('/store-dashboard/product-list', 'index');
            Route::get('/store-dashboard/rating-list', 'ratingreviewlist')->name('rating.review.list');
            Route::get('/store-dashboard/add-product', 'storeDashAddProduct')->name('storeDashboard.addProduct');
            Route::post('/store-dashboard/add-product/post', 'addProductPost')->name('storeDashboard.addProduct.post');
            Route::get('/store-dashboard/add-bundle-product', 'storeDashAddBundleProduct')->name('storeDashboard.addBundleProduct');
            Route::post('/store-dashboard/add-bundle-product/post', 'storeDashAddBundleProductPost')->name('storeDashboard.addBundleProduct.post');

            //Get thumbnail 
            Route::post('/store-dashboard/generate-thumbnail', 'autogeneratethumbnail')->name('auto.generatethumbnail');
            
            Route::post('/store-dashboard/getSubjectSubArea', 'getSubjectSubArea')->name('storeDashboard.getSubjectSubArea');
            Route::post('/store-dashboard/getSubjectSubSubArea', 'getSubjectSubSubArea')->name('storeDashboard.getSubjectSubSubArea');
            Route::get('/store-dashboard/update-product/{product_id}', 'updateProduct');
            Route::post('/store-dashboard/update-product/{product_id}', 'updateProduct');
            Route::get('/store-dashboard/update-bundle-product/{product_id}', 'updateBundleProduct');
            Route::post('/store-dashboard/update-bundle-product/{product_id}', 'updateBundleProduct');
            Route::get('/store-dashboard/product-details/{product_id}', 'productDescription');
            
            Route::post('/store-dashboard/delete-product', 'deleteproduct')->name('deleteproduct');
            Route::post('/change-product-status', 'changeproductstatus')->name('changeproduct.status');

            Route::post('/store-dashboard/getStoreproduct','getstoreProductPaginate')->name('product.storeProductPaginate.get');

            Route::post('/store-dashboard/review','getreviewstorePaginate')->name('review.storePaginate.get');
        });
        //Marketing Routes
        Route::prefix('seller/marketing')->controller(\App\Http\Controllers\seller\marketing\MarketingController::class)->group(function () {
            Route::any('/news-letter', 'newsletter')->name('newsletter.seller');
            Route::any('/social-media', 'socialMedia')->name('socialMedia.seller');
            //Route::post('/social-media', 'socialMedia');
        });
        //Marketing Feature Listing Routes
        Route::prefix('seller/marketing')->controller(\App\Http\Controllers\seller\marketing\FeatureController::class)->group(function () {
            Route::get('/feature-listing', 'featureListings')->name('feautere.listing');
            Route::post('/feature-listing', 'featureListings');
            Route::get('/feature-list/payment', 'featureListingPayment');
            Route::post('/feature-list/payment', 'featureListingPayment');
            Route::get('/delete-feature-product/{feature_id}', 'deleteFeatureProduct');
            Route::post('/get-feature-product-slots', 'getSlotsForConfirmedMarketing');
            Route::post('/get-category-products', 'get_product_list_acc_to_cat');
        });
    });
    /*     * ************ Seller/Buyer Routing ******************* */
    Route::controller(App\Http\Controllers\GiftCouponController::class, ['middleware' => 'authCheck'])->group(function () {
        //Gift Card Routes
        Route::any('/gift-card/{id?}', 'giftCard')->name('gift.card');
        //Route::post('/gift-card', 'giftCard')->name('gift.card');
        Route::get('/gift-card-payment', 'giftCardPaymentPage');
        Route::post('/send-gift-card', 'sendGiftCard');
        Route::post('/check-email', 'checkEmailExistOrNot');
        Route::post('/check-gift-card-balance', 'checkGiftCardBalanceByCode');
        Route::post('/apply-gift-coupon-to-cart', 'applyGiftCouponToCart');
        Route::post('/apply-promotional-coupon-to-cart', 'applyPromotionalCouponToCart');
        Route::post('/remove-gift-card','removegiftcard')->name('removegiftcard.post');
    });
});

/* * ************ Cron Routing ******************* */
Route::controller(App\Http\Controllers\CronController::class)->group(function () {
    Route::get('/cron-feature-product-expiration', 'cronForFeatureProductExpire');
});

Route::fallback(function () {
    return view('fallback.fallback');
    //abort(403, 'Unauthorized action.');
});
//The [D:\xampp\htdocs\iws\classroom-copy\public\storage] link has been connected to [D:\xampp\htdocs\iws\classroom-copy\storage\app/public].
//The links have been created.


/* * ********* admin routing ********** */
Route::controller(admin\LoginController::class)->group(function () {
    Route::get('login', 'login');
    Route::post('login', 'login');
//    Route::get('logout', 'logout');
});
// admin protected routes
Route::group(['middleware' => ['adminAuth'], 'prefix' => 'admin'], function () {
    //logout route
    Route::get('logout', [admin\LoginController::class, 'logout']);
    Route::controller(admin\HomeController::class)->group(function () {
        //dashboard route
        Route::get('dashboard', 'index');
        //change password route
        Route::get('change-password', 'changePassword');
        Route::post('change-password', 'changePassword');
        //Suggest a resource route
        Route::get('suggest-a-resource', 'suggestaresource');
        Route::get('newsletter', 'newsletter');
        Route::get('feedbacks', 'feedbacks');
        Route::any('seller-payouts', 'sellerpayouts');
        Route::any('seller-percentages', 'sellerpercentages');
        Route::any('edit-percentages/{id?}', 'editpercentages');
        Route::get('issue-report', 'issuereported');
        Route::post('sendsellernotification', 'sendnotification')->name('sendsellernotification');
        Route::post('sendbuyernotification', 'sendbuyernotification')->name('sendbuyernotification');
        Route::get('seller-social-media-marketing','sellersocialmediamarketing');
        Route::get('sells/{id}','sellerssells');
        Route::get('promotions/{id}','sellerspromotions');
        Route::get('products/{id}','sellersproducts');
        Route::get('communications/{id}','sellerscommunications');
        Route::get('/show-single-sale/{id?}','getsinglesale')->name('admin.viewasale');
        Route::post('update-feedback-status','updatefeedbackstatus')->name('updatefeedbackstatus');
        Route::any('product-management','productmanagement')->name('product.management');
        Route::any('member-management','membermanagement')->name('member.management');
        Route::any('selleroffer','selleroffer')->name('seller.offer');
        Route::get('selleroffer/activate-deactivate/{status}', 'activateDeactivateoffer');
        Route::any('featured-listing','featuredlisting');
        Route::any('featured-listing-details/{user_id}','featuredlistingdetails');
        Route::post('delete-product', 'deleteproduct');
        Route::any('add-seller-banner','addsellerbanner');
        Route::any('delete-seller-banner','deletesellerbanner');
        Route::any('subscribe/{user_id}','subscribeunsubscribe');
    });  

    //user management routes
    Route::prefix('users')->controller(admin\UserController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('sellers', 'getSellers');
        Route::get('buyers', 'getBuyers');
        Route::get('view-user-info/{user_id}', 'getUserInfo');
        Route::get('activate-deactivate-user/{user_id}/{status}', 'activateDeactivateUserAccount');
        Route::get('delete-user/{user_id}', 'deleteUserAccount');
    });
    //subject management routes
    Route::prefix('subject')->controller(admin\SubjectController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('activate-deactivate-subject/{subject_id}/{status}', 'activateDeactivateSubject');
        Route::get('add-subject', 'addSubject');
        Route::post('add-subject', 'addSubject');
        Route::get('add-sub-subject', 'addChildSubject');
        Route::post('add-sub-subject', 'addChildSubject');
        Route::get('update-subject/{subject_id}', 'updateSubject');
        Route::post('update-subject/{subject_id}', 'updateSubject');
        Route::any('delete-subject/{subject_id}', 'deleteSubject');
    });
    //resource management routes
    Route::prefix('resource')->controller(admin\ResourceController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('activate-deactivate-resource/{resource_id}/{status}', 'activateDeactivateResource');
        Route::get('add-resource', 'addResource');
        Route::post('add-resource', 'addResource');
        Route::get('update-resource/{resource_id}', 'updateResource');
        Route::post('update-resource/{resource_id}', 'updateResource');
        Route::any('delete-resource/{resource_id}', 'deleteResource');
    });
    //Grade management routes
    Route::prefix('grade')->controller(admin\GradeController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('activate-deactivate-grade/{grade_id}/{status}', 'activateDeactivateGrade');
        Route::get('add-grade', 'addGrade');
        Route::post('add-grade', 'addGrade');
        Route::get('update-grade/{grade_id}', 'updateGrade');
        Route::post('update-grade/{grade_id}', 'updateGrade');
        Route::any('delete-grade/{grade_id}', 'deleteGrade');
    });
    //Filetype management routes
    Route::prefix('type')->controller(admin\TypeController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('activate-deactivate-type/{type_id}/{status}', 'activateDeactivateType');
        Route::get('add-type', 'addType');
        Route::post('add-type', 'addType');
        Route::get('update-type/{type_id}', 'updateType');
        Route::post('update-type/{type_id}', 'updateType');
        Route::any('delete-type/{type_id}', 'deleteType');
    });
    //promo management routes
    Route::prefix('promo')->controller(admin\PromoController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('activate-deactivate-promo/{promo_id}/{status}', 'activateDeactivatePromotion');
        Route::get('get-rendom-promotion-code', 'generatePromotionAutoCode');
        Route::get('add-promo', 'addPromotion');
        Route::post('add-promo', 'addPromotion');
        Route::get('update-promo/{promo_id}', 'updatePromotion');
        Route::post('update-promo/{promo_id}', 'updatePromotion');
    });
    //content management routes
    Route::prefix('content')->controller(admin\ContentController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('update-content/{content_id}', 'updateContent');
        Route::post('update-content/{content_id}', 'updateContent');
        Route::get('about-us', 'updateAboutUs');
        Route::post('about-us', 'updateAboutUs');
        Route::any('testimonials','testimonials');
        Route::any('add-testimonial','addtestimonials');
        Route::any('update-testimonial/{testimonial_id}', 'updatetestimonial');
        Route::get('delete-testimonial/{testimonial_id}', 'deleteTestimonial');
    });
    //FAQ routes
    Route::prefix('faq')->controller(admin\FaqController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('activate-deactivate-faq/{faq_id}/{status}', 'activateDeactivateFaq');
        Route::get('delete-faq/{faq_id}', 'deleteFaq');
        Route::get('add-faq', 'addFaq');
        Route::post('add-faq', 'addFaq');
        Route::get('update-faq/{faq_id}', 'updateFaq');
        Route::post('update-faq/{faq_id}', 'updateFaq');
    });
    //Blog routes
    Route::prefix('blog')->controller(admin\BlogController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('activate-deactivate-blog/{blog_id}/{status}', 'activateDeactivateBlog');
        Route::get('delete-blog/{blog_id}', 'deleteBlog');
        Route::get('add-blog', 'addBlog');
        Route::post('add-blog', 'addBlog');
        Route::get('update-blog/{blog_id}', 'updateBlog');
        Route::post('update-blog/{blog_id}', 'updateBlog');
    });
});