<script>
    $(document).ready(function () {
        var url = "<?= base_url('webpage/user'); ?>";
        var url_image = "<?= site_url('upload/noimage.png'); ?>";        

        let userID = 0;

        $("select").select2();
        $('#tgl').daterangepicker({
            "startDate": moment(), //mm/dd/yyyy
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "alwaysShowCalendars": true,
            "opens": "center",
            "applyButtonClasses": "btn-primary",
            "cancelClass": "btn-danger",
            "locale": {
                "format": "YYYY-MM-DD",
                "daysOfWeek": ["Mn", "Sn", "Sl", "Rb", "Km", "Jm", "Sb"],
                "monthNames": ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                "applyLabel": "Apply", "cancelLabel": "Cancel",
            }
        }, function (start, end, label) {
            // console.log(start.format('YYYY-MM-DD')+' to '+end.format('YYYY-MM-DD'));
        });
        $('#tgl').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

        var index = $("#table-data").DataTable({
            "serverSide": true,
            "ajax": {
                url: url,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                data: function (d) {
                    d.action = 'load';
                    // d.start = $("#table-data").attr('data-limit-start');
                    // d.length = $("#table-data").attr('data-limit-end');
                    // d.user_role = $("#select_role").val();
                    d.length = $("#filter_length").find(':selected').val();
                    d.search = {
                        value: $("#filter_search").val()
                    };
                    d.filter_branch = $("#filter_branch").find(':selected').val();
                    d.filter_group = $("#filter_group").find(':selected').val();
                },
                dataSrc: function (data) {
                    return data.result;
                }
            },
            "columnDefs": [
                {"targets": 0, "title": "Username / Group", "searchable": true, "orderable": true},
                {"targets": 1, "title": "Detail", "searchable": true, "orderable": true},
                {"targets": 2, "title": "Status", "searchable": false, "orderable": false},
                {"targets": 3, "title": "Login Terakhir", "searchable": true, "orderable": true},
                {"targets": 4, "title": "Action", "searchable": false, "orderable": false},
            ],
            "order": [
                [0, 'asc']
            ],
            "columns": [
                {
                    'data': 'user_username',
                    render: function (data, meta, row) {
                        var dsp = '';
                        dsp += row.user_username + '<br>';
                        dsp += '<span class="label label-default">' + row.user_group_name + '</span><br>';
                        return dsp;
                    }
                }, {
                    'data': 'user_username',
                    className: 'text-left',
                    render: function (data, meta, row) {
                        var dsp = '';
                        if (row.user_email_1 != undefined) {
                            dsp += row.user_email_1 + '<br>';
                        }
                        if (row.user_phone_1 != undefined) {
                            dsp += row.user_phone_1 + '<br>';
                        }
                        return dsp;
                    }
                }, {
                    'data': 'user_flag',
                    render:function(data, meta, row){
                        var dsp = '';
                        if(parseInt(row.user_flag) == 1){
                            dsp += 'Aktif';
                        }else{ dsp += 'Nonaktif'; }
                        return dsp;
                    }
                }, {
                    'data': 'time_ago',
                    className: 'text-left',
                    render: function (data, meta, row) {
                        var dsp = '';
                        if(parseInt(data) > 0){
                            dsp += data;
                        }else if(parseInt(data) < 0){
                            dsp += 'beberapa detik yg lalu';
                        }else{
                            dsp += '-';
                        }
                        return dsp;
                    }                    
                }, {
                    'data': 'user_id',
                    className: 'text-left',
                    render: function (data, meta, row) {
                        var dsp = '';
                        // disp += '<a href="#" class="activation-data mr-2" data-id="' + data + '" data-stat="' + row.flag + '">';

                        dsp += '<button class="btn-edit btn btn-mini btn-primary" data-id="' + data + '">';
                        dsp += '<span class="fas fa-edit"></span>Edit';
                        dsp += '</button>';
                        // dsp += '&nbsp;<button class="btn btn-open-user-access btn-mini label-inverse" data-id="' + row.user_id + '" data-username="' + row.user_username + '"><span class="fas fa-user-shield"></span> Hak Akses</button>';
                        
                        if (parseInt(row.user_flag) === 1) {
                            dsp += '&nbsp;<button class="btn btn-set-active btn-mini btn-success"';
                            dsp += 'data-username="' + row.user_username + '" data-kode="' + row.user_code + '" data-id="' + data + '" data-flag="' + row.user_flag + '">';
                            dsp += '<span class="fas fa-user-check primary"></span> Aktif</button>';
                        } else {
                            dsp += '&nbsp;<button class="btn btn-set-active btn-mini btn-danger"';
                            dsp += 'data-username="' + row.user_username + '" data-kode="' + row.user_code + '" data-id="' + data + '" data-flag="' + row.user_flag + '">';
                            dsp += '<span class="fas fa-user-times danger"></span> Nonaktif</button>';
                        }

                        return dsp;
                    }
                }
            ]
        });
        $("#table-data_length").on("change", function (e) {
            e.preventDefault();
            e.stopPropagation();
            // var limit_end = $(this).find(":selected").val();
            // $("#table-data").attr('data-limit-end',limit_end);    
            // index.ajax.reload();
        });
        $("#table-data_filter").css('display', 'none');
        $("#table-data_length").css('display', 'none');
        $("#filter_length").on('change', function (e) {
            index.ajax.reload();
        });
        $("#filter_search").on('input', function (e) {
            var ln = $(this).val().length;
            if (parseInt(ln) > 2) {
                index.ajax.reload();
            }
        });

        $('#user_user_group_id').select2({
            placeholder: '--- Pilih ---',
            minimumInputLength: 0,
            ajax: {
                type: "get",
                url: "<?= base_url('search/manage'); ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        source: 'users_groups'
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            templateSelection: function (data, container) {
                // Add custom attributes to the <option> tag for the selected option
                // $(data.element).attr('data-custom-attribute', data.customValue);
                // $("input[name='satuan']").val(data.satuan);
                return data.text;
            }
        });
        $('#filter_group').select2({
            placeholder: '--- Pilih ---',
            minimumInputLength: 0,
            ajax: {
                type: "get",
                url: "<?= base_url('search/manage'); ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        source: 'users_groups'
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            templateSelection: function (data, container) {
                // Add custom attributes to the <option> tag for the selected option
                // $(data.element).attr('data-custom-attribute', data.customValue);
                // $("input[name='satuan']").val(data.satuan);
                return data.text;
            }
        });

        $("#filter_group").on('change', function (e) {
            index.ajax.reload();
        });

        // New Button
        $(document).on("click", "#btn-new", function (e) {
            formNew();
            $("#div-form-trans").show(300);
            $(this).hide();
        });
        // Cancel Button
        $(document).on("click", "#btn-cancel", function (e) {
            e.preventDefault();
            formCancel();
        });

        // Save Button
        $(document).on("click", "#btn-save", function (e) {
            e.preventDefault();
            var next = true;

            var username = $("#form-master input[name='user_username']");
            var password = $("#form-master input[name='user_password']");

            if (next == true) {
                if ($("select[id='user_user_group_id']").find(':selected').val() == 0) {
                    notif(0, 'Group harus dipilih');
                    next = false;
                }
            }

            if (next == true) {
                if (username.val().length == 0) {
                    notif(0, 'Username wajib diisi');
                    username.focus();
                    next = false;
                }
            }

            if (next == true) {
                if ($("input[id='user_phone_1']").val().length == 0) {
                    notif(0, 'Telepon wajib diisi');
                    $("input[id='user_phone_1']").focus();
                    next = false;
                }
            }

            if (next == true) {
                let form = new FormData($("#form-master")[0]);
                form.append('action','create_update');
                if(userID > 0){
                    form.append('user_id', userID);
                }   
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form,
                    dataType: 'json', cache: 'false', 
                    contentType: false, processData: false,                    
                    beforeSend: function(){
                        $("#btn-save").attr('disabled',true);
                        notif(1,'Silahkan tunggu');
                    },
                    success: function (d) {
                        if (parseInt(d.status) == 1) { /* Success Message */
                            notif(1, d.message);
                            index.ajax.reload();
                            formCancel();
                            $("#btn-save").attr('disabled',false);
                        } else { //Error
                            notif(0, d.message);
                        }
                    },
                    error: function (xhr, Status, err) {
                        notif(0, 'Error');
                    }
                });
            }
        });

        // Edit Button
        $(document).on("click", ".btn-edit", function (e) {
            formMasterSetDisplay(0);
            // $("#form-master input[name='username']").attr('readonly',true);
            $("#div-form-trans").show(300);
            e.preventDefault();
            var id = $(this).attr("data-id");
            var data = {
                action: 'read',
                user_id: id
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    $("#btn-save").removeAttr('disabled');
                },
                success: function (d) {
                    if (parseInt(d.status) == 1) { /* Success Message */
                        activeTab('tab1'); // Open/Close Tab By ID
                        userID = d.result.user_id;
                        $("#form-master input[name='user_username']").val(d.result.user_username);
                        $("#form-master input[name='user_phone_1']").val(d.result.user_phone_1);
                        $("#form-master input[name='user_email_1']").val(d.result.user_email_1);

                        $("#form-master select[name='user_user_group_id']").val(d.result.user_user_group_id).trigger('change');
                        $("#form-master select[name='user_theme']").val(d.result.user_theme).trigger('change');
                        $("#form-master select[name='user_flag']").val(d.result.user_flag).trigger('change');

                        $("select[name='user_user_group_id']").append('' +
                                '<option value="' + d.result.user_group_id + '">' +
                                d.result.user_group_name +
                                '</option>');
                        $("select[name='user_user_group_id']").val(d.result.user_group_id).trigger('change');

                        scrollUp('content');
                    } else {
                        notif(0, d.message);
                    }
                },
                error: function (xhr, Status, err) {
                    notif(0, 'Error');
                }
            });
        });

        // Delete Button
        $(document).on("click", ".btn-delete", function () {
            event.preventDefault();
            var id = $(this).attr("data-id");
            var kode = $(this).attr("data-kode");
            var user = $(this).attr("data-username");
            $.confirm({
                title: 'Hapus!',
                content: 'Apakah anda ingin menghapus user <b>' + user + '</b> ?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-danger',
                        text: 'Ya',
                        action: function () {
                            var data = {
                                action: 'remove',
                                user_id: id
                            }
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: data,
                                success: function (d) {
                                    if (parseInt(d.status) = 1) {
                                        notif(1, d.message);
                                        index.ajax.reload(null, false);
                                    } else {
                                        notif(0, d.message);
                                    }
                                }
                            });
                        }
                    },
                    cancel: {
                        btnClass: 'btn-success',
                        text: 'Batal',
                        action: function () {
                            // $.alert('Canceled!');
                        }
                    }
                }
            });
        });

        // Set Flag Button
        $(document).on("click", ".btn-set-active", function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var flag = $(this).attr("data-flag");
            if (flag == 1) {
                var set_flag = 0;
                var msg = 'nonaktifkan';
            } else {
                var set_flag = 1;
                var msg = 'aktifkan';
            }
            var user = $(this).attr("data-username");
            $.confirm({
                title: 'Set Status User',
                content: 'Apakah anda ingin <b>' + msg + '</b> user <b>' + user + '</b> ?',
                columnClass: 'col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
                autoClose: 'button_2|10000',
                closeIcon: true,
                closeIconClass: 'fas fa-times',
                buttons: {
                    button_1: {
                        text: 'Ok',
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function () {
                            var data = {
                                action: 'update_flag',
                                user_id: id,
                                user_flag: set_flag,
                                user_username: user,
                            }
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: data,
                                dataType: 'json',
                                cache: false,
                                beforeSend: function () {},
                                success: function (d) {
                                    if (parseInt(d.status) == 1) {
                                        notif(1, d.message);
                                        index.ajax.reload(null, false);
                                    } else {
                                        notif(0, d.message);
                                    }
                                },
                                error: function (xhr, Status, err) {
                                    notif(0, 'Error');
                                }
                            });
                        }
                    },
                    button_2: {
                        text: 'Batal',
                        btnClass: 'btn-danger',
                        keys: ['Escape'],
                        action: function () {
                            //Close
                        }
                    }
                }
            });
        });

        function formNew() {
            formMasterSetDisplay(0);
            $("#form-master input").not("input[id='tgl']").val();

            $("#files_link").attr('href',url_image);
            $("#files_preview").attr('src',url_image);
            $("#files_preview").attr('data-save-img','');
            $("#btn-new").hide();
            $("#btn-save").show();
            $("#btn-cancel").show();
        }
        function formCancel() {
            formMasterSetDisplay(1);
            $("#form-master input").not("input[id='tgl']").val('');
            $("#files_link").attr('href',url_image);
            $("#files_preview").attr('src',url_image);
            $("#files_preview").attr('data-save-img','');

            $("#form-master textarea").val('');
            $("#form-master select").val(0).trigger('change');
            $("#user_theme").val('black').trigger('change');
            $("#status").val(1).trigger('change');        
            $("#btn-new").css('display', 'inline');
            $("#btn-new").show();
            $("#div-form-trans").hide(300);
        }
    });
    function formMasterSetDisplay(value) { // 1 = Untuk Enable/ ditampilkan, 0 = Disabled/ disembunyikan
        if (value == 1) {
            var flag = true;
        } else {
            var flag = false;
        }
        //Attr Input yang perlu di setel
        var form = '#form-master';
        var attrInput = [   
            "user_phone_1",
            "user_email_1",
            "user_username",
            "user_password",
        ];
        for (var i = 0; i <= attrInput.length; i++) {
            $("" + form + " input[name='" + attrInput[i] + "']").attr('readonly', flag);
        }

        //Attr Textarea yang perlu di setel
        var attrText = [
        ];
        for (var i = 0; i <= attrText.length; i++) {
            $("" + form + " textarea[name='" + attrText[i] + "']").attr('readonly', flag);
        }

        //Attr Select yang perlu di setel
        var atributSelect = [
            "user_user_group_id",
            "user_theme",
            "user_flag",
        ];
        for (var i = 0; i <= atributSelect.length; i++) {
            $("" + form + " select[name='" + atributSelect[i] + "']").attr('disabled', flag);
        }
    }
</script>