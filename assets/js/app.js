/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


$(document).on('change', '#property_category', '#property_subcategory', function(){
    let $field = $(this);
    let $form = $field.closest('form');
    let data = {}
    data[$field.attr('name')] = $field.val();
    let $subcategory = $('#property_subcategory');
    $.post($form.attr('action'), data).then(function(data){
        let $input = $(data).find('#property_subcategory');
        $subcategory.replaceWith($input);
    })
})

$(document).on('change', '#category', '#subcategory', function(){
    let $field = $(this);
    let $form = $field.closest('form');
    let data = {}
    data[$field.attr('name')] = $field.val();
    let $subcategory = $('#subcategory');
    $.post($form.attr('action'), data).then(function(data){
        let $input = $(data).find('#subcategory');
        $subcategory.replaceWith($input);
    })
})
