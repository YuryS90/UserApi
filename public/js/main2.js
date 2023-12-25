const form = document.getElementById('quickForm');

form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = {};
    const elements = form.elements;

    for (let i = 0; i < elements.length; i++) {
        const element = elements[i];

        // Исключаем элементы, которые не являются input, select или textarea
        if (['input', 'select', 'textarea'].indexOf(element.tagName.toLowerCase()) === -1) {
            continue;
        }

        // Исключаем кнопки из formData
        if (element.type === 'submit') {
            continue;
        }

        formData[element.name] = element.value;
    }

    const options = {
        method: 'POST',
        body: JSON.stringify(formData),
        headers: {
            'Content-Type': 'application/json',
        },
    };

    // Получаем адрес контроллера из атрибута формы (например, data-controller-route)
    const route = form.getAttribute('action');

    fetch(route, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('JSON response:', data);

            if (data.success) {
                // Используем SweetAlert2 для успешного случая
                Swal.fire({
                    icon: 'success',
                    title: 'Успешно!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 3000
                });

                // Устанавливаем задержку перед редиректом после завершения таймера Swal
                setTimeout(() => {
                    // Редирект на новую страницу
                    window.location.href = '/';
                }, 3000);
            } else {
                // Используем SweetAlert2 для случая с ошибкой
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка!',
                    text: data.message,
                    footer: '<a href>Подробности</a>'
                });
            }

            // Ваш код обработки данных (если требуется)
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
});