/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function() {
    $(document).on('submit', 'form', function(e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let data = $(this).serialize();
        $.ajax({
            url: url,
            data: data,
            method: 'post',
            success: function(response) {
                console.log(response);
                if(response.valid === true) {
                    $('form').trigger('valid', response);
                } else {
                    $('form').trigger('invalid', response);
                }
            },
            error: function(xhr, message, status) {
                console.log(message);
            }
        })
    })
})

$(document).on('valid', function(e, response) {
    $('#add-ubo').hide();
    $('#ubos-list').replaceWith(response.list);
    //$('#ubo-edit-forms').replaceWith(response.editForms);
})

$(document).on('invalid', function(e, response) {
    $('#add-ubo').children().replaceWith(response.form);
    //$('#ubo-edit-forms').replaceWith(response.editForms);
})

$(document).on('click', '#add-ubo-btn, .edit-ubo-btn', function(e) {
    $('#add-ubo').hide();
    let url = $(this).data('url');
    $.ajax({
        url: url,
        method: 'get',
        success: function(response) {
            if($('#add-ubo').children().length) {
                $('#add-ubo').children().replaceWith(response.form);
                $('#add-ubo').show(1000);
            } else {
                $('#add-ubo').append(response.form);
                $('#add-ubo').show(1000);
            }
        },
        error: function(xhr, message, status) {
            console.log(message);
        }
    })
})

$(document).on('click', '.remove-ubo-btn', function(e) {
    let url = $(this).data('url');
    $.ajax({
        url: url, 
        method: 'delete',
        success: function(response) {
            $('#ubos-list').replaceWith(response.list);
            $('#add-ubo').children().remove();
        },
        error: function(xhr, message, status) {
            console.log(message);
        }
    })
})

$(document).on('click', '.ubo-cancel-btn', function(e) {
    $('#add-ubo').hide();
})
