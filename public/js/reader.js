$( document ).ready(function() {

const word_new = 0;
const word_to_study = 1;
const word_known = 2;

// CSRF init
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

// Set file name in file input

$('#text_file').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $('.custom-file-label').html(fileName);
});


/*******************************************************************************************************************
* MY TEXTS PAGE
*******************************************************************************************************************/

// Update text modal window. Set form fields values

$('a[data-target="#text_edit_modal"]').on('click',function(){

    // set text id
    $('#text_id').val($(this).data('text_id'));

    // set title
    $('#text_title').val($(this).data('text_title'));

    // set text language
    $("#lang_from").val($(this).data('text_lang')).change();

    // set translate to language
    $("#lang_to").val($(this).data('translate_to_lang_id')).change();
});

/*******************************************************************************************************************
 * MY WORDS PAGE
 *******************************************************************************************************************/

// word language filter

$('#w_lang').on('change', function(){
    document.cookie = "w_lang=" + $(this).val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";
    url = window.location.href.split('?')[0];
    location.href = url;
});

// word translation language filter

$('#wt_lang').on('change', function(){
    document.cookie = "wt_lang=" + $(this).val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";
    url = window.location.href.split('?')[0];
    location.href = url;
});


// Update word state - known or to study

$('td').on('click', 'button.words_btn', function(){

    td = $(this).parent();

    if(td.find('button').hasClass('btn-success')) {
        td.find('button').replaceWith('<span class="badge badge-success h4">Known</span>');
        td.find('span.badge-warning').replaceWith('<button type="button" class="btn btn-warning btn-sm words_btn" data-word_id="' + $(this).data('word_id') + '" data-state="'+ word_to_study +'">To study</button>');
    } else {
        td.find('button').replaceWith('<span class="badge badge-warning h4">To study</span>');
        td.find('span.badge-success').replaceWith('<button type="button" class="btn btn-success btn-sm words_btn" data-word_id="' + $(this).data('word_id') + '" data-state="'+ word_known +'">Known</button>');
    }

    $.ajax({

        url: "/reader/words/update",
        method: "POST",
        data: {
            "word_id": $(this).data('word_id'),
            "state": $(this).data('state'),
            "wt_lang_id": wt_lang_id
        },

        success: function (data) {
        }
    });

});

/*******************************************************************************************************************
 * TEXTS STATS PAGE
 *******************************************************************************************************************/

// Add new word to database with known or to_study state

