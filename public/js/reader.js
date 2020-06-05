
function showLoadingOverlay() {
    $.LoadingOverlay("show");
}


$( document ).ready(function() {

const word_new = 0;
const word_to_study = 1;
const word_known = 2;

if( Cookies.get('new_to_known') == 1) {
    var new_word_state_on_click = word_to_study;
} else {
    var new_word_state_on_click = word_known;
}



// Set file name in file input

$('#text_file').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $('.custom-file-label').html(fileName);
});


/*******************************************************************************************************************
 * TEXT PAGE (READER) - click on new word checkbox
 *******************************************************************************************************************/

$("#new_to_known").change(function() {

    if(this.checked == true) {
        new_word_state_on_click = word_known;
        Cookies.set('new_to_known', 1);
    } else {
        new_word_state_on_click = word_to_study;
        Cookies.set('new_to_known', 0);
    }

    location.reload();

});


if(Cookies.get('new_to_known') == 1) {
    $("#new_to_known").prop('checked', true);
}



/*******************************************************************************************************************
* MY TEXTS PAGE - text edit modal
*******************************************************************************************************************/

$('a[data-target="#text_edit_modal"]').on('click',function(){
    // set text id
    $('#text_id').val($(this).attr('data-text_id'));

    // set title
    $('#text_title').val($(this).attr('data-text_title'));
});

/*******************************************************************************************************************
 * WORDS and TEXT STATS PAGE - ADD NEW WORD AND TRANSLATION OR UPDATE WORD STATE
 *******************************************************************************************************************/


$('td').on('click', 'button.word_btn', function(){

    button = $(this);
    td = $(this).parent();
    translationTableCell = $(this).parent().parent().children('td').eq(2);

    wordText = $(this).parent().parent().children('td').eq(1).text();

    $.ajax({

        url: "/reader/words/add-or-update",
        method: "POST",
        data: {
            "id": button.attr('data-word_id'),
            "word": button.attr('data-word'),
            "state": button.attr('data-state'),
        },

        success: function (data) {

            // Фикс чтобы не заменять инпут на текст на странице Мои Слова
            if (window.location.href.indexOf("reader/words") <= -1) {
                translationTableCell.text(data[1]);
            }


            translation = '<span class="translation" style="display: none;">('+ data[1] +')</span>';

            if(button.hasClass('btn-success')) {

                button.replaceWith('<span class="badge badge-success h4">Known</span>');
                td.find('span.badge-warning').replaceWith('<button type="button" class="btn btn-warning btn-sm word_btn" data-word_id="' + data[0] + '" data-state="'+ word_to_study +'">To study</button>');
                td.find('button.btn-warning').replaceWith('<button type="button" class="btn btn-warning btn-sm word_btn" data-word_id="' + data[0] + '" data-state="'+ word_to_study +'">To study</button>');


            } else {

                button.replaceWith('<span class="badge badge-warning h4">To study</span>');
                td.find('span.badge-success').replaceWith('<button type="button" class="btn btn-success btn-sm word_btn" data-word_id="' + data[0]  + '" data-state="'+ word_known +'">Known</button>');
                td.find('button.btn-success').replaceWith('<button type="button" class="btn btn-success btn-sm word_btn" data-word_id="' + data[0]  + '" data-state="'+ word_known +'">Known</button>');

            }
        }
    });
});

/*******************************************************************************************************************
 * TEXT PAGE (READER) - FILTERS
 *******************************************************************************************************************/


// При загрузке страницы проверить какие слова нужно выделить и выделить эти слова
// Выделить / скрыть новые / изучаемые слова

if(Cookies.get('h_known') == 0) {
    $("mark[data-state='" + word_to_study + "']").each(function(index,element) {
        $(element).removeClass('study');
        $(element).addClass('study_hidden');
    });
}

if(Cookies.get('h_unknown') == 0) {
    $("mark[data-state='" + word_new + "']").each(function(index,element) {
        $(element).removeClass('unknown');
        $(element).addClass('unknown_hidden');
    });
}


