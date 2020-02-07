<?php

// Landings

Route::get('/', 'PublicController@showIndexLanding')->name('index_landing');

// SET LOCALE
Route::get('/set/{locale}', 'LocalizationController@set')->name('set_locale');



/****************************************************************
 * READER
 ****************************************************************/

// ADD TEXT PAGE
Route::get('/reader/add/text', 'AddTextController@showPage')->name('reader_add_text_page');
Route::post('/reader/add/text', 'AddTextController@addText')->name('reader_add_text');

// TEXTS PAGE
Route::get('/reader/texts', 'TextsController@showTexts')->name('reader_texts');
Route::post('/reader/texts/update', 'TextsController@updateText')->name('reader_update_text');
Route::get('/reader/texts/delete/{textId}', 'TextsController@deleteText')->name('reader_delete_text');

// TEXT STATS PAGE
Route::get('/reader/text/stats/{textId}', 'TextStatsController@showTextStats')->name('reader_text_stats');

// TEXT PAGE. READ PAGE
Route::get('/reader/read/text/{textId}', 'TextPageController@showPage')->name('reader_read_text_page');

// Words
Route::get('/reader/words', 'WordsController@showPage')->name('reader_words');

// Words
Route::post('/reader/words/add', 'WordsController@ajaxAddNewWord')->name('reader_add_new_word');
Route::post('/reader/words/update', 'WordsController@ajaxUpdateWordState')->name('reader_update_word');
Route::post('/reader/words/update2', 'WordsController@ajaxUpdateWordStateFromPageReader')->name('reader_update_word2');

Route::post('/reader/word/translate/', 'WordsController@getTranslationFromDatabase')->name('reader_get_translation');

