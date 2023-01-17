$(function(){
    function readURL(input, selector) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                $(selector).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#img").change(function () {
        readURL(this, '#image');
    });

});

$(document).ready(function() {
    $('.btn-delete').click(function (e) {
        e.preventDefault();
        var arrayUrl = $(location).attr('pathname').split('/');
        var model = arrayUrl[arrayUrl.length - 1]
        var id = $(this).data('id');
        Swal.fire({
            icon: 'warning',
            text: 'Bạn có muốn xóa?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            confirmButtonColor: '#e3342f',
            cancelButtonText: 'No'
          })
          .then((results) => {
            if (results.isConfirmed) {
                var data = {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id": id,
                }
                $.ajax({
                    type: "DELETE",
                    url: `${model}/${id}`,
                    data: data,
                    success: function(response) {
                        Swal.fire(response.success, {
                            icon: "success",
                        })
                        .then((result) => {
                            location.reload();
                        });
                    }
                });

            }
          });

    });

});
