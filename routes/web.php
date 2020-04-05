<?php

// Landings

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
Route::get('/reader/upload_dictionary', 'WordsController@showUploadDictionaryPage')->name('words_upload_dictionary');


//Settings
Route::get('/reader/settings', 'SettingsController@showPage')->name('settings');
Route::post('/reader/update-settings', 'SettingsController@updateSettings')->name('update_settings');

// Words ajax - add and update state
Route::post('/reader/words/add-or-update', 'WordsController@ajaxAddOrUpdateWord')->name('add_or_update_word');
Route::post('/reader/words/update', 'WordsController@ajaxUpdateWordState')->name('update_word');

// Add new word
Route::post('/reader/words/add-new', 'WordsController@addNewWord')->name('add_new_word');

// Words ajax - delete word
Route::post('/reader/words/delete', 'WordsController@ajaxDeleteWord')->name('delete_word');

// Words ajax - get translation
Route::post('/reader/words/get-translation', 'WordsController@ajaxGetWordTranslation')->name('get_translation');


// Words ajax - update translation
Route::post('/reader/words/update-translation', 'WordsController@ajaxUpdateWordTranslation')->name('update_translation');

// Delete all words
Route::get('/reader/words/delete-all', 'WordsController@deleteAllWords')->name('delete_all_words');

// Upload dictionary
Route::post('/reader/words/upload', 'WordsController@uploadDictionary')->name('words_upload');



Route::get('/generate', 'WordsController@generate');
