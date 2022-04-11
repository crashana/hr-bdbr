$(document).ready(function () {

    $('#candidateSkills').select2({
        multiple: true,
        placeholder: 'დაამატეთ skill-ები',
        tags: true
    });
    $('#candidatesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        paging: true,
        order: [],
        language: {

            "emptyTable": "ჩანაწერი არ მოიძებნა",
            "lengthMenu": "_MENU_",
        },
        ajax: {
            url: datatableRoute,

        },
        columns: [

            {
                data: null,
                name: 'first_name',
                defaultContent: "",
                sortable: false,
                render: function (data) {
                    return data.first_name + ' ' + data.last_name;
                }
            },

            {
                data: null,
                name: 'position',
                defaultContent: "",
                sortable: true,
                render: function (data) {
                    return data.position;
                }
            },


            {
                data: null,
                name: 'id',
                defaultContent: "",
                sortable: true,
                render: function (data) {
                    return data.current_status;
                }
            },

            {
                data: null,
                name: 'min_salary',
                defaultContent: "",
                sortable: true,
                render: function (data) {
                    if (data.min_salary && data.max_salary) {
                        return data.min_salary + ' - ' + data.max_salary;
                    }
                    if (data.min_salary && !data.max_salary) {
                        return 'მინ. ' + data.min_salary;
                    }

                    if (!data.min_salary && data.max_salary) {
                        return 'მაქს. ' + data.max_salary;
                    }

                    if (!data.min_salary && !data.max_salary) {
                        return 'არ არის მითითებული';
                    }
                }
            },


            {
                data: null,
                name: 'id',
                defaultContent: "",
                sortable: true,
                render: function (data) {
                    let skills = '';
                    data.skills.forEach(function (itm) {
                        skills += itm.skill + ', '
                    });

                    return skills;
                }
            },


            {
                data: null,
                name: 'id',
                defaultContent: "",
                sortable: true,
                render: function (data) {
                    return `<button class="btn btn-outline-info viewInfo" data-id="${data.id}" ><i class="fal fa-info"></i></button>`
                }
            },


        ]
    });


    body.on('click', '.viewInfo', function (e) {
        let id = $(this).data('id');
        $.ajax({
            url: getRoute,
            type: "POST",
            data: {
                id: id,
            },
            timeout: 600000,
            success: function (data) {
                if (data.success) {
                    result = data.result;
                    $('#candidateAction').val('edit');
                    $('#candidateId').val(result.id);
                    $('#candidateFirstName').val(result.first_name)
                    $('#candidateLastName').val(result.last_name)
                    $('#candidatePosition').val(result.position)
                    $('#candidateMinSalary').val(result.min_salary)
                    $('#candidateMaxSalary').val(result.max_salary)
                    $('#candidateLinkedIn').val(result.linkedin_url)

                    $('.showLink').attr('href', '').hide();

                    let htmlTags = '';
                    var arr = [];
                    result.skills.forEach(function (skill) {
                        $('#candidateSkills').append(`<option value="${skill.skill}" >${skill.skill}</option>`)
                        arr.push(skill.skill);
                    })
                    $('#candidateSkills').val(arr).trigger('change');
                    if (result.linkedin_url) {
                        $('.showLink').attr('href', result.linkedin_url).show();
                    }

                    if (result.documents.length) {
                        $('#documentsDiv').show();
                        result.documents.forEach(function (doc) {
                            $('#candidateUploadedDocuments').append(` <li><a href="${doc.path}/${doc.file_name}" target="_blank"> <i class="fal fa-file-pdf"></i> ${doc.name}</a></li>`)
                        })
                    }
                }
            }

        });


        $('#candidateModal').modal('show')
    })


    var candidateForm = $("#candidateForm");
    if (candidateForm.length > 0) {
        candidateForm.validate({
            ignore: ".ui-tabs-hide :input",
            submitHandler: function (form) {
                var form = candidateForm[0];
                var data = new FormData(form);
                $.ajax({
                    url: storeRoute,
                    type: "POST",
                    enctype: 'multipart/form-data',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function (data) {
                        if (data.success) {
                            $("#candidateModal").modal('hide');
                            $('#candidatesTable').DataTable().ajax.reload();
                        }

                    }
                });

            }
        })
    }


    $("#candidateModal").on('hide.bs.modal', function () {
        $('#candidateForm').trigger('reset');
        $('#candidateAction').val('new');
        $('#candidateId').val(null);
        $('.showLink').attr('href', '').hide();

        $('#documentsDiv').hide();
        $('#candidateUploadedDocuments').html('');

        $('#candidateSkills').html('').val(null).trigger('change')
    });

    body.on('click', '.add', function (e) {
        e.preventDefault();
        $('#candidateModal').modal('show')
    })


    $('#candidateSkills').on('select2:unselecting', function (e) {
        if ($('#candidateAction').val() == 'edit') {
            let skill = e.params.args.data.id;

            $.ajax({
                url: deleteSkillRoute,
                type: "POST",
                data: {
                    candidate_id: $('#candidateId').val(),
                    skill: skill
                },
                timeout: 600000,
                success: function (data) {
                    if (data.success) {
                        $('#candidatesTable').DataTable().ajax.reload();
                    }

                }
            });

        }
    });

});
