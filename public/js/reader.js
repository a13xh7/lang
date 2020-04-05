$( document ).ready(function() {

const word_new = 0;
const word_to_study = 1;
const word_known = 2;

// Set file name in file input

$('#text_file').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $('.custom-file-label').html(fileName);
});


/*******************************************************************************************************************
* MY TEXTS PAGE - text edit modal
*******************************************************************************************************************/

$('a[data-target="#text_edit_modal"]').on('click',function(){
    // set text id
    $('#text_id').val($(this).data('text_id'));

    // set title
    $('#text_title').val($(this).data('text_title'));
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
            "id": button.data('word_id'),
            "word": button.data('word'),
            "state": button.data('state'),
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

                // Найти слово в тексте, добавить перевод и прочие аттрибуты

                $('mark[data-word="'+ wordText +'" i]').each(function(index,element)
                {
                    $(element).attr('data-word_id', data[0]);
                    $(element).data('state', word_known);
                    $(element).html( translation + ' ' + wordText);
                    $(element).removeClass('unknown');
                    $(element).addClass('known');
                });

            } else {

                button.replaceWith('<span class="badge badge-warning h4">To study</span>');
                td.find('span.badge-success').replaceWith('<button type="button" class="btn btn-success btn-sm word_btn" data-word_id="' + data[0]  + '" data-state="'+ word_known +'">Known</button>');
                td.find('button.btn-success').replaceWith('<button type="button" class="btn btn-success btn-sm word_btn" data-word_id="' + data[0]  + '" data-state="'+ word_known +'">Known</button>');

                // Найти слово в тексте, добавить перевод и прочие аттрибуты

                $('mark[data-word="'+ wordText +'" i]').each(function(index,element)
                {
                    $(element).attr('data-word_id', data[0]);
                    $(element).data('state', word_to_study);
                    $(element).html( translation + ' ' + wordText);
                    $(element).removeClass('unknown');
                    $(element).addClass('study');
                });

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
    });
}

if(Cookies.get('h_unknown') == 0) {
    $("mark[data-state='" + word_new + "']").each(function(index,element) {
        $(element).removeClass('unknown');
    });
}


/*******************************************************************************************************************
 * TEXT PAGE (READER) - КЛИК НА НЕЗНАКОМОЕ СЛОВО / СЛОВО БЕЗ ПЕРЕВОДА
 *******************************************************************************************************************/

