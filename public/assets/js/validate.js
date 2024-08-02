import * as $ from 'jquery'
import '../../adminlte/plugins/jquery-ui/jquery-ui.js'
import '../../adminlte/plugins/jquery-validation/jquery.validate'
import '../../adminlte/plugins/jquery-validation/additional-methods'

//Валидация
$.widget.bridge('uibutton', $.ui.button)

$(function () {
    $('#quickForm').validate({
        rules: {
            // title: {
            //     required: true
            // },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8
            },
            name: {
                required: true
            },
            address: {
                required: true
            },
        },
        messages: {
            // title: {
            //     required: "Поле не должно быть пустым!",
            // },
            email: {
                required: "Пожалуйста, введите адрес электронной почты",
                email: "Пожалуйста, введите действительный адрес электронной почты"
            },
            password: {
                required: "Пожалуйста, введите пароль",
                minlength: "Ваш пароль должен состоять не менее чем из 8 символов"
            },
            name: {
                required: "Пожалуйста, введите имя пользователя",
            },
            address: {
                required: "Пожалуйста, введите адрес пользователя",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});