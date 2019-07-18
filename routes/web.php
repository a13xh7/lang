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

    //User settings
    Route::get('/user/settings/', 'Main\UserController@showUserSettingsPage')->name('main_user_settings');
    Route::post('/user/settings/', 'Main\UserController@updateUserSettings')->name('main_user_settings_update');
});




/****************************************************************
 * READER
 ****************************************************************/

Route::middleware(['auth'])->group(function ()
{
    // INDEX AND OTHER STATIC PAGES

    // ADD TEXT PAGE
    Route::get('/reader/add/text', 'Reader\AddTextController@showPage')->name('reader_add_text_page');
    Route::post('/reader/add/text', 'Reader\AddTextController@addText')->name('reader_add_text');

    // TEXTS PAGE
    Route::get('/reader/texts', 'Reader\TextsController@showTexts')->name('reader_texts');
    Route::post('/reader/texts/update', 'Reader\TextsController@updateText')->name('reader_update_text');
    Route::get('/reader/texts/delete/{textId}', 'Reader\TextsController@deleteText')->name('reader_delete_text');

    // TEXT STATS PAGE
    Route::get('/reader/texts/stats/{textId}', 'Reader\TextStatsController@showTextStats')->name('reader_text_stats');

    // TEXT PAGE. READ PAGE
    Route::get('/reader/read/text/{textId}', 'Reader\TextPageController@showPage')->name('reader_read_text_page');

    Route::get('/reader/words', 'Reader\WordsController@showPage')->name('reader_words');
    Route::get('/reader/words/new', 'Reader\WordsController@showNewWords')->name('reader_new_words');
    Route::get('/reader/words/known', 'Reader\WordsController@showKnownWords')->name('reader_known_words');

    // Words
    Route::post('/reader/words/add', 'Reader\WordsController@ajaxAddNewWord')->name('reader_add_new_word');
    Route::post('/reader/words/update', 'Reader\WordsController@ajaxUpdateWordState')->name('reader_update_word');

});

/****************************************************************
 * READ TOGETHER
 ****************************************************************/

Route::get('/read-together', 'PublicController@showReadTogetherLanding')->name('rt_landing');

Route::middleware(['auth'])->group(function ()
{

    Route::get('/rt/public-texts', 'RT\PublicTextsController@showPage')->name('rt_public_texts');

    Route::get('/rt/my-texts', 'RT\MyTextsController@showPage')->name('rt_my_texts');


});

/****************************************************************
 * Q & A
 ****************************************************************/

Route::get('/questions', 'QA\QuestionsController@showQuestionsIndexPage')->name('qa_index');
Route::get('/question/{questionId}', 'QA\QuestionController@showQuestionPage')->name('qa_question');

Route::middleware(['auth'])->group(function ()
{

    //Add question
    Route::get('/questions/add', 'QA\AddQuestionController@showPage')->name('qa_add_question_page');
    Route::post('/questions/add', 'QA\AddQuestionController@addQuestion')->name('qa_add_question');

    // Edit question
    Route::get('/questions/edit/{questionId}', 'QA\AddQuestionController@showEditPage')->name('qa_edit_question_page');
    Route::post('/questions/update', 'QA\AddQuestionController@updateQuestion')->name('qa_update_question');

    // add answer
    Route::post('/answer/add', 'QA\QuestionController@addAnswer')->name('qa_add_answer');

    // show my questions
    Route::get('/questions/my', 'QA\QuestionsController@showMyQuestions')->name('qa_my_questions');

});