$('td').on('click', 'button.text_stats_word_btn', function(){

    td = $(this).parent();
    translationTableCell = $(this).parent().parent().children('td').eq(2);

    $(this).prev().hide();
    $(this).next().hide();

    if($(this).data('state') == word_to_study) {
        $(this).replaceWith('<span class="badge badge-warning h4">To study</span>')
    } else {
        $(this).replaceWith('<span class="badge badge-success h4">Known</span>')
    }

    $.ajax({
        url: "/reader/words/add",
        method: "POST",
        data: {"word": $(this).data('word'),
            "lang_id": $(this).data('lang_id'),
            "translate_to_lang_id": $(this).data('translate_to_lang_id'),
            "state": $(this).data('state')
        },

        success: function (data) {
            // add tranlation to table
            translationTableCell.text(data[1]);
        }
    });

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


// Delete translation

$('.admin_translation_delete_btn').on('click', function() {

    delete_button = $(this);

    $.ajax({
        url: "/reader/translation/delete",
        method: "POST",
        data: {
            "translation_id": delete_button.data('translation_id'),
        },

        success: function (data) {
            // hide table row
            delete_button.parent().parent().hide();
        }
    });
});

/*******************************************************************************************************************
 * TEXT PAGE (READER)
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
            url: "/reader/words/add",
            method: "POST",
            data: {
                "word": $(this).data('word'),
                "lang_id": $(this).data('lang_id'),
                "translate_to_lang_id": $(this).data('translate_to_lang_id'),
                "state": $(this).data('state')
            },

            success: function (data) {

                // Добавить слову перевод - дочерний span элемент

                translation = '<span class="translation" style="display: none;">('+ data[1] +')</span>';

                word.attr('data-word_id', data[0]);

                // Для повторений этого слова на странице
                // Заменить класс на study, так как новое слово по умолчанию становится изучаемым
                // изменить data-state на 1
                // добавить data-word_id

                $('mark[data-word="'+ word.data('word') +'"]').each(function(index,element)
                {
                    $(element).attr('data-word_id', data[0]);
                    $(element).data('state', word_to_study);
                    $(element).html( translation + ' ' + word.data('word'));
                    $(element).removeClass('unknown');
                    $(element).addClass('study');
                });

                word.find('span').toggle();

                // добавить перевод слова в правом сайдбаре
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

$('div.page_text_wrapper').on('click', 'mark.known, mark.study', function() {

    word = $(this);
    word.find('span').toggle(); // показать / скрыть перевод

    // Указать текст и перевод слова в правом сайдбаре

    wordText = word.clone().children().remove().end().text();
    wordTranslation = word.find('span').text().replace('(', '').replace(')', '');

    $('#rs_word').html(wordText);
    $('#rs_word_translation').html(wordTranslation);

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

    googleUrl = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + wordText;
    $('#gt_btn').attr('href', googleUrl);

    yandexUrl = 'https://translate.yandex.com/?lang=' + text_lang_code + '-' + text_translate_to_lang_code +'&text=' + wordText;
    $('#yt_btn').attr('href', yandexUrl);
});


/*******************************************************************************************************************
 * TEXT PAGE (READER) - КНОПКИ KNOWN / TO_STUDY В ПРАВОМ САЙДБАРЕ
 *******************************************************************************************************************/

$('.text_page_sidebar').on('click', '#rs_mark_as_known_btn, #rs_mark_as_to_study_btn', function() {

    button = $(this);

    // Обновить статус слова

    $.ajax({
        url: "/reader/words/update",
        method: "POST",
        data: {
            "word_id": $(this).data('word_id'),
            "state": $(this).data('state'),
            "wt_lang_id": wt_lang_id
        },

        success: function (data) {

            // Найти все копии слова в тексте, установить им новый статус

            if(button.data('state') == word_to_study)
            {

                $('mark[data-word_id="'+ button.data('word_id') +'"]').each(function(index,element) {
                    $(element).attr('data-word_id', button.data('word_id'));
                    $(element).attr('state', word_to_study);
                    $(element).removeClass();
                    $(element).addClass('study');
                });

            } else {

                $('mark[data-word_id="'+ button.data('word_id') +'"]').each(function(index,element) {
                    $(element).attr('data-word_id', button.data('word_id'));
                    $(element).attr('state', word_known);
                    $(element).removeClass();
                    $(element).addClass('known');
                });

            }

        }
    });

    $('#rs_word_state').replaceWith('<span class="badge badge-success h4" id="rs_word_state" style="vertical-align: middle">Known</span>');
});

/*******************************************************************************************************************
* TEXT PAGE (READER) - Highlight to study words
*******************************************************************************************************************/

$("#h_known").change(function() {

    selector = "mark[data-state='" + word_to_study + "']";

    if(this.checked == false) {

        $(selector).each(function(index,element) {
            $(element).removeClass('study');
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
        });

        Cookies.set('h_unknown', 0);

    } else {

        $(selector).each(function(index,element) {
            $(element).addClass('unknown');
        });

        Cookies.set('h_unknown', 1);
    }
});

// T button - Open google translate in new window and translate selected text in google

$("body").keypress(function(e) {
    if (e.code == 'KeyT') {
        url = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + window.getSelection().toString();
        window.open(url, 'window name', 'width=900, height=700');
        return false;
    }
});

// Right sidebar - open window on translate buttons click - google translate

$('.text_page_sidebar').on('click', '#gt_btn', function() {

    url = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + $('#rs_word').html();

    window.open(url, 'window name', 'width=900, height=700');
    return false;

});

// Right sidebar - open window on translate buttons click - yandex translate

$('.text_page_sidebar').on('click', '#yt_btn', function() {

    url = 'https://translate.yandex.com/?lang=' + text_lang_code + '-' + text_translate_to_lang_code +'&text=' + $('#rs_word').html();

    window.open(url, 'window name', 'width=900, height=700');
    return false;

});


}); // document ready end