/*******************************************************************************************************************
 * TEXT PAGE (READER) - КЛИК НА НЕЗНАКОМОЕ СЛОВО / СЛОВО БЕЗ ПЕРЕВОДА
 *******************************************************************************************************************/

$('div.page_text_wrapper').on('click', 'mark.unknown, mark.unknown_hidden', function() {

    word = $(this);

    // Ajax запрос на перевод слова. Сохраняет слово или перевод в базе и возвращается перевод
    // Перевод запрашивается только для новых слов, которых еще нет в базе или у которых в базе нет перевода

    if($(word).attr('data-state') == word_new)
    {
        $.ajax({

            url: "/reader/words/add-or-update",
            method: "POST",
            data: {
                "id": word.attr('data-word_id'),
                "word": word.attr('data-word'),
                "state": word.attr('data-state'),
                "new_to_known": new_word_state_on_click
            },

            success: function (data) {

                // Добавить слову перевод - дочерний span элемент
                translationText = data[1].split(",")[0];
                translation = '<span class="translation" style="display: none;">('+ translationText +')</span>';

                word.attr('data-word_id', data[0]);

                // Для повторений этого слова на странице
                // Заменить класс на study, так как новое слово по умолчанию становится изучаемым
                // изменить data-state на 1
                // добавить data-word_id

                $('mark[data-word="'+ word.attr('data-word') +'" i]').each(function(index,element)
                {
                    $(element).attr('data-word_id', data[0]);
                    $(element).attr('data-state', word_to_study);
                    $(element).html( translation + ' ' + word.attr('data-word'));
                    $(element).removeClass('unknown');

                    if(new_word_state_on_click == 1) {
                        $(element).addClass('known');
                    } else {
                        $(element).addClass('study');
                    }


                });

                // открыть перевод
                word.find('span').toggle();

                // Указать текст и перевод слова в правом сайдбаре
                wordText = word.clone().children().remove().end().text();
                $('#rs_word').html(wordText);
                $('#rs_word_translation').val(data[1]);

                // Кнопки статуса в правом сайдбаре
                // установить word_id

                $('#rs_mark_as_known_btn').attr('data-word_id', data[0]);
                $('#rs_mark_as_to_study_btn').attr('data-word_id', data[0]);

            }
        });
    }
});

/*******************************************************************************************************************
* TEXT PAGE (READER) - КЛИК НА ЗНАКОМОЕ СЛОВО (KNOWN, TO_STUDY)
*******************************************************************************************************************/

$('div.page_text_wrapper').on('click', 'mark.study, mark.known, mark.study_hidden', function() {

    word = $(this);
    word.find('span').toggle(); // показать / скрыть перевод

    // Указать текст и перевод слова в правом сайдбаре

    wordText = word.clone().children().remove().end().text();
    wordTranslation = word.find('span').text().replace('(', '').replace(')', '');

    $('#rs_word').html(wordText);
    $('#rs_word_translation').html(wordTranslation);


    $.ajax({
        url: "/reader/words/get-translation",
        method: "POST",
        data: {
            "word_id": word.attr('data-word_id'),
        },

        success: function (data) {
            $('#rs_word_translation').val(data);
        }

    });

    // указать state слова в правом сайдбаре

    if(word.attr('data-state') == word_new || word.attr('data-state') == word_to_study) {
        $('#rs_word_state').replaceWith('<span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">To study</span>')
    } else {
        $('#rs_word_state').replaceWith('<span class="badge badge-success h4" id="rs_word_state" style="vertical-align: middle">Known</span>')
    }


    // добавить word_id кнопкам статуса в правом сайдбаре

    $('#rs_mark_as_known_btn').attr('data-word_id', word.attr('data-word_id'));
    $('#rs_mark_as_to_study_btn').attr('data-word_id', word.attr('data-word_id'));

    //указать ссылку в кнопке "Translate in google" в правом сайдбаре

    googleUrl = 'https://translate.google.com/#view=home&op=translate&sl='+ learned_lang_code +'&tl='+ known_lang_code +'&text=' + wordText;
    $('#gt_btn').attr('href', googleUrl);

    yandexUrl = 'https://translate.yandex.com/?lang='+ learned_lang_code +'-'+ known_lang_code +'&text=' + wordText;
    $('#yt_btn').attr('href', yandexUrl);

    //

    // if(word.hasClass("unknown_mw")) {
    //     $("#rs_mark_as_to_study_btn").trigger("click");
    // }
});


