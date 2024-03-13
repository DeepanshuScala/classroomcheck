$(function () {
    jQuery.validator.addMethod("noSpace", function (value, element) {
        return value == '' || value.trim().length != 0;
    }, "No space please and don't leave it empty");

    window.setTimeout(function () {
        $(".removeAlert").alert('close');
    }, 4000);

    //for datatables
    $("#usersList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        "order": [0, 'dec'],
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    
    $("#promotionList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        "order": [0, 'dec'],
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    $("#feedbackList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    $("#issuereportedList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });

    $("#newsletterList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });

    $("#sellerpercentageList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });

    $("#membermanagementList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    $("#subjectList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    $("#resourceList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    $("#webContentList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    $("#faqList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });
    $("#blogsList").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csvHtml5',
                customize: function (csv) {
                 return tableheading+"\n"+  csv;
                },
            }, 
         'pdf', 'print'
        ]
    });

    //logout user popup
    $('#logoutUser').click(function (e) {
        var url = $(this).data('url');
        Swal.fire({
            backdrop: true,
            closeOnClickOutside: false,
            allowOutsideClick: false,
            title: 'Are you sure?',
            text: "You want to logout!",
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-info ml-3'
            },
            confirmButtonText: 'Yes, Logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    //for promotion date picker
    $('#start_end_date').daterangepicker({
        autoUpdateInput: false,
        minDate: new Date()
    });
    $('#start_end_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
    });
    $('#start_end_date').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
    $('#start_end_date').keydown(function (e) {
        e.preventDefault();
        return false;
    });
    $('#edit_start_end_date').daterangepicker({
        autoUpdateInput: false,
        minDate: new Date()
    });
    $('#edit_start_end_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
    });
    $('#edit_start_end_date').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
    $('#edit_start_end_date').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    //for add promotion form validation
    $('#addPromotionForm').validate({
        errorClass: 'text-danger',
        /*errorElement: 'div',
         errorPlacement: function (error, element) {
         $(".error-span").text($(error).text());
         
         },*/
        rules: {
            promo_usage_for: {
                required: true
            },
            title: {
                required: true,
                noSpace: true
            },
            description: {
                required: true,
                noSpace: true
            },
            promo_code: {
                required: true,
                noSpace: true
            },
            start_end_date: {
                required: true,
                noSpace: true
            },
            discount_in: {
                required: true,
                noSpace: true
            },
            amount: {
                required: true,
                noSpace: true,
                number: true
            }
        },
        messages: {
            promo_usage_for: {
                required: 'Please select promotion usage for'
            },
            title: {
                required: 'Please enter title',
                noSpace: 'Please enter valid title'
            },
            description: {
                required: 'Please enter description',
                noSpace: 'Please enter valid description'
            },
            promo_code: {
                required: 'Please enter code',
                noSpace: 'Please enter valid code'
            },
            start_end_date: {
                required: 'Please select start-end date',
                noSpace: 'Please select valid start-end date'
            },
            discount_in: {
                required: 'Please select discount type',
                noSpace: 'Please select valid discount type'
            },
            amount: {
                required: 'Please enter amount',
                noSpace: 'Please enter valid amount',
                number: 'Please enter valid amount'
            }
        },
        submitHandler: function (form) {
            $("#pageloader").fadeIn();
            form.submit();
        }
    });

    //for update promotion form validation
    $('#updatePromotionForm').validate({
        errorClass: 'text-danger',
        /*errorElement: 'div',
         errorPlacement: function (error, element) {
         $(".error-span").text($(error).text());
         
         },*/
        rules: {
            promo_usage_for: {
                required: true
            },
            title: {
                required: true,
                noSpace: true
            },
            description: {
                required: true,
                noSpace: true
            },
            promo_code: {
                required: true,
                noSpace: true
            },
            edit_start_end_date: {
                required: true,
                noSpace: true
            },
            discount_in: {
                required: true,
                noSpace: true
            },
            amount: {
                required: true,
                noSpace: true,
                number: true
            }
        },
        messages: {
            promo_usage_for: {
                required: 'Please select promotion usage for'
            },
            title: {
                required: 'Please enter title',
                noSpace: 'Please enter valid title'
            },
            description: {
                required: 'Please enter description',
                noSpace: 'Please enter valid description'
            },
            promo_code: {
                required: 'Please enter code',
                noSpace: 'Please enter valid code'
            },
            edit_start_end_date: {
                required: 'Please select start-end date',
                noSpace: 'Please select valid start-end date'
            },
            discount_in: {
                required: 'Please select discount type',
                noSpace: 'Please select valid discount type'
            },
            amount: {
                required: 'Please enter amount',
                noSpace: 'Please enter valid amount',
                number: 'Please enter valid amount'
            }
        },
        submitHandler: function (form) {
            $("#pageloader").fadeIn();
            form.submit();
        }
    });

    //for add subject form validation
    $('#addSubjectForm').validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                noSpace: true
            }
        },
        messages: {
            name: {
                required: 'Please enter subject',
                noSpace: 'Please enter valid subject'
            }
        },
        submitHandler: function (form) {
            $("#pageloader").fadeIn();
            form.submit();
        }
    });

    //for add sub subject form validation
    $('#addSubSubjectForm').validate({
        errorClass: 'text-danger',
        rules: {
            parent_id: {
                required: true
            },
            name: {
                required: true,
                noSpace: true
            }
        },
        messages: {
            parent_id: {
                required: 'Please select parent subject',
            },
            name: {
                required: 'Please enter subject',
                noSpace: 'Please enter valid subject'
            }
        },
        submitHandler: function (form) {
            $("#pageloader").fadeIn();
            form.submit();
        }
    });

    //for add resource form validation
    $('#addResourceForm').validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                noSpace: true
            }
        },
        messages: {
            name: {
                required: 'Please enter resource type',
                noSpace: 'Please enter valid resource type'
            }
        },
        submitHandler: function (form) {
            $("#pageloader").fadeIn();
            form.submit();
        }
    });
    //for update resource form validation
    $('#updateResourceForm').validate({
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                noSpace: true
            }
        },
        messages: {
            name: {
                required: 'Please enter resource type',
                noSpace: 'Please enter valid resource type'
            }
        },
        submitHandler: function (form) {
            $("#pageloader").fadeIn();
            form.submit();
        }
    });
});