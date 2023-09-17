function sendAjaxRequest(requestType, url, data, successCallback, errorCallback) {
    $.ajax({
        type: requestType,
        url: url,
        data: data,
        success: function (response) {
            successCallback(response);
        },
        error: function(xhr, textStatus, errorThrown) {
            console.error('AJAX Error: ' + textStatus, errorThrown);
            alert('An error occurred: ' + textStatus);
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
