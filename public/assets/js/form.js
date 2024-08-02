// Подключение SweetAlert
import Swal from 'sweetalert2';

$(document).ready(function () {
    $('#quickForm').submit(function (e) {
        e.preventDefault();

        const formData = {};
        const elements = $(this).serializeArray();

        $.each(elements, function (i, field) {
            formData[field.name] = field.value;
        });

        const route = $(this).attr('action');

        fetch(route, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
            .then(response => response.json())
            .then(data => {
                console.log('JSON response:', data);

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Успешно!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 3000
                    })

                    setTimeout(() => {
                        window.location.href = '/';
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ошибка!',
                        text: data.message,
                    }).then(r => {
                        // Выполнится после закрытия модального окна
                        console.log('User closed the SweetAlert modal');
                    });
                }

            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    });
});