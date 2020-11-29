<?php

// Auth
Route::post('/auth/login', 'AuthController@login');

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
    Route::get('/tech-stack-item/getAll', 'TechStackItemsController@getList');
    Route::resource('tech-stack-item', 'TechStackItemsController', [
      'only' => [
          'index', 'store', 'show', 'update', 'destroy'
      ]
    ]);

    // Projects
    Route::resource('projects', 'ProjectsController', [
      'only' => [
          'index', 'store', 'show', 'update', 'destroy'
      ]
    ]);

    // Passion
    Route::resource('passion', 'PassionsController', [
      'only' => [
          'index', 'show', 'update'
      ]
    ]);

    // Contact
    Route::resource('contact', 'ContactController', [
      'only' => [
          'index', 'store', 'update', 'destroy'
      ]
    ]);

    //Sample Page Image
    Route::get('/sample-page-image/getAll/{id}', 'SamplePageImageController@getList');
    Route::resource('sample-page-image', 'SamplePageImageController', [
      'only' => [ 'store', 'destroy' ]
    ]);

    // Blog
    Route::resource('blogs', 'BlogsController', [
      'only' => [
          'index', 'store', 'update', 'destroy', 'show'
      ]
    ]);

    // Category
    Route::get('/categories/getAll', 'CategoriesController@getList');
    Route::resource('categories', 'CategoriesController', [
      'only' => [
          'index', 'store', 'update', 'destroy', 'show'
      ]
    ]);
});