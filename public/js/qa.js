$( document ).ready(function() {



$('#q_filter_btn').on('click',function() {


    document.cookie = "q_lang_id=" + $('#lang_from').val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";

    document.cookie = "q_about_lang_id=" + $('#lang_to').val() + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";

    url = window.location.href.split('?')[0];
    location.href = url;


});


});