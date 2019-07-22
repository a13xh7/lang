
// SET HIGHT

//$('header').height() + $('footer').height()

var mainHeight = window.innerHeight - ( 65+80 );

$('main').css("min-height", mainHeight);
$('.sidebar').css("min-height", mainHeight);

$( document ).ready(function() {

const show_all_words = 0;
const show_unknown_words = 1;
const show_known_words = 2;

const word_new = 0;
const word_to_study = 1;
const word_known = 2;



// CSRF init

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



// Set file name in file input

$('#text_file').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $('.custom-file-label').html(fileName);
});

// TEXT PAGE / READER PAGE-----------------------------------------------------------------------------------------

/*
* При клике на слово:
*
* Если слово новое / незнакомое -
*    добавить его в базу,
*    получить перевод,
*    добавить перевод в скобки рядом со словом
*    убрать стиль / выделение цветом у слова
*    добавить слово в правый сайдбар
*    найти повторения этого слова в тексте и добавить им перевод и убрать выделение цветом
*
*/
$('div.page_text_wrapper').on('click', 'mark.study, mark.unknown', function() {

    word = $(this);

    if($(this).data('state') == word_new) {
            $.ajax({
                url: "/reader/words/add",
                method: "POST",
                data: {"word": $(this).data('word'),
                    "lang_id": $(this).data('lang_id'),
                    "translate_to_lang_id": $(this).data('translate_to_lang_id'),
                    "state": $(this).data('state')
                },

                success: function (data) {

                    translation = '<span class="translation">('+ data +')</span>';

                    // word.html( translation + ' ' + word.html());
                    // alert( 'mark[data-word="'+ word.data('word') +'"]');

                    $('mark[data-word="'+ word.data('word') +'"]').each(function(index,element) {
                        $(element).removeClass();
                        $(element).html( translation + ' ' + word.html());
                    });

                }
            });

    } else if($(this).data('state') == word_to_study) {

        $.ajax({
            url: "/reader/word/translate/",
            method: "POST",
            data: {"word": $(this).data('word'),
                "lang_id": $(this).data('lang_id'),
                "translate_to_lang_id": $(this).data('translate_to_lang_id'),
            },

            success: function (data) {

                translation = '<span class="translation">('+ data +')</span>';

                $('mark[data-word="'+ word.data('word') +'"]').each(function(index,element) {
                    $(element).removeClass();
                    $(element).html( translation + ' ' + word.html());
                });

            }
        });
    }




});




// USER TEXTS PAGE ----------------------------------------------------------------------------------------------------


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




// MY WORDS PAGE -  -----------------------------------------------------------------------------------------------

// word language filter
$('#w_lang').on('change', function(){

    document.cookie = "w_lang=" + $(this).val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC"

    url = window.location.href.split('?')[0];
    location.href = url;
});

// word translation language filter
$('#wt_lang').on('change', function(){

    document.cookie = "wt_lang=" + $(this).val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC"

    url = window.location.href.split('?')[0];
    location.href = url;
});



//AJAX - update word state
// 1 - to study
// 2 - known

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
        data: {"word_id": $(this).data('word_id'), "state": $(this).data('state') },

        success: function (data) {

        }
    });

});


// TEXTS STATS PAGE - filter words ----------------------------------------------------------------------------------

// AJAX - add new word to study
$('button.word_btn').on('click',function(){

    $(this).prev().hide();
    $(this).next().hide();

    if($(this).data('state') == 1) {
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


        }
    });

});


//WORD FILTERS - SET ACTIVE

if(Cookies.get('show_words') == show_all_words) {
    $('#show_all_words').prop( "disabled", true );
}

if(Cookies.get('show_words') == show_unknown_words) {
    $('#show_unknown_words').prop( "disabled", true );
}

if(Cookies.get('show_words') == show_known_words) {
    $('#show_known_words').prop( "disabled", true );
}

//WORD FILTERS - SELECT

$('#show_all_words').on('click',function(){
    document.cookie = "show_words=0; expires=Thu, 18 Dec 2023 12:00:00 UTC";

    url = window.location.href.split('?')[0];
    location.href = url;
});

$('#show_unknown_words').on('click',function(){
    document.cookie = "show_words=1; expires=Thu, 18 Dec 2023 12:00:00 UTC";

    url = window.location.href.split('?')[0];
    location.href = url;
});

$('#show_known_words').on('click',function(){
    document.cookie = "show_words=2; expires=Thu, 18 Dec 2023 12:00:00 UTC";

    url = window.location.href.split('?')[0];
    location.href = url;
});




}); // document ready end