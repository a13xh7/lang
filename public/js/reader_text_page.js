$( document ).ready(function() {

    const show_all_words = 0;
    const show_unknown_words = 1;
    const show_known_words = 2;

    const word_new = 0;
    const word_to_study = 1;
    const word_known = 2;


// При загрузке страницы проверить какие слова нужно выделаить и выделить эти слова

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
    *    заполнить значения в правом сайдбаре
    */
    $('div.page_text_wrapper').on('click', 'mark.unknown, mark, mark[data-state="0"]', function() {

        word = $(this);

        // Ajax запрос на перевод слова. Возвращается перевод

        if($(word).data('state') == word_new) {
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

                    $('mark[data-word="'+ word.data('word') +'"]').each(function(index,element) {
                        $(element).removeClass();
                        $(element).html( translation + ' ' + word.data('word'));
                    });

                    // добавить перевод слова в правом сайдбаре
                    $('#rs_word_translation').html(data);

                }
            });
        }
    });
    

    // Right sidebar - open window on translate buttons click

    // google translate
    $('#rs').on('click', '#gt_btn', function() {

        url = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + $('#rs_word').html();

        window.open(url, 'window name', 'width=900, height=700');
        return false;

    });

    // yandex translate
    $('#rs').on('click', '#yt_btn', function() {

        url = 'https://translate.yandex.com/?lang=' + text_lang_code + '-' + text_translate_to_lang_code +'&text=' + $('#rs_word').html();

        window.open(url, 'window name', 'width=900, height=700');
        return false;

    });



    // Toggle word translation

    $('div.page_text_wrapper').on('click', 'mark, mark.study, mark.unknown', function() {
        word = $(this);
        word.find('span').toggle();
        word.removeClass();

        // Указать текст и перевод слова

        wordText = word.clone().children().remove().end().text();
        wordTranslation = word.find('span').text().replace('(', '').replace(')', '');

        $('#rs_word').html(wordText);
        $('#rs_word_translation').html(wordTranslation);

        // указать state слова

        if(word.data('state') == word_new || word.data('state') == word_to_study) {
            $('#rs_word_state').replaceWith('<span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">To study</span>')
        } else {
            $('#rs_word_state').replaceWith('<span class="badge badge-success h4" id="rs_word_state" style="vertical-align: middle">Known</span>')
        }

        // Скрыть или показать блок  кнопкой "mark as known"
        // если кнопка показывается, установить ей дата атрибуты
        if(word.data('state') == word_known) {
            $('#rs_mark_known_wrapper').hide();
        } else {
            $('#rs_mark_known_wrapper').show();

            $('#rs_mark_as_known_btn').attr('data-word', wordText);
            $('#rs_mark_as_known_btn').prop('disabled', false);

        }

        //указать ссылку в кнопке "Translate in google"

        googleUrl = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + wordText;
        $('#gt_btn').attr('href', googleUrl);

        yandexUrl = 'https://translate.yandex.com/?lang=' + text_lang_code + '-' + text_translate_to_lang_code +'&text=' + wordText;
        $('#yt_btn').attr('href', yandexUrl);
    });

    // Клик на кнопку #rs_mark_as_known_btn
    // 1 - обновить статус слова в базе
    // 2 - найти в тексте копии этго слова и установить им новый статус

    $('#rs').on('click', '#rs_mark_as_known_btn', function() {

        $(this).prop('disabled', true);
        wordText = word.clone().children().remove().end().text();

        $.ajax({
            url: "/reader/words/update2",
            method: "POST",
            data: {
                "word": $(this).data('word'),
                "lang_id": $(this).data('lang_id'),
                "translate_to_lang_id": $(this).data('translate_to_lang_id'),
                "state": $(this).data('state')
            },

            success: function (data) {

                $('mark[data-word="'+ wordText +'"]').each(function(index,element) {
                    $(element).attr('data-state', word_known);
                    $(element).removeClass();
                });

            }

        });

        $('#rs_word_state').replaceWith('<span class="badge badge-success h4" id="rs_word_state" style="vertical-align: middle">Known</span>');


    });


// Highlight to study words

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
            //document.cookie = "h_known=" + 1 + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";
        }
    });

// Highlight unknown words

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
            //document.cookie = "h_unknown=" + 1 + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";
        }
    });

// Open google translate in new window
// Translate selected text in google

    $("body").keypress(function(e) {


        if (e.code == 'KeyT') {

            url = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + window.getSelection().toString();

            window.open(url, 'window name', 'width=900, height=700');
            return false;

        }
    });






});
