function sendAjaxRequest(requestType, url, data, successCallback, errorCallback) {
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
                // Display validation errors to the user
                $('#error-messages').empty();
                $.each(xhr.responseJSON.errors, function (key, value) {
                    $('#error-messages').append('<p>' + value + '</p>');
                });
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
    $("#submissionForm").submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();

        sendAjaxRequest('POST', '/submission', formData, function (response) {
            console.log(response.data)
            if (response.data === 'http://127.0.0.1:8000/submission') {
                window.location.href = response.data;
            } else {

                if (typeof response.data === "number") {
                    $('#message').addClass('text-primary').text('Do you want to continue to submit the paper?')
                    $("#next2").show();

                } else if (typeof response.data === "object") {
                    $('#message').addClass('text-info').text('Author already submitted a paper');
                    $("#title").val(response.data.paper_title).prop('readonly', true);
                    $("#abstract").val(response.data.abstract).prop('readonly', true);
                    $("#submission_type").val(response.data.submission_type_id).prop('readonly', true);
                    $("#authorId").val(response.data.author_id);
                    $("#show_paper").show();
                } else {
                    $('#message').addClass('text-primary').text(' You have already provided the author information. Do you want to continue to submit the paper?');
                    $("#next2").show();
                }
                $("#next").hide();
                $(".checkData").prop("readonly", true);
            }

        });
    });

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
});

function deleteRecord() {
    event.preventDefault()
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#deleteRecord").submit()
        }
    })
}
