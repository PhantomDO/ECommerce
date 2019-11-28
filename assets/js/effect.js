

$(document).on('change', '#category', function(){
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