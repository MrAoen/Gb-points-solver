/**
 * Created by aoen on 14.02.17.
 */
$(function() {

    // Обработчик клика по кнопке "Заказать"
    $('button').click(function(e) {
        // Сериализуем данные формы для отправки серверу
        var formData = $('form').serialize();

        // Ajax-запрос серверу типа POST
        $.post('result.php', formData,
            function(data) {
                // Вызываем вспомогательную функцию
                processServerResponse(data);
            });

        // Отменяем прямую отправку формы
        e.preventDefault()
    });

    function processServerResponse(data) {
        alert(data);
 /*       for (var prop in data) {
            // Отображаем только ту продукцию, заказ которой больше 0
            // (в ответе от сервера содержится только такая продукция)
            var filtered = inputElems.has('input[name=' + prop + ']')
                .appendTo("#row1").show();
        }*/
    }

});