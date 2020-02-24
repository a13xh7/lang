<?php

// Landings

// SET LOCALE
Route::get('/set/{locale}', 'LocalizationController@set')->name('set_locale');


// TEXTS PAGE
Route::get('/', 'TextsController@showTexts')->name('texts');
Route::post('/reader/texts/update', 'TextsController@updateText')->name('update_text');
Route::get('/reader/texts/delete/{textId}', 'TextsController@deleteText')->name('delete_text');

// ADD TEXT PAGE
Route::get('/reader/add/text', 'AddTextController@showPage')->name('add_text_page');
Route::post('/reader/add/text', 'AddTextController@addText')->name('add_text');

// TEXT STATS PAGE
Route::get('/reader/text/stats/{textId}', 'TextStatsController@showTextStats')->name('text_stats');

// TEXT PAGE. READ PAGE
Route::get('/reader/read/text/{textId}', 'TextPageController@showPage')->name('read_text_page');

// Words
Route::get('/reader/words', 'WordsController@showPage')->name('words');

// Words
Route::post('/reader/words/add', 'WordsController@ajaxAddNewWord')->name('add_new_word');
Route::post('/reader/words/update', 'WordsController@ajaxUpdateWordState')->name('update_word');
Route::post('/reader/words/update2', 'WordsController@ajaxUpdateWordStateFromPageReader')->name('update_word2');

Route::post('/reader/word/translate/', 'WordsController@getTranslationFromDatabase')->name('get_translation');

