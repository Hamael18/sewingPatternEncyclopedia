$('#add-version').click(function () {
    const index = +$('#widgets-counter').val();
    const tmpl = $('#pattern_versions').data('prototype').replace(/__name__/g, index);

    $('#pattern_versions').append(tmpl);
    $('#widgets-counter').val(index + 1);

    handleDeleteButtons();
});

function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    })
}

function updateCounter() {
    const count = +$('#pattern_versions div.form-group').length;
    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();