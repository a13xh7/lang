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