/*******************************************************************************************************************
 * TEXT PAGE (READER) - КНОПКИ KNOWN / TO_STUDY В ПРАВОМ САЙДБАРЕ
 *******************************************************************************************************************/

$('.text_page_sidebar').on('click', '#rs_mark_as_known_btn, #rs_mark_as_to_study_btn', function() {

    button = $(this);

    data_word_id = button.attr('data-word_id');
    data_word = button.attr('data-word');
    data_state = button.attr('data-state');

    // Обновить статус слова

    $.ajax({
        url: "/reader/words/add-or-update",
        method: "POST",
        data: {
            "id": data_word_id,
            "word": data_word,
            "state": data_state,
        },

        success: function (data) {

            // Найти все копии слова в тексте, установить им новый статус

            if(button.attr('data-state') == word_to_study)
            {

                $('mark[data-word_id="'+ data_word_id +'"]').each(function(index,element) {
                    $(element).attr('data-word_id', data_word_id);
                    $(element).attr('data-state', word_to_study);
                    $(element).removeClass();
                    $(element).addClass('study');
                });

                $('#rs_word_state').replaceWith('<span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">To study</span>');

            } else {

                $('mark[data-word_id="'+ data_word_id +'"]').each(function(index,element) {
                    $(element).attr('data-word_id', data_word_id);
                    $(element).attr('data-state', word_known);
                    $(element).removeClass();
                    $(element).addClass('known');
                });


                $('#rs_word_state').replaceWith('<span class="badge badge-success h4" id="rs_word_state" style="vertical-align: middle">Known</span>');
            }

            showAndHideSuccessNotification();
        }
    });
});

/*******************************************************************************************************************
* TEXT PAGE (READER) - КНОПКA SAVE TRANSLATION В ПРАВОМ САЙДБАРЕ
*******************************************************************************************************************/

$('.text_page_sidebar').on('click', '#rs_save_translation_btn', function() {

// Обновить перевод слова / указать свой перевод и сохранить

    $.ajax({
        url: "/reader/words/update-translation",
        method: "POST",
        data: {
            "word_id": $('#rs_mark_as_known_btn').attr('data-word_id'),
            "word_translation": $('#rs_word_translation').val()
        },

        success: function (data) {

            // Найти все копии слова в тексте, установить им новый перевод

            $('mark[data-word_id="'+ data[0] +'"]').each(function(index,element) {
                translation = data[1].split(",")[0];
                $(element).find('span').text("(" +translation + ") ");
            });

            showAndHideSuccessNotification();

        }
    });

});
/*******************************************************************************************************************
* TEXT PAGE (READER) - Highlight to study words
*******************************************************************************************************************/

$("#h_known").change(function() {

    selector = "mark[data-state='" + word_to_study + "']";

    if(this.checked == false) {

        $(selector).each(function(index,element) {
            $(element).removeClass('study');
            $(element).addClass('study_hidden');
        });

        Cookies.set('h_known', 0);

    } else {

        $(selector).each(function(index,element) {
            $(element).removeClass('study_hidden');
            $(element).addClass('study');
        });

        Cookies.set('h_known', 1);
    }
});

/*******************************************************************************************************************
* TEXT PAGE (READER) - Highlight unknown words
*******************************************************************************************************************/

