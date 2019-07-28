
// SET HIGHT

//$('header').height() + $('footer').height()

var mainHeight = window.innerHeight - ( 65+120 );

$('main').css("min-height", mainHeight);
$('.sidebar').css("min-height", mainHeight);
$('.qa_sidebar').css("min-height", mainHeight);

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

// Фильтр  публичных тектсов по языкам

$('#pt_filter').on('click',function() {

    // I know lang selector
    document.cookie = "pt_to_lang_id=" + $('#lang_from').val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";

    // i want to learn selector
    document.cookie = "pt_lang_id=" + $('#lang_to').val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";



    url = window.location.href.split('?')[0];
    location.href = url;


});


}); // document ready end
