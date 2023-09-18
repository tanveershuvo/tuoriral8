function sendAjaxRequest(requestType, url, data, successCallback, errorCallback) {
    $('.text-danger.alert.alert-danger').remove();
    // Set the CSRF token as a default header for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: requestType,
        url: url,
        data: data,
        success: function (response) {
            successCallback(response);
        },
        error: function (xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, message) {
                        $('#' + field).after('<div class="text-danger alert alert-danger">' + message[0] + '</div>');
                    });
                } else {
                    $('#error-messages').append('<p>' + value + '</p>');
                }

            }
        }
    });
}

// Event handler for the "Reviewer" button click
$(document).on("click", "#reviewer", function () {
    let dataId = $(this).data('id');

    sendAjaxRequest('GET', `submission/reviewer/${dataId}`, null, function (response) {
        $("#reviewerTable tbody").empty();
        let tableBody = $("#reviewerTable tbody");


        $.each(response, function (index, item) {
            let newRow = $("<tr>");
            newRow.append(
                $("<td>").text(item.reviewers.first_name + ' ' + item.reviewers.last_name),
                $("<td>").text(item.reviewer_comment),
                $("<td>").text(item.score)
            );

            tableBody.append(newRow);
        });

        $('#reviewerInfo').modal('show');
    });
});


$(document).ready(function () {

    $("#show_paper").on("click", function () {
        $("#afterCheckInput").show();
        $(this).hide();
    });

    $("#next2").on("click", function () {
        event.preventDefault();
        $("#save").show();
        $("#afterCheckInput").show();
        $("#inputType").val('checked');
        $("#next2").hide();
        $('#message').text('');
    });
})
;

function deleteRecord(paperId) {
    event.preventDefault()
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((willDelete) => {
        if (willDelete) {
            // Get the CSRF token from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

// Send the AJAX request with the CSRF token in the headers
            $.ajax({
                url: "submission/" + paperId,
                type: "DELETE", // Use the appropriate HTTP method
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (data) {
                    window.location.href = "submission";
                },
                error: function (data) {
                    swal("Oops! Something went wrong.", {
                        icon: "error",
                    });
                }
            });
        }
    });


}
