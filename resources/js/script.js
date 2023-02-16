$('.delete-button').on('click', function() {
    let dataForRequest = {
        id: $(this).parent().parent().find("[name='id']").val()
    };
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $(this).attr('csrf-token')
        },
        data: dataForRequest,
        url: location.origin + '/deleteTask',
        success: function () {
            document.location.reload();
        }
    });
});