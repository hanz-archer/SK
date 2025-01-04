$(document).ready(function () {





    $('#account-form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '../connection/CreateAccountConnection.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success'){
                    Swal.fire("SweetAlert2 is working!");

                }
                else if (response.status === 'error'){
                    Swal.fire("SweetAlert2 is not working!");

                }
            }
        });

        // $('#account-form').on('submit', function (e) {
        //     e.preventDefault();
    
        //     Swal.fire({
        //         title: "Do you want to save the changes?",
        //         showDenyButton: true,
        //         showCancelButton: true,
        //         confirmButtonText: "Save",
        //         denyButtonText: `Don't save`
        //       }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: '../connection/CreateAccountConnection.php',
        //                 type: 'POST',
        //                 data: $(this).serialize(),
        //                 dataType: 'json',
        //                 success: function (response) {
        //                     if (response.status === 'success'){
        //           Swal.fire("Saved!", "", "success");
        //                 }}
        //             })
    
        //         } else if (result.isDenied) {
        //           Swal.fire("Changes are not saved", "", "info");
        //         }
        //       });
    
        // });






    });
});