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
Route::get('/reader/words_admin', 'WordsController@showAdminPage')->name('words_admin');
Route::get('/reader/upload_dictionary', 'WordsController@showUploadDictionaryPage')->name('words_upload_dictionary');

// Words ajax - add and update state
Route::post('/reader/words/add', 'WordsController@ajaxAddNewWord')->name('add_new_word');
Route::post('/reader/words/update', 'WordsController@ajaxUpdateWordState')->name('update_word');

// Words ajax - delete word / translation
Route::post('/reader/words/delete', 'WordsController@ajaxDeleteWord')->name('delete_word');
Route::post('/reader/translation/delete', 'WordsController@ajaxDeleteTranslation')->name('delete_translation');

// Delete all words
Route::get('/reader/words/delete-all', 'WordsController@deleteAllWords')->name('delete_all_words');

// Upload dictionary
Route::post('/reader/words/upload', 'WordsController@uploadDictionary')->name('words_upload');

// Upload dictionary
