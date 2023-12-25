$(document).ready(function () {
    $('#quickForm').submit(function (e) {
        e.preventDefault();

        const formData = {};
        const elements = $(this).serializeArray();

        $.each(elements, function (i, field) {
            formData[field.name] = field.value;
        });

        const options = {
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
        };

        const route = $(this).attr('action');

        $.ajax({
            url: route,
            ...options,
        })
            .done(function (data) {
                console.log('JSON response:', data);

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Успешно!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    setTimeout(() => {
                        window.location.href = '/';
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ошибка!',
                        text: data.message,
                        footer: '<a href>Подробности</a>'
                    });
                }

                // Ваш код обработки данных (если требуется)
            })
            .fail(function (error) {
                console.error('Ajax error:', error);
            });
    });
});