$("#h_unknown").change(function() {

    selector = "mark[data-state='" + word_new + "']";

    if(this.checked == false) {

        $(selector).each(function(index,element) {
            $(element).removeClass('unknown');
            $(element).addClass('unknown_hidden');
        });

        Cookies.set('h_unknown', 0);

    } else {

        $(selector).each(function(index,element) {
            $(element).removeClass('unknown_hidden');
            $(element).addClass('unknown');
        });

        Cookies.set('h_unknown', 1);
    }
});



// Right sidebar - open window on translate buttons click - google translate

$('.text_page_sidebar').on('click', '#gt_btn', function() {

    url = 'https://translate.google.com/#view=home&op=translate&sl='+ learned_lang_code +'&tl='+ known_lang_code +'&text=' + $('#rs_word').html();

    window.open(url, 'window name', 'width=900, height=700');
    return false;

});

// Right sidebar - open window on translate buttons click - yandex translate

$('.text_page_sidebar').on('click', '#yt_btn', function() {

    url = 'https://translate.yandex.com/?lang='+ learned_lang_code +'-'+ known_lang_code +'&text=' + $('#rs_word').html();

    window.open(url, 'window name', 'width=900, height=700');
    return false;

});

/*******************************************************************************************************************
* MANAGE WORDS PAGE
*******************************************************************************************************************/

// Delete word

$('.admin_word_delete_btn').on('click', function() {

    delete_button = $(this);

    $.ajax({
        url: "/reader/words/delete",
        method: "POST",
        data: {
            "word_id": delete_button.attr('data-word_id'),
        },

        success: function (data) {
            // hide table row
            delete_button.parent().parent().hide();
        }
    });
});

// Update translation

$('.admin_word_save_btn').on('click', function() {

    save_button = $(this);
    translation = save_button.prev().val();

    $.ajax({
        url: "/reader/words/update-translation",
        method: "POST",
        data: {
            "word_id": save_button.attr('data-word_id'),
            "word_translation": translation
        },

        success: function (data) {
        }
    });

    showAndHideSuccessNotification();
});


function showAndHideSuccessNotification() {
    $('#alert').toggle();

    setTimeout(function() {
        $('#alert').toggle();
    }, 1000);

}

/*******************************************************************************************************************
* MARK ALL WORDS ON TEXT PAGE AS KNOWN OR TO STUDY
*******************************************************************************************************************/


    $('#mark_all_as_to_study').on('click', function() {
        recursive(word_to_study);
        $('#mark_all_as_to_study').prop('disabled', true);
        $('#mark_all_as_known_btn').prop('disabled', true);
    });

    $('#mark_all_as_known_btn').on('click', function() {
        recursive(word_known);
        $('#mark_all_as_to_study').prop('disabled', true);
        $('#mark_all_as_known_btn').prop('disabled', true);
    });


    function recursive(wordStateToSet) {
        var myFunc = markAllWordsAs(wordStateToSet);
        $.when(myFunc).done(function (data) {

            if(wordStateToSet == word_to_study) {
                selector = 'div.page_text_wrapper mark.unknown, div.page_text_wrapper mark.known';
            } else {
                selector = 'div.page_text_wrapper mark.study, div.page_text_wrapper mark.unknown';
            }

            if($(selector).length) {
                recursive(wordStateToSet);
            } else {
                $('#mark_all_as_to_study').prop('disabled', false);
                $('#mark_all_as_known_btn').prop('disabled', false);
            }
        });
    }


    function markAllWordsAs(wordStateToSet) {

        if(wordStateToSet == word_to_study) {
            word = $('div.page_text_wrapper mark.unknown, div.page_text_wrapper mark.known').first();
            newClass = "study";
        } else {
            word = $('div.page_text_wrapper mark.unknown, div.page_text_wrapper mark.study').first();
            newClass = "known";
        }

        return $.ajax({

            url: "/reader/words/add-or-update",
            method: "POST",
            data: {
                "id": word.attr('data-word_id'),
                "word": word.attr('data-word'),
                "state": wordStateToSet,
            },

            success: function (data) {
                // Добавить слову перевод - дочерний span элемент
                translationText = data[1].split(",")[0];
                translation = '<span class="translation" style="display: none;">('+ translationText +')</span>';

                word.attr('data-word_id', data[0]);

                $('mark[data-word="'+ word.attr('data-word') +'" i]').each(function(index,element) {
                    $(element).attr('data-word_id', data[0]);
                    $(element).attr('data-state', wordStateToSet);
                    $(element).html( translation + ' ' + word.attr('data-word'));
                    $(element).removeClass('unknown');
                    $(element).removeClass('study');
                    $(element).removeClass('known');
                    $(element).addClass(newClass);
                });
            } // ajax success end
        }); // ajax end
    }

