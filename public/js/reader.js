$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#text_file').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $('.custom-file-label').html(fileName);
});


// TEXTS PAGE ----------------------------------------------------------------------------------------------------


// TEXT UPDATE

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



//AJAX - update word state
// 1 - to study
// 2 - known
//$('button.words_btn').on('click', function(){
$('td').on('click', 'button.words_btn', function(){

    td = $(this).parent();

    if(td.find('button').hasClass('btn-success')) {
        td.find('button').replaceWith('<span class="badge badge-success h4">Known</span>');
        td.find('span.badge-warning').replaceWith('<button type="button" class="btn btn-warning btn-sm words_btn" data-word_id="' + $(this).data('word_id') + '" data-state="1">To study</button>');
    } else {
        td.find('button').replaceWith('<span class="badge badge-warning h4">To study</span>');
        td.find('span.badge-success').replaceWith('<button type="button" class="btn btn-success btn-sm words_btn" data-word_id="' + $(this).data('word_id') + '" data-state="2">Known</button>');
    }

    // td.children().remove();
    //
    //
    // if($(this).data('state') == 1) {
    //     td.append('<span class="badge badge-warning h4">To study</span>')
    // } else {
    //     td.append('<span class="badge badge-success h4">Known</span>')
    // }



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
        data: {"word": $(this).data('word'), "lang_id": $(this).data('lang_id'), "state": $(this).data('state') },

        success: function (data) {


        }
    });

});


/* SHOW words
0 - all
1 - unknown
2 - known
 */

$( document ).ready(function() {

    if(Cookies.get('show_words') == 0) {
        $('#show_all_words').prop( "disabled", true );
    }

    if(Cookies.get('show_words') == 1) {
        $('#show_unknown_words').prop( "disabled", true );
    }

    if(Cookies.get('show_words') == 2) {
        $('#show_known_words').prop( "disabled", true );
    }

});



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