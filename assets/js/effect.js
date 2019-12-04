
console.log('Hello Webpack Encore! Edit me in assets/js/effect.js');s

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