/*******************************************************************************************************************
* MARK ALL WORDS ON TEXT_PAGE_WORDS PAGE AS KNOWN OR TO STUDY
*******************************************************************************************************************/

    $('#mark_all_as_to_study_on_words_page').on('click', function() {
        recursive2(word_to_study);
        $('#mark_all_as_to_study_on_words_page').prop('disabled', true);
        $('#mark_all_as_known_on_words_page').prop('disabled', true);
    });

    $('#mark_all_as_known_on_words_page').on('click', function() {
        recursive2(word_known);
        $('#mark_all_as_to_study_on_words_page').prop('disabled', true);
        $('#mark_all_as_known_on_words_page').prop('disabled', true);
    });


    function recursive2(wordStateToSet) {
        var myFunc2 = markAllWordsAs2(wordStateToSet);
        $.when(myFunc2).done(function (data) {

            if(wordStateToSet == word_to_study) {
                selector = 'button.btn-warning.word_btn';
            } else {
                selector = 'button.btn-success.word_btn';
            }

            if($(selector).length) {
                recursive2(wordStateToSet);
            } else {
                $('#mark_all_as_to_study_on_words_page').prop('disabled', false);
                $('#mark_all_as_known_on_words_page').prop('disabled', false);
            }
        });
    }


    function markAllWordsAs2(wordStateToSet) {

        if(wordStateToSet == word_to_study) {
            button = $('button.btn-warning.word_btn').first();
        } else {
            button = $('button.btn-success.word_btn').first();
        }

        td = button.parent();
        translationTableCell = button.parent().parent().children('td').eq(2);

        wordText = button.parent().parent().children('td').eq(1).text();

        return $.ajax({

            url: "/reader/words/add-or-update",
            method: "POST",
            data: {
                "id": button.attr('data-word_id'),
                "word": button.attr('data-word'),
                "state": button.attr('data-state'),
            },

            success: function (data) {

                translation = '<span class="translation" style="display: none;">('+ data[1] +')</span>';

                if(button.hasClass('btn-success')) {
                    button.replaceWith('<span class="badge badge-success h4">Known</span>');
                    td.find('span.badge-warning').replaceWith('<button type="button" class="btn btn-warning btn-sm word_btn" data-word_id="' + data[0] + '" data-state="'+ word_to_study +'">To study</button>');
                    td.find('button.btn-warning').replaceWith('<button type="button" class="btn btn-warning btn-sm word_btn" data-word_id="' + data[0] + '" data-state="'+ word_to_study +'">To study</button>');
                } else {
                    button.replaceWith('<span class="badge badge-warning h4">To study</span>');
                    td.find('span.badge-success').replaceWith('<button type="button" class="btn btn-success btn-sm word_btn" data-word_id="' + data[0]  + '" data-state="'+ word_known +'">Known</button>');
                    td.find('button.btn-success').replaceWith('<button type="button" class="btn btn-success btn-sm word_btn" data-word_id="' + data[0]  + '" data-state="'+ word_known +'">Known</button>');
                }
            }
        });
    }

}); // document ready end