$('div.page_text_wrapper').on('click', 'mark[data-state="0"]', function() {

    word = $(this);

    // Ajax запрос на перевод слова. Сохраняет слово или перевод в базе и возвращается перевод
    // Перевод запрашивается только для новых слов, которых еще нет в базе или у которых в базе нет перевода

    if($(word).data('state') == word_new)
    {
        $.ajax({

            url: "/reader/words/add-or-update",
            method: "POST",
            data: {
                "id": word.data('word_id'),
                "word": word.data('word'),
                "state": word.data('state'),
            },

            success: function (data) {

                // Добавить слову перевод - дочерний span элемент

                translation = '<span class="translation" style="display: none;">('+ data[1] +')</span>';

                word.attr('data-word_id', data[0]);

                // Для повторений этого слова на странице
                // Заменить класс на study, так как новое слово по умолчанию становится изучаемым
                // изменить data-state на 1
                // добавить data-word_id

                $('mark[data-word="'+ word.data('word') +'" i]').each(function(index,element)
                {
                    $(element).attr('data-word_id', data[0]);
                    $(element).data('state', word_to_study);
                    $(element).html( translation + ' ' + word.data('word'));
                    $(element).removeClass('unknown');
                    $(element).addClass('study');
                });

                // открыть перевод
                word.find('span').toggle();

                // Указать текст и перевод слова в правом сайдбаре
                wordText = word.clone().children().remove().end().text();
                $('#rs_word').html(wordText);
                $('#rs_word_translation').html(data[1]);

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
            "word_id": word.data('word_id'),
        },

        success: function (data) {
            $('#rs_word_translation').html(data);
        }

    });

    // указать state слова в правом сайдбаре

    if(word.data('state') == word_new || word.data('state') == word_to_study) {
        $('#rs_word_state').replaceWith('<span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">To study</span>')
    } else {
        $('#rs_word_state').replaceWith('<span class="badge badge-success h4" id="rs_word_state" style="vertical-align: middle">Known</span>')
    }

    // добавить word_id кнопкам статуса в правом сайдбаре

    $('#rs_mark_as_known_btn').attr('data-word_id', word.data('word_id'));
    $('#rs_mark_as_to_study_btn').attr('data-word_id', word.data('word_id'));

    //указать ссылку в кнопке "Translate in google" в правом сайдбаре

    googleUrl = 'https://translate.google.com/#view=home&op=translate&sl='+ learned_lang_code +'&tl='+ known_lang_code +'&text=' + wordText;
    $('#gt_btn').attr('href', googleUrl);

    yandexUrl = 'https://translate.yandex.com/?lang='+ learned_lang_code +'-'+ known_lang_code +'&text=' + wordText;
    $('#yt_btn').attr('href', yandexUrl);
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
            "word_id": $('#rs_mark_as_known_btn').data('word_id'),
            "word_translation": $('#rs_word_translation').val()
        },

        success: function (data) {

            // Найти все копии слова в тексте, установить им новый перевод

            $('mark[data-word_id="'+ data[0] +'"]').each(function(index,element) {
                $(element).find('span').text("(" +data[1] + ") ");
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
            "word_id": delete_button.data('word_id'),
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
            "word_id": save_button.data('word_id'),
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

/////////////////////////////////////////////

$('#mark_all_as_known_btn').on('click', function() {

    // $('mark.unknown').each(function(index,element) {
    //
    //     word = $(element);
    //
    //     if(word.data('state') == word_new) {
    //
    //         $.ajax({
    //
    //             url: "/reader/words/add-or-update",
    //             method: "POST",
    //             async:false,
    //             data: {
    //                 "id": word.data('word_id'),
    //                 "word": word.data('word'),
    //                 "state": word.data('state'),
    //             },
    //
    //             success: function (data) {
    //
    //                 console.log(element);
    //
    //
    //                 // Добавить слову перевод - дочерний span элемент
    //
    //                 translation = '<span class="translation" style="display: none;">('+ data[1] +')</span>';
    //
    //                 word.attr('data-word_id', data[0]);
    //
    //                 // Для повторений этого слова на странице
    //                 // Заменить класс на study, так как новое слово по умолчанию становится изучаемым
    //                 // изменить data-state на 1
    //                 // добавить data-word_id
    //
    //                 $('mark[data-word="'+ word.data('word') +'" i]').each(function(index,element) {
    //                     $(element).attr('data-word_id', data[0]);
    //                     $(element).data('state', word_to_study);
    //                     $(element).html( translation + ' ' + word.data('word'));
    //                     $(element).removeClass('unknown');
    //                     $(element).addClass('study');
    //                     console.log("word copy found");
    //                 });
    //             } // ajax success end
    //         }); // ajax end
    //
    //     } // end if
    //
    // });

recursive();
    //showAndHideSuccessNotification();
});



function recursive() {

    word = $('mark.unknown').first();

    if(word.length) {

        $.ajax({

            url: "/reader/words/add-or-update",
            method: "POST",
            data: {
                "id": word.data('word_id'),
                "word": word.data('word'),
                "state": word.data('state'),
            },

            success: function (data) {
                alert( word.attr('data-word'));
                return;
                // Добавить слову перевод - дочерний span элемент

                translation = '<span class="translation" style="display: none;">('+ data[1] +')</span>';

                word.attr('data-word_id', data[0]);

                // Для повторений этого слова на странице
                // Заменить класс на study, так как новое слово по умолчанию становится изучаемым
                // изменить data-state на 1
                // добавить data-word_id

                $('mark[data-word="'+ word.data('word') +'" i]').each(function(index,element) {
                    $(element).attr('data-word_id', data[0]);
                    $(element).data('state', word_to_study);
                    $(element).html( translation + ' ' + word.data('word'));
                    $(element).removeClass('unknown');
                    $(element).addClass('study');
                    console.log("word copy found");
                });
                console.log('ajax success');
                recursive();
                console.log('ajax success 222');
            } // ajax success end

        }); // ajax end

    } // if end
}


}); // document ready end
