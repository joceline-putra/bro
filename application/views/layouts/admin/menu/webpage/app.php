<style>
     .popover {z-index: 9999;}
    select{min-height: 28px!important; height: 28px!important;}
    .form-control{padding:0px 8px!important;}
    /* Large desktops and laptops */
    @media (min-width: 1200px) {
        .table-responsive{ overflow-x: unset; }
        .prs-15{padding-left: 15px!important;padding-right: 15px!important;}
    }
    /* Landscape tablets and medium desktops */
    @media (min-width: 992px) and (max-width: 1199px) {
        .table-responsive{ overflow-x: unset; }
        .prs-15{padding-left: 15px!important;padding-right: 15px!important;}
    }
    /* Portrait tablets and small desktops */
    @media (min-width: 768px) and (max-width: 991px) {
        .table-responsive{ overflow-x: unset; }
        .prs-15{padding-left: 15px!important;padding-right: 15px!important;}
    }
    /* Landscape phones and portrait tablets */
    @media (max-width: 767px) {
        .prs-15{padding-left: 15px!important;padding-right: 15px!important;}
    }
    /* Portrait phones and smaller */
    @media (max-width: 480px) {
        .prs-15{padding-left: 15px!important;padding-right: 15px!important;}
        .pull-right{height: auto!important;}
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<div class="row">
    <div class="col-md-12">
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                    <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                        <div class="grid simple">
                            <div class="hidden grid-title">
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#grid-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="grid-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-remove-side">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="col-md-6 col-xs-12 col-sm-12" style="padding-left: 0;">
                                                <h5><b>Data <?php echo $title;?></b></h5>
                                            </div>
                                            <div class="col-md-6 col-xs-12 col-sm-12 padding-remove-right">
                                                <div class="pull-right">
                                                    <button id="btn_export_name" onClick="" class="btn btn-default btn-small" type="button" style="display: inline;">
                                                        <i class="fas fa-file-excel"></i>
                                                        Ekspor Excel
                                                    </button>
                                                    <button id="btn_new_name" class="btn btn-success btn-small" type="button" style="display: inline;">
                                                        <i class="fas fa-plus"></i>
                                                        Buat <?php echo $title; ?> Baru
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side" style="padding-top:8px;">
                                            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6 form-group padding-remove-right prs-15">
                                                <label class="form-label">Periode Awal</label>
                                                <div class="col-md-12 col-sm-12 padding-remove-side">
                                                    <div class="input-append success date col-md-12 col-lg-12 no-padding">
                                                        <input name="filter_start_date" id="filter_start_date" type="text" class="form-control input-sm" readonly="true" value="<?php echo $first_date;?>">
                                                        <span class="add-on date-add"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6 form-group padding-remove-right prs-15">
                                                <label class="form-label">Periode Akhir</label>
                                                <div class="col-md-12 col-sm-12 padding-remove-side">
                                                    <div class="input-append success date col-md-12 col-lg-12 no-padding">
                                                        <input name="filter_end_date" id="filter_end_date" type="text" class="form-control input-sm" readonly="true" value="<?php echo $end_date;?>">
                                                        <span class="add-on date-add"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 form-group padding-remove-right prs-15">
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                                    <label class="form-label">Cari</label>
                                                    <input id="filter_search" name="filter_search" type="text" value="" class="form-control" placeholder="Pencarian" />
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6 form-group padding-remove-right prs-15">
                                                <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                                    <label class="form-label">Status</label>
                                                    <select id="filter_flag" name="filter_flag" class="form-control">
                                                        <option value="All">Semua</option>
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Nonaktif</option>
                                                        <option value="4">Terhapus</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6 form-group">
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                                    <label class="form-label">Tampil</label>
                                                    <select id="filter_length" name="filter_length" class="form-control">
                                                        <option value="10">10 Baris</option>
                                                        <option value="25">25 Baris</option>
                                                        <option value="50">50 Baris</option>
                                                        <option value="100">100 Baris</option>
                                                        <option value="-1">Semuanya</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12" style="padding-top:10px;">
                                            <div class="table-responsive">
                                                <table id="table_name" class="table table-bordered" style="width:100%;">
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_croppie" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="modal_croppie_canvas"></div>
            </div>
            <div class="modal-footer">
                <button id="modal_croppie_cancel" type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button id="modal_croppie_save" type="button" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" type="text/javascript"></script> -->
<script type="text/javascript">
$(document).ready(function() {
    // let identity = "<?php echo $identity; ?>";
    let url = "<?php base_url('name'); ?>";
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
                d.search = {value:$("#filter_search").val()};
            },
            dataSrc: function(data) {
                return data.result;
            }
        },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "columnDefs": [
            {"targets":0, "width":"30%", "title":"Name", "searchable":true, "orderable":true},
            {"targets":1, "width":"20%", "title":"Note", "searchable":true, "orderable":true},
            {"targets":2, "width":"20%", "title":"Flag", "searchable":true, "orderable":true},
        ],
        "order": [[0, 'ASC']],
        "columns": [
            {
                'data': 'name_id',
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = '';
                    dsp += row.name_name;
                    return dsp;
                }
            },{
                'data': 'name_id',
                className: 'text-left',
                render: function(data, meta, row) {
                    var dsp = '';
                    dsp += row.name_note;
                    // if(row.contact_email_1 != undefined){
                        // dsp += '<br>'+row.contact_email_1;
                    // }
                    return dsp;
                }
            },{
                'data': 'name_id',
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

                        var att = 'data-name-id="'+data+'" data-name-name="'+row.name_name+'" data-name-session="'+row.name_session+'"';

                        /* Button Action Concept 1 */
                        // dsp += '&nbsp;<button class="btn btn_edit_name btn-mini btn-primary" '+att+'>';
                        // dsp += '<span class="fas fa-edit primary"></span> Edit</button>';

                        // dsp += '&nbsp;<button class="btn btn_delete_name btn-mini btn-danger" '+att+'>';
                        // dsp += '<span class="fas fa-trash danger"></span> Hapus</button>';

                        // if (parseInt(row.name_flag) === 1) {
                        //   dsp += '&nbsp;<button class="btn btn_update_flag_name btn-mini btn-primary" style="background-color:#ff9019;" ';
                        //   dsp += ''+att+' data-name-flag="0">';
                        //   dsp += '<span class="fas fa-ban"></span> Nonaktifkan</button>';                      
                        // }else if (parseInt(row.name_flag) === 0) {
                        //   dsp += '&nbsp;<button class="btn btn_update_flag_name btn-mini btn-primary" style="background-color:#6273df;"';
                        //   dsp += ''+att+' data-name-flag="1">';
                        //   dsp += '<span class="fas fa-check primary"></span> Aktifkan</button>';
                        // }

                       /* Button Action Concept 2 */
                       dsp += '&nbsp;<div class="btn-group">';
                       // dsp += '    <button class="btn btn-mini btn-default"><span class="fas fa-cog"></span></button>';
                       dsp += '    <button class="btn btn-mini btn-default dropdown-toggle btn-demo-space" data-toggle="dropdown" aria-expanded="true"><span class="fas fa-cog"></span><span class="caret"></span> </button>';
                       dsp += '    <ul class="dropdown-menu">';
                       dsp += '        <li>';
                       dsp += '            <a class="btn_edit_name" style="cursor:pointer;"';
                       dsp += '                 '+att+'>';
                       dsp += '                <span class="fas fa-edit"></span> Edit';
                       dsp += '            </a>';
                       dsp += '        </li>';
                       // if(parseInt(row.name_flag) === 0) {
                               dsp += '<li>'; 
                               dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                               dsp += ''+att+' data-name-flag="1">';
                               dsp += '        <span class="fas fa-lock"></span> Aktifkan';
                               dsp += '    </a>';
                               dsp += '</li>';
                       // }else if(parseInt(row.name_flag) === 1){
                               dsp += '<li>';
                               dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                               dsp += ''+att+' data-name-flag="0">';
                               dsp += '        <span class="fas fa-ban"></span> Nonaktifkan';
                               dsp += '    </a>';
                               dsp += '</li>';
                       // }
                       if((parseInt(row.name_flag) < 1) || (parseInt(row.name_flag) == 4)) {
                               dsp += '<li>';
                               dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                               dsp += ''+att+' data-name-flag="4">';
                               dsp += '        <span class="fas fa-trash"></span> Hapus';
                               dsp += '    </a>';
                               dsp += '</li>';
                       }
                       dsp += '        <li class="divider"></li>';
                       dsp += '        <li>';
                       dsp += '            <a class="btn_print_name" style="cursor:pointer;" '+att+'>';
                       dsp += '                <span class="fas fa-print"></span> Print';
                       dsp += '            </a>';
                       dsp += '        </li>';
                       dsp += '    </ul>';
                       dsp += '</div>';

                       /* Button Action Concept 2 */
                       dsp += '&nbsp;<div class="btn-group">';
                       // dsp += '    <button class="btn btn-mini btn-default" style="background-color:'+bgcolor+';color:'+color+'"><span class="'+icon+'"></span> '+label+'</button>';
                       dsp += '    <button class="btn btn-mini btn-default dropdown-toggle btn-demo-space" style="background-color:'+bgcolor+';color:'+color+';" data-toggle="dropdown" aria-expanded="true"><span class="'+icon+'"></span> '+label+' <span class="caret" style="color:'+color+'"></span> </button>';
                       dsp += '    <ul class="dropdown-menu">';
                       if(parseInt(row.name_flag) == 1){
                               dsp += '<li>';
                               dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                               dsp += ''+att+' data-name-flag="0">';
                               dsp += '        <span class="fas fa-ban"></span> Nonaktifkan';
                               dsp += '    </a>';
                               dsp += '</li>';
                       }else if(parseInt(row.name_flag) == 0) {
                               dsp += '<li>'; 
                               dsp += '    <a class="btn_update_flag_name" style="cursor:pointer;"';
                               dsp += ''+att+' data-name-flag="1">';
                               dsp += '        <span class="fas fa-lock"></span> Aktifkan';
                               dsp += '    </a>';
                               dsp += '</li>';
                       }
                       dsp += '    </ul>';
                       dsp += '</div>';
                    return dsp;
                }
            }
        ],
        "language": {
            "sProcessing":    "Sedang memuat",
            "sLengthMenu":    "Tampil _MENU_ data",
            "sZeroRecords":   "Data tidak ada",
            "sEmptyTable":    "Data tidak ada",
            "sInfo":          "Data _START_ sampai _END_ dari _TOTAL_ data",
            "sInfoEmpty":     "Data 0 sampai 0 dari 0 data",
            "sInfoFiltered":  "(saring total _MAX_ data)",
            "sInfoPostFix":   "",
            "sSearch":        "Cari:",
            "sUrl":           "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Loading...",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sLast":    "Terakhir",
                "sNext":    "Selanjutnya",
                "sPrevious": "Sebelumnya"
            },
            "oAria": {
                "sSortAscending":  ": Mengurutkan A-Z / 0-9",
                "sSortDescending": ": Mengurutkan Z-A / 9-0"
            }
        }
    });
    $("#table_name_filter").css('display','none');
    $("#table_name_length").css('display','none');
    $("#filter_length").on('change', function(e){
        var value = $(this).find(':selected').val(); 
        $('select[name="table_name_length"]').val(value).trigger('change');
        name_table.ajax.reload();
    });
    $("#filter_flag").on('change', function(e){ name_table.ajax.reload(); });
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
        var name     = $(this).attr('data-name-name');

        var form = new FormData();
        form.append('action', 'read');
        form.append('name_id', id);
        form.append('name_session', session);
        form.append('name_name', name);
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
                    nameID = d.result.name_id;
                    
                    $("#name_id").val(d.result.name_id);
                    $("#name_session").val(d.result.name_session);
                    $("#name_type").val(d.result.name_type).trigger('change');
                    $("#name_name").val(d.result.name_name);
                    // $("#name_note").val(d.result.name_note);
                    $('#name_note').summernote('code', d.result.name_note);
                    $("#name_flag").val(d.result.name_flag).trigger('change');
                    // $("#name_date_created").val(d.result.name_date_created);

                    $("#files_preview").attr('src',d.result.name_image);
                    $(".files_link").attr('href',d.result.name_image);

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
        var name     = $(this).attr('data-name-name');

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
        var name     = $(this).attr('data-name-name');
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
                        form.append('name_id', id);
                        form.append('name_session', session);
                        form.append('name_name', name);
                        form.append('name_flag', set_flag);

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

    //CRUD ITEM
    $(document).on("click",".btn_save_name_item",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    });
    $(document).on("click",".btn_edit_name_item",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    });
    $(document).on("click",".btn_update_name_item",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    });
    $(document).on("click",".btn_delete_name_item",function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
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
    /*
    $('#files').change(function(e) {
        var fileName = e.target.files[0].name;
        var fileReader = new FileReader();
        fileReader.onload = function(e) {
            $('#files_preview').attr('src', e.target.result).width(150).height(150);
            $('.files_link').attr('href', e.target.result);
        };
        fileReader.readAsDataURL(this.files[0]);
    });
    */

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
    function formnameItemReset(){
        $("#form_name_item input")
        .not("input[id='name_item_date_start']")
        .not("input[id='name_item_date_end']").val('');
        $("#form_name_item textarea").val('');
    } 
}); //End of Document Ready
</script>