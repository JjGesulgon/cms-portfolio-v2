<?php

// Auth
Route::post('/auth/login', 'AuthController@apiLogin');

Route::group(['middleware' => ['auth:api']], function () {
    // Auth
    Route::post('/auth/logout', 'AuthController@apiLogout')->name('logout');
    Route::get('/auth/user', 'AuthController@user');

    // Users
    Route::match(['put', 'patch'], 'users/{user}/restore', 'UsersController@restore');
    Route::delete('users/{user}/force-delete', 'UsersController@forceDestroy');
    Route::resource('users', 'UsersController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // About Me
    Route::resource('about-me', 'AboutMeController', [
        'only' => [
            'index', 'store', 'update', 'destroy'
        ]
    ]);

    // Tech Stack Content
    Route::resource('tech-stack-content', 'TechStackContentController', [
      'only' => [
          'index', 'store', 'update', 'destroy'
      ]
    ]);

    // Tech Stack Item
    Route::resource('tech-stack-item', 'TechStackItemController', [
      'only' => [
          'index', 'store', 'update', 'destroy'
      ]
    ]);
});
