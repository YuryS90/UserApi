// import FetchIt from 'fetch-it'; // уберем импорт FetchIt
import 'whatwg-fetch';

const form = document.getElementById('quickForm');
console.log(form)
form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = {};
    const elements = form.elements;

    for (let i = 0; i < elements.length; i++) {
        const element = elements[i];

        if (['input', 'select', 'textarea'].indexOf(element.tagName.toLowerCase()) === -1) {
            continue;
        }

        if (element.type === 'submit') {
            continue;
        }

        formData[element.name] = element.value;
    }

    const route = form.getAttribute('action');

    try {
        const response = await fetch(route, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        });

        if (response.ok) {
            const data = await response.json();

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
        } else {
            throw new Error(`Network response was not ok: ${response.status}`);
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
});


// // import FetchIt from 'fetch-it';
// import 'whatwg-fetch'; // импортируем полифилл для fetch
//
// const form = document.getElementById('quickForm');
//
// form.addEventListener('submit', async function (e) {
//     e.preventDefault();
//
//     const formData = {};
//     const elements = form.elements;
//
//     for (let i = 0; i < elements.length; i++) {
//         const element = elements[i];
//
//         if (['input', 'select', 'textarea'].indexOf(element.tagName.toLowerCase()) === -1) {
//             continue;
//         }
//
//         if (element.type === 'submit') {
//             continue;
//         }
//
//         formData[element.name] = element.value;
//     }
//
//     const route = form.getAttribute('action');
//
//     try {
//         const response = await fetch(route, formData, {
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//         });
//
//         if (response.ok) {
//             const data = await response.json();
//
//             console.log('JSON response:', data);
//
//             if (data.success) {
//                 // Используем SweetAlert2 для успешного случая
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Успешно!',
//                     text: data.message,
//                     showConfirmButton: false,
//                     timer: 3000
//                 });
//
//                 // Устанавливаем задержку перед редиректом после завершения таймера Swal
//                 setTimeout(() => {
//                     // Редирект на новую страницу
//                     window.location.href = '/';
//                 }, 3000);
//             } else {
//                 // Используем SweetAlert2 для случая с ошибкой
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Ошибка!',
//                     text: data.message,
//                     footer: '<a href>Подробности</a>'
//                 });
//             }
//         } else {
//             throw new Error(`Network response was not ok: ${response.status}`);
//         }
//     } catch (error) {
//         console.error('Fetch error:', error);
//     }
// });