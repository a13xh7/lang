$( document ).ready(function() {

    const show_all_words = 0;
    const show_unknown_words = 1;
    const show_known_words = 2;

    const word_new = 0;
    const word_to_study = 1;
    const word_known = 2;



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
    $('div.page_text_wrapper').on('click', 'mark.unknown', function() {

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
                        $(element).html( translation + ' ' + word.html());
                    });

                    // добавить перевод слова в правом сайдбаре
                    $('#rs_word_translation').html(data);

                }
            });

        }

        // Поменять state слова на word_to_study

        // $(word).attr('data-state', word_to_study);
        //
        // // ПРАВЫЙ САЙДБАР
        //
        // // заменить слово
        //
        // $('#rs_word').html(word.html());
        //
        // //указать ссылку в кнопке "Translate in google"
        //
        // googleUrl = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + word.html();
        //
        // $('#gt_btn').attr('href', googleUrl);
        //
        // yandexUrl = 'https://translate.yandex.com/?lang=' + text_lang_code + '-' + text_translate_to_lang_code +'&text=' + word.html();
        //
        // $('#yt_btn').attr('href', yandexUrl);

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
            $('#rs_word_state').replaceWith(' <span class="badge badge-warning h4" id="rs_word_state" style="vertical-align: middle">To study</span>')
        } else {
            $('#rs_word_state').replaceWith(' <span class="badge badge-success h4" id="rs_word_state" style="vertical-align: middle">Known</span>')
        }

        //указать ссылку в кнопке "Translate in google"

        googleUrl = 'https://translate.google.com/#view=home&op=translate&sl='+ text_lang_code +'&tl='+ text_translate_to_lang_code +'&text=' + wordText;
        $('#gt_btn').attr('href', googleUrl);

        yandexUrl = 'https://translate.yandex.com/?lang=' + text_lang_code + '-' + text_translate_to_lang_code +'&text=' + wordText;
        $('#yt_btn').attr('href', yandexUrl);
    });

// Highlight to study words

    $("#h_known").change(function() {

        selector = "mark[data-state='" + word_to_study + "']";

        if(this.checked == false) {

            $(selector).each(function(index,element) {
                $(element).removeClass('study');
            });

        } else {

            $(selector).each(function(index,element) {
                $(element).addClass('study');
            });
        }
    });

// Highlight unknown words

    $("#h_unknown").change(function() {

        selector = "mark[data-state='" + word_new + "']";

        if(this.checked == false) {

            $(selector).each(function(index,element) {
                $(element).removeClass('unknown');
            });

        } else {

            $(selector).each(function(index,element) {
                $(element).addClass('unknown');
            });
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