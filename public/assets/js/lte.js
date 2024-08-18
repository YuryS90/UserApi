import $ from "jquery"

//import 'admin-lte/plugins/jquery-ui/jquery-ui.min'

// Bootstrap - работа модальных окон и чтобы не было ошибок рода:
// "TypeError: n.attr(...).tooltip is not a function"
import 'admin-lte/node_modules/bootstrap/dist/js/bootstrap.bundle.min';
import 'admin-lte/node_modules/bootstrap/dist/css/bootstrap.min.css';

// AdminLTE
import 'admin-lte';
import 'admin-lte/dist/css/adminlte.min.css';

// Заменяет стандартные полосы прокрутки на стилизованные
import 'admin-lte/node_modules/overlayscrollbars/js/jquery.overlayScrollbars.min';
import 'admin-lte/node_modules/overlayscrollbars/css/OverlayScrollbars.min.css';

// Select2
import 'admin-lte/node_modules/select2/dist/js/select2.full.min';
import 'admin-lte/node_modules/select2/dist/css/select2.css';

// Summernote - текстовый редактор
import 'admin-lte/plugins/summernote/summernote-bs4.min'
import 'admin-lte/plugins/summernote/summernote-bs4.min.css'

// Значки, иконки
import 'admin-lte/node_modules/@fortawesome/fontawesome-free/css/all.min.css';

// Инициализация select2 и summernote
$(document).ready(function() {
    if ($('.tags').length) {
        $('.tags').select2();
    }
    if ($('.colors').length) {
        $('.colors').select2();
    }
    if ($('#summernote').length) {
        $('#summernote').summernote({
            height: 200,   // Устанавливаем высоту редактора
            minHeight: 100, // Минимальная высота
            maxHeight: 200, // Максимальная высота
            focus: true    // Фокус на редакторе при инициализации
        });
    }
    $('body').overlayScrollbars({
        className: "os-theme-dark", // -light
        scrollbars: {
            autoHide: "leave",
            clickScrolling: true
        }
    });

    if ($('.product-image-thumb').length) {
        $('.product-image-thumb').on('click', function () {
            let $image_element = $(this).find('img')
            $('.product-image').prop('src', $image_element.attr('src'))
            $('.product-image-thumb.active').removeClass('active')
            $(this).addClass('active')
        })
    }

});
