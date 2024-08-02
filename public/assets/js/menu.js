import * as $ from 'jquery'

// Активное меню
$('.sidebar .nav-item a').each(function () {
    let loc = window.location.origin + window.location.pathname;
    let link = this.href;

    // Убираем всё после второго слэша (edit, create, {}), но сохраняем подкаталог
    loc = loc.replace(/(\/[^\/]+\/[^\/]+)\/.*$/, '$1');
    link = link.replace(/(\/[^\/]+\/[^\/]+)\/.*$/, '$1');

    if (loc === link) {
        $(this).addClass('active');
    }
});