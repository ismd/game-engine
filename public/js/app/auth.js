define(['jquery', 'app/select_character'], function($, select_character) {

    /**
     * Инициализируем модуль
     */
    $(document).ready(function() {
        $('a#auth-button-login').click(function(e) {
            e.preventDefault();

            // Текущая кнопка
            var currentButton = $(this);

            // Блокируем кнопку входа
            currentButton.addClass('disabled');

            // Форма, скрываем её после удачного входа
            var authForm = $('div#auth-form');

            // Пытаемся залогиниться
            var logged = auth(
                authForm.find('input#username').val(),
                authForm.find('input#password').val()
            );

            // Разблокируем кнопку входа
            currentButton.removeClass('disabled');

            if (logged == true) {
                authForm.modal('hide');

                // Передаём управление модулю select_character
                select_character.showCharacters();
            } else {
                authFailed();
            }
        });
    });
    
    /**
     * Пытается залогиниться путём отправки post-запроса
     * @return bool
     */
    function auth(username, password) {
        var logged = false;

        $.ajax({
            url: '/auth/login',
            type: 'post',
            data: {
                'username': username,
                'password': password
            },
            async: false,
            success: function(data) {
                if (data == 'ok') {
                    logged = true;
                }
            }
        });

        return logged;
    }

    /**
     * Вызывается при неудачной попытке входа
     */
    function authFailed() {
        alert('Не удалось войти');
    }
});
