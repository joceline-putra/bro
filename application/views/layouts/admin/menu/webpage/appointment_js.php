<!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" type="text/javascript"></script> -->
<script type="text/javascript">
$(document).ready(function() {
    // $("#modal_order").modal('show');
    let identity = 333;
    let url = "<?php base_url('webpage/appointment'); ?>";
    let url_print = "<?php base_url('name'); ?>";
    let url_tool = "<?php base_url('search/manage'); ?>";
    var url_image = "<?php site_url('upload/noimage.png'); ?>";

    let image_width = "<?= $image_width;?>";
    let image_height = "<?= $image_height;?>";

    let nameID = 0;
    let nameItemID = 0;

    $(function() {
        setInterval(function(){ 
            /*
            //SummerNote
            $('#name_note').summernote({
                placeholder: 'Tulis keterangan disini!',
                tabsize: 4,
                height: 350
            });  
            */
        }, 3000);
    });


    //Croppie
    var upload_crop_img = $('#modal_croppie_canvas').croppie({
        enableExif: true,
        viewport: {width: image_width, height: image_height},
        boundary: {width: parseInt(image_width)+10, height: parseInt(image_height)+10},
        url: url_image,
    });
    $('.files_link').magnificPopup({
        type: 'image',
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it
                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function
                // The "opener" function should return the element from which popup will be zoomed in
                // and to which popup will be scaled down
                // By defailt it looks for an image tag:
                opener: function (openerElement) {
                    // openerElement is the element on which popup was initialized, in this case its <a> tag
                    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
    });
    //Select2
    /*
    $('#select').select2({
        //dropdownParent:$("#modal-id"), //If Select2 Inside Modal
        //placeholder: '<i class="fas fa-search"></i> Search',
        //width:'100%',
        placeholder: {
            id: '0',
            text: '-- Pilih --'
        },
        minimumInputLength: 0,
        allowClear: true,
        ajax: {
            type: "get",
            url: url_tool,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var query = {
                    search: params.term,
                    action:'search',
                    type: 1,
                    source: 'select_source'
                };
                return query;
            },
            processResults: function (data){
                var datas = [];
                $.each(data, function(key, val){
                    datas.push({
                        'id' : val.id,
                        'text' : val.text
                    });
                });
                return {
                    results: datas
                };
            },
        cache: true
        },
        escapeMarkup: function(markup){ 
            return markup; 
        },
        templateResult: function(datas){ //When Select on Click
            if (!datas.id) { return datas.text; }
            if($.isNumeric(datas.id) == true){
                // return '<i class="fas fa-user-check '+datas.id.toLowerCase()+'"></i> '+datas.text;
                return datas.text;
            }else{
                // return '<i class="fas fa-plus '+datas.id.toLowerCase()+'"></i> '+datas.text;
                return datas.text;
            }
        },
        templateSelection: function(datas) { //When Option on Click
            if (!datas.id) { return datas.text; }
            //Custom Data Attribute
            $(datas.element).attr('data-alamat', datas.alamat);
            return datas.text;
        }
    });
    $("#select").on('change', function(e){
        // Do Something
    });
    */
    // $("select").select2();

    //Date Clock Picker
    $("#name_date").datepicker({
        // defaultDate: new Date(),
        format: 'dd-mm-yyyy',
        autoclose: true,
        enableOnReadOnly: true,
        language: "id",
        todayHighlight: true,
        weekStart: 1 
    }).on('change', function(e){
    });
    $('.clockpicker').clockpicker({
        default: 'now',
        placement: 'bottom',
        align: 'left',
        donetext: 'Done',
        autoclose: true
    }).on('change', function(e){
    });
    $("#filter_start_date, #filter_end_date").datepicker({
        // defaultDate: new Date(),
        format: 'dd-mm-yyyy',
        autoclose: true,
        enableOnReadOnly: true,
        language: "id",
        todayHighlight: true,
        weekStart: 1 
    }).on('change', function(e){
        e.stopImmediatePropagation();
        name_table.ajax.reload();
    });

    //Autonumeric
    const autoNumericOption = {
        digitGroupSeparator : ',', 
        decimalCharacter  : '.',
        decimalCharacterAlternative: '.', 
        decimalPlaces: 0,
        watchExternalChanges: true
    };
    // new AutoNumeric('#some_id', autoNumericOption);

    //Datatable
    let name_table = $("#table_name").DataTable({
        // "processing": true,
        // "rowReorder": { selector: 'td:nth-child(1)'},
        "responsive": true,
        "serverSide": true,
        "ajax": {
            url: url,
            type: 'post',
            dataType: 'json',
            cache: 'false',
            data: function(d) {
                d.action = 'load';
                d.length = $("#filter_length").find(':selected').val();
                d.date_start = $("#filter_start_date").val();
                d.date_end = $("#filter_end_date").val();
                d.filter_flag = $("#filter_flag").find(':selected').val();
                d.filter_paid_flag = $("#filter_paid_flag").find(':selected').val();                
                d.search = {value:$("#filter_search").val()};
            },
            dataSrc: function(data) {
                return data.result;
            }
        },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "columnDefs": [
            {"targets":0, "width":"15%", "title":"Tanggal", "searchable":true, "orderable":true},       
            {"targets":1, "width":"20%", "title":"Nomor", "searchable":true, "orderable":true},       
            {"targets":2, "width":"30%", "title":"Customer", "searchable":true, "orderable":true},    
            {"targets":3, "width":"30%", "title":"Total", "searchable":true, "orderable":true},
            {"targets":4, "width":"20%", "title":"Status", "searchable":true, "orderable":true},       
            {"targets":5, "width":"20%", "title":"Bayar", "searchable":true, "orderable":true},                                                       
            {"targets":6, "width":"20%", "title":"Flag", "searchable":true, "orderable":true},
        ],
        "order": [[0, 'ASC']],
        "columns": [
            {
                'data': 'order_item_start_date',                                                                           
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = '';
                    // dsp += row.order_item_start_date;
                    dsp += moment(row.order_item_start_date).format("DD-MMM-YYYY, HH:mm");
                    return dsp;
                }
            },{
                'data': 'order_contact_name',
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = '';
                    dsp += row.order_contact_name;
                    // if(row.contact_email_1 != undefined){
                        // dsp += '<br>'+row.contact_email_1;
                    // }
                    return dsp;
                }
            },{
                'data': 'product_name',
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = '';
                    dsp += row.product_name;
                    // if(row.contact_email_1 != undefined){
                        // dsp += '<br>'+row.contact_email_1;
                    // }
                    return dsp;
                }
            },{
                'data': 'order_total',
                className: 'text-right',
                render: function(data, meta, row) {
                    var dsp = '';
                    dsp += addCommas(row.order_total);
                    // if(row.contact_email_1 != undefined){
                        // dsp += '<br>'+row.contact_email_1;
                    // }
                    return dsp;
                }
            },{
                'data': 'order_flag',
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = ''; var label = 'Error Status'; var icon = 'fas fa-cog'; var color = 'white'; var bgcolor = '#d1dade';
                    if(parseInt(row.order_flag) == 1){
                        dsp += '<label class="label label-primary" style="color:#6273df;">Selesai</label>';
                    }else if(parseInt(row.order_flag) == 4){
                        dsp += '<label class="label label-danger" style="color:#ff194f;">Batal</label>';
                    }else if(parseInt(row.order_flag) == 0){
                        dsp += '<label class="label">Menunggu</label>';
                    }                  
                    return dsp;
                }
            },{
                'data': 'order_paid',
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = '';

                    if(parseInt(row.order_paid) == 1){
                        dsp += '<label class="label label-success">Paid</label>';
                    }else if(parseInt(row.order_paid) == 0){
                        dsp += '<label class="label label-danger">Unpaid</label>';
                    }                    
                    return dsp;
                }
            },{                
                'data': 'order_id',
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = ''; var label = 'Error Status'; var icon = 'fas fa-cog'; var color = 'white'; var bgcolor = '#d1dade';
                    if(parseInt(row.name_flag) == 1){
                    //  dsp += '<label style="color:#6273df;">Aktif</label>';
                       label = 'Aktif';
                       icon = 'fas fa-lock';
                       bgcolor = '#0aa699';
                    }else if(parseInt(row.name_flag) == 4){
                       //  dsp += '<label style="color:#ff194f;">Terhapus</label>';
                       label = 'Terhapus';
                       icon = 'fas fa-trash';
                       bgcolor = '#f35958';
                    }else if(parseInt(row.name_flag) == 0){
                       //   dsp += '<label style="color:#ff9019;">Nonaktif</label>';
                       label = 'Nonaktif';
                       icon = 'fas fa-unlock';
                       // color = 'green';
                       bgcolor = '#ff9019';
                    }
                        var att = 'data-name-id="'+data+'" data-name-number="'+row.order_number+'" data-name-session="'+row.order_session+'"';

                       /* Button Action Concept 2 */
                       dsp += '&nbsp;<div class="btn-group">';
                       // dsp += '    <button class="btn btn-mini btn-default"><span class="fas fa-cog"></span></button>';
                       dsp += '    <button class="btn btn-mini btn-default dropdown-toggle btn-demo-space" data-toggle="dropdown" aria-expanded="true"><span class="fas fa-cog"></span><span class="caret"></span> Action</button>';
                       dsp += '    <ul class="dropdown-menu">';
                       dsp += '        <li>';
                       dsp += '            <a class="btn_edit_name" style="cursor:pointer;" '+att+'>';
                       dsp += '                <span class="fas fa-eye"></span> Lihat';
                       dsp += '            </a>';
                       dsp += '        </li>';
                    //    dsp += '        <li>';
                    //    dsp += '            <a class="btn_edit_name" style="cursor:pointer;" '+att+'>';
                    //    dsp += '                <span class="fas fa-calendar-check"></span> Reschedule';
                    //    dsp += '            </a>';
                    //    dsp += '        </li>';                       
                       if(parseInt(row.order_flag) === 0) {
                            dsp += '<li>'; 
                            dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                            dsp += '        '+att+' data-name-flag="1">';
                            dsp += '        <span class="fas fa-lock"></span> Konfirmasi';
                            dsp += '    </a>';
                            dsp += '</li>';
                       }else if(parseInt(row.order_flag) === 1){
                            dsp += '<li>';
                            dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                            dsp += '        '+att+' data-name-flag="0">';
                            dsp += '        <span class="fas fa-ban"></span> Batal';
                            dsp += '    </a>';
                            dsp += '</li>';
                       }

                       if(parseInt(row.order_paid) === 0) {
                            dsp += '<li>'; 
                            dsp += '    <a class="btn_update_paid_flag_name" style="cursor:pointer;"';
                            dsp += '        '+att+' data-name-flag="1">';
                            dsp += '        <span class="fas fa-lock"></span> Set Lunas';
                            dsp += '    </a>';
                            dsp += '</li>';
                       }else if(parseInt(row.order_paid) === 1){
                            dsp += '<li>';
                            dsp += '    <a class="btn_update_paid_flag_name" style="cursor:pointer;"';
                            dsp += '        '+att+' data-name-flag="0">';
                            dsp += '        <span class="fas fa-ban"></span> Set Belum Lunas';
                            dsp += '    </a>';
                            dsp += '</li>';
                       }                       
                    //    if((parseInt(row.name_flag) < 1) || (parseInt(row.name_flag) == 4)) {
                            //    dsp += '<li>';
                            //    dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                            //    dsp += '        '+att+' data-name-flag="4">';
                            //    dsp += '        <span class="fas fa-trash"></span> Batal';
                            //    dsp += '    </a>';
                            //    dsp += '</li>';
                    //    }
                       dsp += '        <li class="divider"></li>';
                    //    dsp += '        <li>';
                    //    dsp += '            <a class="btn_print_name" style="cursor:pointer;" '+att+'>';
                    //    dsp += '                <span class="fas fa-print"></span> Print';
                    //    dsp += '            </a>';
                    //    dsp += '        </li>';
                       dsp += '    </ul>';
                       dsp += '</div>';                   
                    return dsp;
                }
            }
        ]
    });
    $("#table_name_filter").css('display','none');
    $("#table_name_length").css('display','none');
    $("#filter_length").on('change', function(e){
        var value = $(this).find(':selected').val(); 
        $('select[name="table_name_length"]').val(value).trigger('change');
        name_table.ajax.reload();
    });
    $("#filter_flag, #filter_paid_flag").on('change', function(e){ name_table.ajax.reload(); });
    $("#filter_search").on('input', function(e){ var ln = $(this).val().length; if(parseInt(ln) > 3){ name_table.ajax.reload(); }else if(parseInt(ln) < 1){ name_table.ajax.reload();} });

    //CRUD
    $(document).on("click","#btn_save_name",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var next =true;
        if($("#name_type").val().length == 0){
            notif(0,'name_TYPE wajib diisi');
            $("#name_type").focus();
            next=false;
        }else if($("#name_name").val().length == 0){
            notif(0,'name_NAME wajib diisi');
            $("#name_name").focus();
            next=false;
        }else if($("#name_note").val().length == 0){
            notif(0,'name_NOTE wajib diisi');
            $("#name_note").focus();
            next=false;
        }else if($("#name_flag").find(':selected').val() == 0){
            notif(0,'name_FLAG wajib diisi');
            $("#name_flag").focus();
            next=false;
        }else{
            var form = new FormData($("#form_name")[0]);
            // var form = new FormData();
            form.append('action', 'create');
            form.append('upload1', $("#name_preview").attr('data-save-img'));
            if(nameID > 0){
                form.append('name_id',nameID);
            }
            $.ajax({
                type: "POST",
                url: url,
                data: form, dataType:"json",
                cache: false, contentType: false, processData: false,
                beforeSend:function(){},
                success:function(d){
                    var s = d.status;
                    var m = d.message;
                    var r = d.result;
                    if(parseInt(s) == 1){
                        notif(s,m);
                        formnameReset();
                        /* hint zz_for or zz_each */
                        name_table.ajax.reload();
                    }else{
                        notif(s,m);
                    }
                },
                error:function(xhr,status,err){
                    notif(0,err);
                }
            });
        }
    });
    $(document).on("click",".btn_edit_name",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var id       = $(this).attr('data-name-id');
        var session  = $(this).attr('data-name-session');
        var name     = $(this).attr('data-name-number');

        var form = new FormData();
        form.append('action', 'read');
        form.append('order_id', id);
        form.append('order_session', session);
        form.append('order_number', name);
        $.ajax({
            type: "post",
            url: url,
            data: form, dataType:"json",
            cache: false, contentType: false, processData: false,
            beforeSend:function(){},
            success:function(d){
                var s = d.status;
                var m = d.message;
                var r = d.result;
                if(parseInt(s)==1){ /* Success Message */
                    nameID = d.result.order_id;
                    $("#modal_order").modal('show');
                    $("#order_number").val(d.result.order_number);
                    $("#order_date").val(d.result.order_date);                    

                    $("#order_contact_name").val(d.result.order_contact_name);                    
                    $("#order_contact_phone").val(d.result.order_contact_phone);   
                    
                    $("#order_item_start_date").val(d.result.order_item_start_date);                    
                    $("#order_item_product_id").val(d.result.product_name);                     
                    $("#order_total").val(d.result.order_total);                       
                    // $("#order_contact_phone").val(d.result.order_);                                                            
                    // $("#name_session").val(d.result.name_session);
                    // $("#name_type").val(d.result.name_type).trigger('change');
                    // $("#name_name").val(d.result.name_name);
                    // // $("#name_note").val(d.result.name_note);
                    // $('#name_note').summernote('code', d.result.name_note);
                    // $("#name_flag").val(d.result.name_flag).trigger('change');
                    // // $("#name_date_created").val(d.result.name_date_created);

                    // $("#files_preview").attr('src',d.result.name_image);
                    // $(".files_link").attr('href',d.result.name_image);

                    // scrollUp('content');
                    //loadnameItem(r.name_id);
                }else{
                    $("#div_form_name").hide(300);
                    notif(0,d.message);
                }
            },
            error:function(xhr, Status, err){
                notif(0,'Error');
            }
        });
    });
    $(document).on("click",".btn_delete_name",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var next     = true;
        var id       = $(this).attr('data-name-id');
        var session  = $(this).attr('data-name-session');
        var name     = $(this).attr('data-name-number');

        $.confirm({
            title: 'Hapus!',
            content: 'Apakah anda ingin menghapus <b>'+name+'</b> ?',
            buttons: {
                confirm:{ 
                    btnClass: 'btn-danger',
                    text: 'Ya',
                    action: function () {
                        
                        var form = new FormData();
                        form.append('action', 'delete');
                        form.append('name_id', id);
                        form.append('name_session', session);
                        form.append('name_name', name);
                        form.append('name_flag', 4);

                        $.ajax({
                            type: "POST",
                            url : url,
                            data: form,
                            dataType:'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success:function(d){
                                if(parseInt(d.status)==1){ 
                                    notif(d.status,d.message); 
                                    name_table.ajax.reload(null,false);
                                }else{ 
                                    notif(d.status,d.message); 
                                }
                            }
                        });
                    }
                },
                cancel:{
                    btnClass: 'btn-success',
                    text: 'Batal', 
                    action: function () {
                        // $.alert('Canceled!');
                    }
                }
            }
        });
    });

    $(document).on("click",".btn_update_flag_name",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var next     = true;
        var id       = $(this).attr('data-name-id');
        var session  = $(this).attr('data-name-session');
        var name     = $(this).attr('data-name-number');
        var flag     = $(this).attr('data-name-flag');

        if(parseInt(flag) == 0){
            var set_flag = 0;
            var msg = 'menonaktifkan';
        }else if(parseInt(flag) == 1){
            var set_flag = 1;
            var msg = 'mengaktifkan';
        }else{
            var set_flag = 4;
            var msg = 'menghapus';
        }

        $.confirm({
            title: 'Konfirmasi!',
            content: 'Apakah anda ingin '+msg+' <b>'+name+'</b> ?',
            buttons: {
                confirm:{ 
                    btnClass: 'btn-danger',
                    text: 'Ya',
                    action: function () {
                        
                        var form = new FormData();
                        form.append('action', 'update_flag');
                        form.append('order_id', id);
                        form.append('order_session', session);
                        form.append('order_number', name);
                        form.append('order_flag', set_flag);

                        $.ajax({
                            type: "POST",
                            url : url,
                            data: form,
                            dataType:'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success:function(d){
                                if(parseInt(d.status)==1){ 
                                    notif(d.status,d.message); 
                                    name_table.ajax.reload(null,false);
                                }else{ 
                                    notif(d.status,d.message); 
                                }
                            }
                        });
                    }
                },
                cancel:{
                    btnClass: 'btn-success',
                    text: 'Batal', 
                    action: function () {
                        // $.alert('Canceled!');
                    }
                }
            }
        });
    });
    $(document).on("click",".btn_update_paid_flag_name",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var next     = true;
        var id       = $(this).attr('data-name-id');
        var session  = $(this).attr('data-name-session');
        var name     = $(this).attr('data-name-number');
        var flag     = $(this).attr('data-name-flag');

        if(parseInt(flag) == 0){
            var set_flag = 0;
            var msg = 'set belum lunas';
        }else if(parseInt(flag) == 1){
            var set_flag = 1;
            var msg = 'set lunas';
        }else{
            var set_flag = 4;
            var msg = 'menghapus';
        }

        $.confirm({
            title: 'Pembayaran!',
            content: 'Apakah anda ingin '+msg+' <b>'+name+'</b> ?',
            buttons: {
                confirm:{ 
                    btnClass: 'btn-danger',
                    text: 'Ya',
                    action: function () {
                        
                        var form = new FormData();
                        form.append('action', 'update_paid_flag');
                        form.append('order_id', id);
                        form.append('order_session', session);
                        form.append('order_number', name);
                        form.append('order_paid_flag', set_flag);

                        $.ajax({
                            type: "POST",
                            url : url,
                            data: form,
                            dataType:'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success:function(d){
                                if(parseInt(d.status)==1){ 
                                    notif(d.status,d.message); 
                                    name_table.ajax.reload(null,false);
                                }else{ 
                                    notif(d.status,d.message); 
                                }
                            }
                        });
                    }
                },
                cancel:{
                    btnClass: 'btn-success',
                    text: 'Batal', 
                    action: function () {
                        // $.alert('Canceled!');
                    }
                }
            }
        });
    });    

    //Additional
    $(document).on("click","#btn_new_name",function(e) {
        formnameReset();
        $("#modal_name").modal('show');
        nameID = 0;
    });
    $(document).on("click","#btn_cancel_name",function(e) {
        formnameReset();
    });
    $(document).on("click",".btn_print_name",function(e) {
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).attr('data-name-id');
        var session = $(this).attr('data-name-session');
        if(parseInt(id) > 0){
            var x = screen.width / 2 - 700 / 2;
            var y = screen.height / 2 - 450 / 2;
            var print_url = url_print+'?action=print&data='+session;
            var win = window.open(print_url,'Print','width=700,height=485,left=' + x + ',top=' + y + '').print();
            //var win = window.open(print_url,'_blank');
        }else{
            notif(0,'Dokumen belum di buka');
        }
    });
    $(document).on("click","#btn_export_name",function(e) {
        e.stopPropagation();
        $.alert('Fungsi belum dibuat');
    });
    $(document).on("click","#btn_print_name",function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log($(this));
        // var id = $(this).attr('data-name-id');
        $.alert('Fungsi belum dibuat');
    });
    $(document).on("click","#btn_cancel_name_item",function(e) {
        formnameItemReset();
    });
    function loadnameItem(name_id = 0){
        if(parseInt(name_id) > 0){
            $.ajax({
                type: "post",
                url: "<?= base_url('name'); ?>",
                data: {
                    action:'load_name_item_2',
                    name_item_name_id:name_id
                },
                dataType: 'json', cache: 'false', 
                beforeSend:function(){},
                success:function(d){
                    let s = d.status;
                    let m = d.message;
                    let r = d.result;
                    if(parseInt(s) == 1){
                        notif(s,m);
                        // zz_for, zz_each, zz_for_group, zz_each_group
                    }else{
                        notif(s,m);
                    }
                },
                error:function(xhr,status,err){
                    notif(0,err);
                }
            });
        }else{

        }
    }

    //Image Croppie
    $(document).on('change', '#files', function(e) {
        if($("#files").val() == ''){
            $("#files_preview").attr('src', url_image);
            $("#files_link").attr('href', url_image);
            $("#files_preview").attr('data-save-img', '');
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
        upload_crop_img.croppie('bind', {
            url: e.target.result
            }).then(function () {
                $("#modal_croppie").modal("show");
                    setTimeout(function(){$('#modal_croppie_canvas').croppie('bind');}, 300);
            });
        };
        reader.readAsDataURL(this.files[0]);
    });
    $(document).on('click', '#modal_croppie_cancel', function(e){
        e.preventDefault(); e.stopPropagation();
        $("#files").val('');
        $("#files_preview").attr('data-save-img', '');
        $("#files_preview").attr('src', url_image);
        $("#files_link").attr('href', url_image);
    });
    $(document).on('click', '#modal_croppie_save', function(e){
        e.preventDefault(); e.stopPropagation();
        upload_crop_img.croppie('result', {
            type: 'canvas',
            size: 'viewport',
        }).then(function (resp) {
            $("#files_preview").attr('src', resp);
            $("#files_link").attr('href', resp);
            $("#files_preview").attr('data-save-img', resp);
            $("#modal_croppie").modal("hide");
        });
    });

    // window.setInterval(loadPlugin(),3000);
    function loadPlugin(){
    }
    function formnameReset(){
        $("#form_name input")
        .not("input[id='name_hour']")
        .not("input[id='name_date']")
        .not("input[id='name_date_start']")
        .not("input[id='name_date_end']").val('');
        $("#form_name textarea").val('');

        $("#files_link").attr('href',url_image);
        $("#files_preview").attr('src',url_image);
        $("#files_preview").attr('data-save-img',url_image);
    } 
}); //End of Document Ready
</script>