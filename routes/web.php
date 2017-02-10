<?php

Route::group(['middleware' => 'auth.basic'], function () {
    Route::get('/', 'DashboardController@index');
    Route::get('/sales', 'DashboardController@sales');
});

Route::post('/webhook/github', 'GitHubWebhookController@gitRepoReceivedPush');
