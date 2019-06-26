<?php

/****************************************************************
 * ACCESSIBLE FOR EVERYONE PAGES
 ****************************************************************/

Route::get('/', 'PublicController@showIndexLanding')->name('index_landing');

Route::get('/reader', 'PublicController@showReaderLanding')->name('reader_landing');



/****************************************************************
 * MAIN SITE
 ****************************************************************/

Auth::routes();

Route::middleware(['auth'])->group(function ()
{
    Route::get('/dashboard', 'Main\DashboardController@showDashboard')->name('main_dashboard');
});




/****************************************************************
 * READER
 ****************************************************************/

Route::middleware(['auth'])->group(function ()
{
    // INDEX AND OTHER STATIC PAGES
    Route::get('/reader/dashboard', 'Reader\ReaderController@showDashboard')->name('reader_dashboard');
    Route::get('/reader/faq', 'Reader\ReaderController@faq')->name('reader_faq');

    // ADD TEXT PAGE
    Route::get('/reader/add/text', 'Reader\AddTextController@showPage')->name('reader_add_text_page');
    Route::post('/reader/add/text', 'Reader\AddTextController@addText')->name('reader_add_text');

    // TEXTS PAGE
    Route::get('/reader/texts', 'Reader\TextsController@showTexts')->name('reader_texts');
    Route::post('/reader/texts/update', 'Reader\TextsController@updateText')->name('reader_update_text');
    Route::get('/reader/texts/del/{textId}', 'Reader\TextsController@deleteText')->name('reader_delete_text');

    // TEXT STATS PAGE
    Route::get('/reader/texts/stats/{textId}', 'Reader\TextStatsController@showTextStats')->name('reader_text_stats');


    Route::get('/reader/read/text/{textId}/{textPage}', 'Reader\IndexController@index');

    Route::get('/reader/words', 'Reader\IndexController@index')->name('reader_words');
    Route::get('/reader/words/new', 'Reader\IndexController@index')->name('reader_known_words');
    Route::get('/reader/words/known', 'Reader\IndexController@index')->name('reader_known_words');


});