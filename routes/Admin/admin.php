<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){

    //meldingen Route
    Route::get('/meldingen',[\App\Http\Controllers\Admin\MeldingenController::class,'index'])->name('meldingen');
    Route::get('/meldingen/edit/{id}',[\App\Http\Controllers\Admin\MeldingenController::class,'edit']);
    Route::post('/meldingen/update/{id}',[\App\Http\Controllers\Admin\MeldingenController::class,'update']);
    Route::get('/delete/meldingen/{id}',[\App\Http\Controllers\Admin\MeldingenController::class,'destroy']);
    Route::get('/admin/meldingen-data',[\App\Http\Controllers\Admin\MeldingenController::class,'meldingen_data']);

    //Regio Routes
    Route::get('/regio',[\App\Http\Controllers\Admin\RegioController::class,'index'])->name('regio');
    Route::get('/regio-data',[\App\Http\Controllers\Admin\RegioController::class,'regio_data']);
    Route::get('/regio/edit/{id}',[\App\Http\Controllers\Admin\RegioController::class,'edit']);
    Route::post('/regio/update/{id}',[\App\Http\Controllers\Admin\RegioController::class,'update']);
    Route::get('/regio/delete/{id}',[\App\Http\Controllers\Admin\RegioController::class,'destroy']);

    //Blog Category
    Route::get('/blog-category/create',[\App\Http\Controllers\Admin\BlogCategoryController::class,'create']);
    Route::post('/store/Blog-category',[\App\Http\Controllers\Admin\BlogCategoryController::class,'store']);
    Route::get('/blog-category',[\App\Http\Controllers\Admin\BlogCategoryController::class,'index'])->name('blog_category');
    Route::get('/blog-category-data',[\App\Http\Controllers\Admin\BlogCategoryController::class,'Categories_data']);
    Route::get('/blog-category/edit/{id}',[\App\Http\Controllers\Admin\BlogCategoryController::class,'edit']);
    Route::post('/blog-category/update/{id}',[\App\Http\Controllers\Admin\BlogCategoryController::class,'update']);
    Route::get('/blog-category/delete/{id}',[\App\Http\Controllers\Admin\BlogCategoryController::class,'destroy']);

    //Blog Routes

    Route::get('/blogs/create',[\App\Http\Controllers\Admin\BlogController::class,'create']);
    Route::post('/store/blog',[\App\Http\Controllers\Admin\BlogController::class,'store']);
    Route::get('/blog-data',[\App\Http\Controllers\Admin\BlogController::class,'blog_data']);
    Route::get('/blogs',[\App\Http\Controllers\Admin\BlogController::class,'index'])->name('blogs');
    Route::get('/blogs/edit/{id}',[\App\Http\Controllers\Admin\BlogController::class,'edit']);
    Route::post('/blog/update/{id}',[\App\Http\Controllers\Admin\BlogController::class,'update']);
    Route::get('/blogs/delete/{id}',[\App\Http\Controllers\Admin\BlogController::class,'destroy']);

    //Partner Blog
    Route::get('/partner-blogs/create',[\App\Http\Controllers\Admin\PartnerBlogController::class,'create']);
    Route::post('/store/partner-blogs',[\App\Http\Controllers\Admin\PartnerBlogController::class,'store']);
    Route::get('/partner-blogs-data',[\App\Http\Controllers\Admin\PartnerBlogController::class,'blog_data']);
    Route::get('/partner-blogs',[\App\Http\Controllers\Admin\PartnerBlogController::class,'index'])->name('partner-blogs');
    Route::get('/partner-blogs/edit/{id}',[\App\Http\Controllers\Admin\PartnerBlogController::class,'edit']);
    Route::post('/partner-blogs/update/{id}',[\App\Http\Controllers\Admin\PartnerBlogController::class,'update']);
    Route::get('/partner-blogs/delete/{id}',[\App\Http\Controllers\Admin\PartnerBlogController::class,'destroy']);

    //Category Routes
    Route::get('/category/create',[\App\Http\Controllers\Admin\CategoryController::class,'create']);
    Route::post('/category/store',[\App\Http\Controllers\Admin\CategoryController::class,'store']);
    Route::get('/category-data',[\App\Http\Controllers\Admin\CategoryController::class,'Categories_data']);
    Route::get('/category',[\App\Http\Controllers\Admin\CategoryController::class,'index'])->name('category');
    Route::get('/category/edit/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'edit']);
    Route::post('/category/update/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'update']);
    Route::get('/category/delete/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'destroy']);

    //provincie Routes
    Route::get('/provincie/create',[\App\Http\Controllers\Admin\ProvincieController::class,'create']);
    Route::post('/provincie/store',[\App\Http\Controllers\Admin\ProvincieController::class,'store']);
    Route::get('/provincie',[\App\Http\Controllers\Admin\ProvincieController::class,'index'])->name('provincie');
    Route::get('/provincie-data',[\App\Http\Controllers\Admin\ProvincieController::class,'provincie_data']);
    Route::get('/provincie/edit/{id}',[\App\Http\Controllers\Admin\ProvincieController::class,'edit']);
    Route::post('/provincie/update/{id}',[\App\Http\Controllers\Admin\ProvincieController::class,'update']);
    Route::get('/provincie/delete/{id}',[\App\Http\Controllers\Admin\ProvincieController::class,'destroy']);

    //SEO Data Routes

    Route::get('/seo-data',[\App\Http\Controllers\Admin\SeoController::class,'index'])->name('seo_data');
    Route::get('/fetch-seo-data',[\App\Http\Controllers\Admin\SeoController::class,'seo_data']);
    Route::get('/seo-data/edit/{page}',[\App\Http\Controllers\Admin\SeoController::class,'edit']);
    Route::post('/seo-data/update/{page}',[\App\Http\Controllers\Admin\SeoController::class,'update']);

    //Dictionary Routes
    Route::get('/dictionary',[\App\Http\Controllers\Admin\DictionaryController::class,'index'])->name('dictionary');
    Route::get('/dictionary-data',[\App\Http\Controllers\Admin\DictionaryController::class,'Dictonary_data']);
    Route::get('/dictionary/edit/{id}',[\App\Http\Controllers\Admin\DictionaryController::class,'edit']);
    Route::post('/dictionary/update/{id}',[\App\Http\Controllers\Admin\DictionaryController::class,'update']);


    //ADS routes

    Route::get('/ads/create',[\App\Http\Controllers\Admin\ADSController::class,'create']);
    Route::get('/ads',[\App\Http\Controllers\Admin\ADSController::class,'index'])->name('ADS');
    Route::post('/ads/store',[\App\Http\Controllers\Admin\ADSController::class,'store']);
    Route::get('/ads-data',[\App\Http\Controllers\Admin\ADSController::class,'ads_data']);
    Route::get('/ads/edit/{id}',[\App\Http\Controllers\Admin\ADSController::class,'edit']);
    Route::post('/ads/update/{id}',[\App\Http\Controllers\Admin\ADSController::class,'update']);
    Route::get('/ads/delete/{id}',[\App\Http\Controllers\Admin\ADSController::class,'destroy']);

    //news routes

    Route::get('/nieuws',[\App\Http\Controllers\Admin\newsController::class,'index'])->name('news');
    Route::get('/news-data',[\App\Http\Controllers\Admin\newsController::class,'news_data']);
    Route::get('/nieuws/edit/{id}',[\App\Http\Controllers\Admin\newsController::class,'edit']);
    Route::post('/nieuws/update/{id}',[\App\Http\Controllers\Admin\newsController::class,'update']);
    Route::get('/nieuws/create',[\App\Http\Controllers\Admin\newsController::class,'create']);
    Route::post('/nieuws/store',[\App\Http\Controllers\Admin\newsController::class,'store']);
    Route::get('/nieuws/delete/{id}',[\App\Http\Controllers\Admin\newsController::class,'destroy']);
    Route::post('/nieuws/delete-all',[\App\Http\Controllers\Admin\newsController::class,'delete_all']);

    Route::get('/comments',[\App\Http\Controllers\NewsCommentsController::class,'index']);
    Route::get('/comments-data',[\App\Http\Controllers\NewsCommentsController::class,'comment_data']);
    Route::post('/comments/bulk-approve',[\App\Http\Controllers\NewsCommentsController::class,'bulk_approve']);
    Route::post('/comments/bulk-delete',[\App\Http\Controllers\NewsCommentsController::class,'bulk_delete']);
    Route::get('/comments/pending/{id}',[\App\Http\Controllers\NewsCommentsController::class,'pending']);
    Route::get('/comments/delete/{id}',[\App\Http\Controllers\NewsCommentsController::class,'delete']);

    //cookie
    Route::get('/Cookiebeleid/create',[\App\Http\Controllers\CookiebeleidController::class,'create']);
    Route::get('/Cookiebeleid/edit/{id}',[\App\Http\Controllers\CookiebeleidController::class,'edit']);
    Route::post('/Cookiebeleid/store',[\App\Http\Controllers\CookiebeleidController::class,'store']);
    Route::post('/Cookiebeleid/update/{id}',[\App\Http\Controllers\CookiebeleidController::class,'update']);
    Route::get('/cookiebeleid',[\App\Http\Controllers\CookiebeleidController::class,'index'])->name('Cookiebeleid');
    Route::get('/cookie-data',[\App\Http\Controllers\CookiebeleidController::class,'cookie_data']);

    //privacy

    Route::get('/privacybeleid',[\App\Http\Controllers\PrivacyController::class,'index'])->name('privacy');
    Route::get('/privacybeleid-data',[\App\Http\Controllers\PrivacyController::class,'privacy_data']);
    Route::get('/privacybeleid/edit/{id}',[\App\Http\Controllers\PrivacyController::class,'edit']);
    Route::post('/privacybeleid/update/{id}',[\App\Http\Controllers\PrivacyController::class,'update']);



    //user Routes
    Route::get('/user',[\App\Http\Controllers\UserController::class,'index'])->name('user');
    Route::get('/user/user-data',[\App\Http\Controllers\UserController::class,'user_data']);
    Route::get('/user/delete/{id}',[\App\Http\Controllers\UserController::class,'destroy']);
    Route::get('/user/create',[\App\Http\Controllers\UserController::class,'create']);
    Route::post('/user/store',[\App\Http\Controllers\UserController::class,'store']);
    Route::get('/user/edit/{id}',[\App\Http\Controllers\UserController::class,'edit']);
    Route::post('/user/update/{id}',[\App\Http\Controllers\UserController::class,'update']);
});


