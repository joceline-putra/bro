
<script>
    $.getScript("https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js");
    
    $(document).ready(function () {
        let identity = 1;
        var blog_routing = "<?php echo $_route; ?>";
        var url = "<?= base_url('webpage/product'); ?>";
        // var url_image = '<?= base_url('assets/webarch/img/default-user-image.png'); ?>';
        var url_image = '<?= base_url('upload/noimage2.png'); ?>';
        var url_preview = '<?php echo site_url(); ?>' + blog_routing +'/';
        var view = "<?php echo $_view; ?>";
        var set_url = "<?php echo base_url(); ?>";

        $(".nav-tabs").find('li[class="active"]').removeClass('active');
        $(".nav-tabs").find('li[data-name="blog/product"]').addClass('active');

        var projectID = 0;

        $(".img_preview").attr('src', url_image);
        $("select").select2();
        $(".date").datepicker({
            // defaultDate: new Date(),
            format: 'yyyy-mm-dd',
            autoclose: true,
            enableOnReadOnly: true,
            language: "id",
            todayHighlight: true,
            weekStart: 1
        });

        let image_width = "<?= $image_width;?>";
        let image_height = "<?= $image_height;?>";      
        
        //Croppie
        var upload_crop_img_1 = $('#modal_croppie_canvas_1').croppie({
            enableExif: true,
            viewport: {width: image_width, height: image_height},
            boundary: {width: parseInt(image_width)+10, height: parseInt(image_height)+10},
            url: url_image,
        });
        var upload_crop_img_2 = $('#modal_croppie_canvas_2').croppie({
            enableExif: true,
            viewport: {width: image_width, height: image_height},
            boundary: {width: parseInt(image_width)+10, height: parseInt(image_height)+10},
            url: url_image,
        });        
        var upload_crop_img_3 = $('#modal_croppie_canvas_3').croppie({
            enableExif: true,
            viewport: {width: image_width, height: image_height},
            boundary: {width: parseInt(image_width)+10, height: parseInt(image_height)+10},
            url: url_image,
        });
        var upload_crop_img_4 = $('#modal_croppie_canvas_4').croppie({
            enableExif: true,
            viewport: {width: image_width, height: image_height},
            boundary: {width: parseInt(image_width)+10, height: parseInt(image_height)+10},
            url: url_image,
        });                

        const autoNumericOption = {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalCharacterAlternative: ',',
            decimalPlaces: 1,
            watchExternalChanges: true //!!!        
        };

        let mHARGA = new AutoNumeric('#harga_jual', autoNumericOption);
        let mSTOK = new AutoNumeric('#stok', autoNumericOption);        
        /* Autonumeric */
        /* Init */
        // const autoNumericOption = {
        //     digitGroupSeparator : ',', decimalCharacter  : '.', decimalCharacterAlternative: '.',
        //     decimalPlaces: 0, watchExternalChanges: true
        // };
        // let variable = new AutoNumeric('#selector_id', autoNumericOption);
        // /* Get*/
        // alert(variable.rawValue);
        // /* Set*/
        // alert(variable.set(123000););
        // new AutoNumeric('#harga_beli', autoNumericOption);    
        setTimeout(() => {
            $('#content-description').summernote({
                placeholder: 'Content description here!',
                dialogsInBody:true,
                tabsize: 4,
                height: 350,
                toolbar: [
                    ["font", ["bold", "italic", "underline", "clear"]],
                    ["fontname", ["fontname"]],
                    ['fontsize', ['fontsize']],
                    ["style", ["color","style"]],
                    ["para", ["ul", "ol", "paragraph","height"]],
                    ["insert", ["table","link","picture","hr"]],
                    ["view", ["fullscreen","codeview", "help"]],
                ]
            });
        }, 3000);

        var index = $("#table-data").DataTable({
            // "processing": true,
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
                    d.tipe = identity;
                    d.length = $("#filter_length").find(':selected').val();
                    d.category = $("#filter_categories").find(':selected').val();
                    d.flag = $("#filter_flag").find(':selected').val();
                    d.search = {
                        value: $("#filter_search").val()
                    };
                },
                dataSrc: function (data) {
                    return data.result;
                }
            },
            "columnDefs": [
                {"targets": 0, "title": "Nama", "searchable": true, "orderable": false},
                {"targets": 1, "title": "Kategori", "searchable": true, "orderable": false},
                {"targets": 2, "title": "Harga", "searchable": true, "orderable": false, "className": 'dt-body-right'},
                {"targets": 3, "title": "Durasi", "searchable": true, "orderable": false, "className": 'dt-body-right'},
                {"targets": 4, "title": "Action", "searchable": true, "orderable": false, "className": 'dt-body-right'}
            ],
            "order": [
                [0, 'asc']
            ],
            "columns": [
                {
                    'data': 'product_name',
                    className: 'text-left',
                    render: function (data, meta, row) {
                        var dsp = '';
                        // dsp += '<button class="btn-edit btn btn-mini btn-primary" data-id="'+ row.news_id +'">';
                        // dsp += '<span class="fas fa-edit"></span>Edit';
                        // dsp += '</button>';
                        dsp += '<a href="#" class="btn-edit" data-id="' + row.product_id + '"><i class="fas fa-newspaper"></i>&nbsp;' + row.product_name + '</a>';
                        return dsp;
                    }
                }, {
                    'data': 'category_name'
                }, {
                    'data': 'product_id',
                    className: 'text-right',
                    render: function (data, meta, row) {
                        var dsp = '';
                        if (parseInt(row.product_price_sell) > 0) {
                            dsp += numberWithCommas(row.product_price_sell);
                        } else {
                            dsp += '-';
                        }
                        return dsp;
                    }
                }, {
                    'data': 'product_stock',
                    className: 'text-right',
                    render: function (data, meta, row) {
                        var dsp = "";
                        // return row.product_id+' <i class="fas fa-eye"></i>';
                        if (parseInt(data) > 0) {
                            dsp += '<a href="#" class="btn_edit_stock" style="cursor:pointer;" data-id="'+row.product_id+'" data-name="'+row.product_name+'" data-satuan="'+row.product_unit+'" data-stok="'+row.product_stock+'" data-price="'+row.product_price_sell+'"><b>' + addCommas(data) + ' ' + row.product_unit+'</b></a>';
                        } else {
                            dsp += '<a href="#" class="btn_edit_stock" style="cursor:pointer;" data-id="'+row.product_id+'" data-name="'+row.product_name+'" data-satuan="'+row.product_unit+'" data-stok="'+row.product_stock+'" data-price="'+row.product_price_sell+'"><b>-</b></a>';
                        }
                        return dsp;
                    }
                }, {
                    'data': 'product_id',
                    className: 'text-left',
                    render: function (data, meta, row) {
                        var dsp = '';
                        dsp += '&nbsp;<button class="btn btn-edit btn-mini btn-primary"';
                        dsp += 'data-nama="' + row.product_name + '" data-url="' + row.product_url + '" data-id="' + data + '" data-flag="' + row.product_flag + '" data-category="' + row.category_url + '">';
                        dsp += '<span class="fas fa-edit"></span> Edit</button>';

                        dsp += '&nbsp;<button class="btn btn-preview btn-mini btn-info"';
                        dsp += 'data-nama="' + row.product_name + '" data-url="' + row.product_url + '" data-id="' + data + '" data-flag="' + row.product_flag + '" data-category="' + row.category_url + '">';
                        dsp += '<span class="fas fa-eye"></span> Preview</button>';

                        if (parseInt(row.news_flag) === 0) {
                            dsp += '&nbsp;<button class="btn btn-set-active btn-mini btn-primary"';
                            dsp += 'data-nama="' + row.product_name + '" data-kode="' + row.product_url + '" data-id="' + data + '" data-flag="' + row.product_flag + '">';
                            dsp += '<span class="fas fa-check-square primary"></span></button>';

                            dsp += '&nbsp;<button class="btn btn-delete btn-mini btn-danger"';
                            dsp += 'data-nama="' + row.product_name + '" data-kode="' + row.product_url + '" data-id="' + data + '" data-flag="' + row.product_flag + '">';
                            dsp += '<span class="fas fa-trash danger"></span></button>';                            
                        } else {
                            dsp += '&nbsp;<button class="btn btn-set-active btn-mini btn-warning"';
                            dsp += 'data-nama="' + row.product_name + '" data-kode="' + row.product_url + '" data-id="' + data + '" data-flag="' + row.product_flag + '">';
                            dsp += '<span class="fas fa-times danger"></span></button>';
                        }
                        return dsp;
                    }
                }]
        });
        //Datatable Config
        $("#table-data_filter").css('display', 'none');
        $("#table-data_length").css('display', 'none');
        $("#filter_flag").on('change', function (e) {
            index.ajax.reload();
        });        
        $("#filter_length").on('change', function (e) {
            var value = $(this).find(':selected').val();
            $('select[name="table-data_length"]').val(value).trigger('change');
            index.ajax.reload();
        });
        $("#filter_search").on('input', function (e) {
            var ln = $(this).val().length;
            if (parseInt(ln) > 3) {
                index.ajax.reload();
            }
        });
        $('#categories').select2({
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
                        tipe: 1, //1=Produk, 2=News
                        source: 'categories'
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
        $('#filter_categories').select2({
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
                        tipe: 1, //1=Produk, 2=News
                        source: 'categories'
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
        $('#satuan').select2({
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
                        source: 'units'
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
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: function (datas) { //When Select on Click
                if (!datas.id) {
                    return datas.text;
                }
                // return '<i class="fas fa-balance-scale '+datas.id.toLowerCase()+'"></i> '+datas.text;
                if ($.isNumeric(datas.id) == true) {
                    // return '<i class="fas fa-user-check '+datas.id.toLowerCase()+'"></i> '+datas.text;
                    // return datas.text;          
                } else {
                    // return '<i class="fas fa-plus '+datas.id.toLowerCase()+'"></i> '+datas.text;    
                }
                return datas.text;
            },

            templateSelection: function (datas) { //When Option on Click
                // if (!datas.id) { 
                return datas.text;
                // }
                //Custom Data Attribute         
                // return '<i class="fas fa-balance-scale '+datas.id.toLowerCase()+'"></i> '+datas.text;
            }
        });        
        $(document).on("change", "#filter_categories", function (e) {
            index.ajax.reload();
        });        
        $(document).on("change", "#filter_flag", function (e) {
            index.ajax.reload();
        });

        $("#title").on("input", function () {
            console.log($(this));
            var src = $(this).val();

            var ts = src.toLowerCase().replace(/ /g, "-");
            $("#url").val(ts);
        });

        // Save Button
        $(document).on("click", ".btn-save", function (e) {
            e.preventDefault();
            var next = true;

            if (next == true) {
                if ($("input[id='title']").val().length == 0) {
                    notif(0, 'Title wajib diisi');
                    $("#title").focus();
                    next = false;
                }
            }

            if (next == true) {
                if ($("input[id='url']").val().length == 0) {
                    notif(0, 'URL wajib diisi');
                    $("#url").focus();
                    next = false;
                }
            }

            if (next == true) {
                if ($("select[id='categories']").find(':selected').val() == 0) {
                    notif(0, 'Categories wajib dipilih');
                    next = false;
                }
            }

            if (next == true) {
                var form = new FormData();
                form.append('action', 'create_update');
                form.append('tipe', identity);
                // let files = document.getElementById('files').files;
                // for (let i = 0; i < files.length; i++) {
                //     form.append('files[]', files[i]);
                // }    
                form.append('files_1',$("#files_preview_1").attr('data-save-img'));
                form.append('files_2',$("#files_preview_2").attr('data-save-img'));
                form.append('files_3',$("#files_preview_3").attr('data-save-img'));
                form.append('files_4',$("#files_preview_4").attr('data-save-img'));                                  
                if(projectID > 0){
                    form.append('id',projectID);
                }                     
                form.append('status', $('#status').find(':selected').val());
                form.append('categories', $('#categories').find(':selected').val());                
                form.append('title', $('#title').val());
                form.append('url', $('#url').val());
                form.append('content', $('#content-description').val());
                form.set('harga',mHARGA.rawValue);
                form.set('stok',mSTOK.rawValue);                
                form.set('satuan', $('#satuan').find(':selected').val());
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {},
                    success: function (d) {
                        if (parseInt(d.status) == 1) { /* Success Message */
                            notif(1, d.message);
                            index.ajax.reload();
                            loadFiles(d.result.id);
                            projectID = d.result.id;
                        } else { //Error
                            notif(0, d.message);
                        }

                        $("#files").val('');
                        if(projectID > 0){
                            $("#btn-save").hide();
                            $("#btn-update").show();                            
                        }else{
                            $("#btn-save").show();
                            $("#btn-update").hide();                            
                        }
                        console.log(projectID);
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
            $("#form-master input[name='kode']").attr('readonly', true);

            e.preventDefault();
            var id = $(this).data("id");
            var data = {
                action: 'read',
                product_id: id
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                cache: false,
                beforeSend: function () {},
                success: function (d) {
                    if (parseInt(d.status) == 1) { /* Success Message */
                        $("#div-form-trans").show(300);
                        projectID = d.result.product_id;
                        $("#form-master input[name='id_document']").val(d.result.product_id);
                        $("#form-master input[name='title']").val(d.result.product_name);
                        $("#form-master input[name='url']").val(d.result.product_url);
                        
                        var markupStr = d.result.product_note;
                        $('#content-description').summernote('code', markupStr);

                        //News Image
                        // if ((d.result.news_image != undefined) || (d.result.news_image != null)) {
                        //     var image = "<?php echo site_url(); ?>" + d.result.news_image;
                        //     $('#img-preview1').attr('src', image);
                        //     console.log(image);                                             
                        // } else {           
                        //     $('#img-preview1').attr('src', url_image);
                        //     console.log(url_image);
                        // }
                        $("select[id='satuan']").append('' +
                                '<option value="' + d.result.product_unit + '">' +
                                d.result.product_unit +
                                '</option>');
                        $("select[id='satuan']").val(d.result.product_unit).trigger('change');

                        $("#form-master select[name='status']").val(d.result.product_flag).trigger('change');
                        $("select[name='categories']").append('' +
                                '<option value="' + d.result.category_id + '">' +
                                d.result.category_name +
                                '</option>');
                        $("select[name='categories']").val(d.result.category_id).trigger('change');        
                        mHARGA.set(d.result.product_price_sell);
                        mSTOK.set(d.result.product_stock);
                        
                        loadFiles(projectID);

                        $("#btn-new").hide();
                        $("#btn-save").hide();
                        $("#btn-update").show();
                        $("#btn-cancel").show();
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
            var user = $(this).attr("data-nama");
            $.confirm({
                title: 'Hapus!',
                content: 'Apakah anda ingin menghapus <b>' + user + '</b> ?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-danger',
                        text: 'Ya',
                        action: function () {
                            var data = {
                                action: 'remove_with_files',
                                id: id
                            }
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: data,
                                dataType: 'json',
                                cache: false,                                
                                success: function (d) {
                                    if (parseInt(d.status) == 1) {
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
        $(document).on("click", ".btn_remove_file", function () {
            event.preventDefault();
            var id = $(this).attr("data-id");
            $.confirm({
                title: 'Hapus!',
                content: 'Apakah anda ingin menghapus gambar ini ?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-danger',
                        text: 'Ya',
                        action: function () {
                            var data = {
                                action: 'remove_file',
                                id: id
                            }
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: data,
                                dataType: 'json',
                                cache: false,                                
                                success: function (d) {
                                    if (parseInt(d.status) == 1) {
                                        // notif(1, d.message);
                                        $("#gambar_"+id).remove();
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
            var kode = $(this).attr("data-kode");
            var nama = $(this).attr("data-nama");
            $.confirm({
                title: 'Set Status',
                content: 'Apakah anda ingin <b>' + msg + '</b> dengan judul <b>' + nama + '</b> ?',
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
                                action: 'set-active',
                                id: id,
                                flag: set_flag,
                                nama: nama,
                                kode: kode
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

        // Set Preview
        $(document).on("click", ".btn-preview", function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var title = $(this).attr("data-title");
            var urls = $(this).attr("data-url");
            var category = $(this).attr("data-category");
            var final_url = category + '/' + urls;
            $.confirm({
                title: 'Pengalihan Halaman',
                content: 'Anda akan diarahkan ke halaman <b>' + url_preview + final_url + '</b>',
                columnClass: 'col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
                autoClose: 'button_2|10000',
                closeIcon: true,
                closeIconClass: 'fas fa-times',
                buttons: {
                    button_1: {
                        text: 'Lanjutkan',
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function () {
                            window.open(url_preview + final_url);
                        }
                    },
                    button_2: {
                        text: 'Tutup',
                        btnClass: 'btn-danger',
                        keys: ['Escape'],
                        action: function () {
                            //Close
                        }
                    }
                }
            });

        });

        $(document).on("click", "#btn-new", function (e) {
            formReset();
            projectID = 0;
            $("#div-form-trans").show(300);
            $(this).hide();
        });
        // Cancel Button
        $(document).on("click", "#btn-cancel", function (e) {
            formReset();
            projectID = 0;
            $("#btn-new").css('display', 'inline'); 
            $("#div-form-trans").hide(300);
        });
        
        $(document).on("click",".btn_edit_stock", function(e) {
            
            let id      = $(this).attr('data-id');
            let name    = $(this).attr('data-name');
            let stok    = $(this).attr('data-stok');
            let satuan    = $(this).attr('data-satuan');
            let harga    = $(this).attr('data-price');                        

            let title   = 'Perbarui Stok';
            $.confirm({
                title: title,
                columnClass: 'col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
                autoClose: 'button_2|20000',
                closeIcon: true, closeIconClass: 'fas fa-times', 
                animation:'zoom', closeAnimation:'bottom', animateFromElement:false, useBootstrap:true,
                content: function(){
                },
                onContentReady: function(e){
                    let self    = this;
                    let content = '';
                    let dsp     = '';
        
                    /* dsp += '<div>Content is ready after process !</div>'; */
                    dsp += '<form id="jc_form">';
                        dsp += '<div class="col-md-8 col-xs-8 col-sm-8 padding-remove-side">';
                        dsp += '    <div class="form-group">';
                        dsp += '    <label class="form-label">Stok Sekarang</label>';
                        dsp += '        <input id="jc_input" name="jc_input" class="form-control" value="'+stok+'">';
                        dsp += '    </div>';
                        dsp += '</div>';
                        dsp += '<div class="col-md-8 col-xs-8 col-sm-8 padding-remove-side">';
                        dsp += '    <div class="form-group">';
                        dsp += '    <label class="form-label">Harga</label>';
                        dsp += '        <input id="jc_input_2" name="jc_input_2" class="form-control" value="'+harga+'">';
                        dsp += '    </div>';
                        dsp += '</div>';                        
                        dsp += '<div class="col-md-4 col-xs-4 col-sm-4 padding-remove-side">';
                        dsp += '    <div class="form-group">';
                        dsp += '    <label class="form-label">Satuan</label>';
                        dsp += '        <input id="jc_input2" name="jc_input2" class="form-control" value="'+satuan+'" readonly>';
                        dsp += '    </div>';
                        dsp += '</div>';                        
                    dsp += '</form>';
                    content = dsp;
                    self.setContentAppend(content);
                    // self.buttons.button_1.disable();
                    // self.buttons.button_2.disable();
        
                    // this.$content.find('form').on('submit', function (e) {
                    //      e.preventDefault();
                    //      self.$$formSubmit.trigger('click'); // reference the button and click it
                    // });
                    // let mSTOK2 = new AutoNumeric('#jc_input', autoNumericOption);
                },
                buttons: {
                    button_1: {
                        text:'Update',
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function(e){
                            let self      = this;
        
                            let input     = self.$content.find('#jc_input').val();
                            let input2     = self.$content.find('#jc_input_2').val();                            
                            
                            if(!input){
                                notif(0,'Qty mohon diisi dahulu');
                                return false;
                            } else if(!input2){
                                notif(0,'Harga mohon diisi dahulu');
                                return false;
                            } else{
                                let form = new FormData();
                                form.append('action', 'update_stock_price');
                                form.append('product_id',id);
                                form.append('product_stock', input);
                                form.append('product_price_sell', input2);                                
                                $.ajax({
                                    type: "post",
                                    url: url,
                                    data: form, dataType: 'json',
                                    cache: 'false', contentType: false, processData: false,
                                    beforeSend:function(x){
                                        // x.setRequestHeader('Authorization',"Bearer " + bearer_token);
                                        // x.setRequestHeader('X-CSRF-TOKEN',csrf_token);
                                    },
                                    success: function(d) {
                                        let s = d.status;
                                        let m = d.message;
                                        let r = d.result;
                                        if(parseInt(s) == 1){
                                            notif(s, m);
                                            index.ajax.reload(null,false);
                                        }else{
                                            // notif(s,m);
                                        }
                                    },
                                    error: function(xhr, status, err) {}
                                });
                            }
                        }
                    },
                    button_2: {
                        text: 'Cancel',
                        btnClass: 'btn-danger',
                        keys: ['Escape'],
                        action: function(){
                            //Close
                        }
                    }
                }
            });
        });
        /*
        $('#upload1').change(function (e) {
            var fileName = e.target.files[0].name;
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-preview1').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });
        */
        //Image Croppie
        $(document).on('change', '#files_1', function(e) {
            if($("#files_1").val() == ''){
                $("#files_preview_1").attr('src', url_image);
                $("#files_link_1").attr('href', url_image);            
                $("#files_preview_1").attr('data-save-img', '');              
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                upload_crop_img_1.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    $("#modal_croppie_1").modal("show");                
                    setTimeout(function(){$('#modal_croppie_canvas_1').croppie('bind');}, 300);
                });
            };
            reader.readAsDataURL(this.files[0]);
        });
        $(document).on('change', '#files_2', function(e) {
            if($("#files_2").val() == ''){
                $("#files_preview_2").attr('src', url_image);
                $("#files_link_2").attr('href', url_image);            
                $("#files_preview_2").attr('data-save-img', '');              
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                upload_crop_img_2.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    $("#modal_croppie_2").modal("show");                
                    setTimeout(function(){$('#modal_croppie_canvas_2').croppie('bind');}, 300);
                });
            };
            reader.readAsDataURL(this.files[0]);
        });
        $(document).on('change', '#files_3', function(e) {
            if($("#files_3").val() == ''){
                $("#files_preview_3").attr('src', url_image);
                $("#files_link_3").attr('href', url_image);            
                $("#files_preview_3").attr('data-save-img', '');              
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                upload_crop_img_3.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    $("#modal_croppie_3").modal("show");                
                    setTimeout(function(){$('#modal_croppie_canvas_3').croppie('bind');}, 300);
                });
            };
            reader.readAsDataURL(this.files[0]);
        });
        $(document).on('change', '#files_4', function(e) {
            if($("#files_4").val() == ''){
                $("#files_preview_4").attr('src', url_image);
                $("#files_link_4").attr('href', url_image);            
                $("#files_preview_4").attr('data-save-img', '');              
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                upload_crop_img_4.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    $("#modal_croppie_4").modal("show");                
                    setTimeout(function(){$('#modal_croppie_canvas_4').croppie('bind');}, 300);
                });
            };
            reader.readAsDataURL(this.files[0]);
        });                
        $(document).on('click', '#modal_croppie_cancel_1', function(e){
            e.preventDefault();
            e.stopPropagation();
            $("#files_1").val('');
            $("#files_preview_1").attr('data-save-img', '');
            $("#files_preview_1").attr('src', url_image);
            $("#files_link_1").attr('href', url_image);
        });
        $(document).on('click', '#modal_croppie_cancel_2', function(e){
            e.preventDefault();
            e.stopPropagation();
            $("#files_2").val('');
            $("#files_preview_2").attr('data-save-img', '');
            $("#files_preview_2").attr('src', url_image);
            $("#files_link_2").attr('href', url_image);
        });     
        $(document).on('click', '#modal_croppie_cancel_3', function(e){
            e.preventDefault();
            e.stopPropagation();
            $("#files_3").val('');
            $("#files_preview_3").attr('data-save-img', '');
            $("#files_preview_3").attr('src', url_image);
            $("#files_link_3").attr('href', url_image);
        });
        $(document).on('click', '#modal_croppie_cancel_4', function(e){
            e.preventDefault();
            e.stopPropagation();
            $("#files_4").val('');
            $("#files_preview_4").attr('data-save-img', '');
            $("#files_preview_4").attr('src', url_image);
            $("#files_link_4").attr('href', url_image);
        });                
        $(document).on('click', '#modal_croppie_save_1', function(e){
            e.preventDefault();
            e.stopPropagation();
            upload_crop_img_1.croppie('result', {
                type: 'canvas',
                size: 'viewport',
            }).then(function (resp) {
                $("#files_preview_1").attr('src', resp);
                $("#files_link_1").attr('href', resp);
                $("#files_preview_1").attr('data-save-img', resp);
                $("#modal_croppie_1").modal("hide");
            });
        });     
        $(document).on('click', '#modal_croppie_save_2', function(e){
            e.preventDefault();
            e.stopPropagation();
            upload_crop_img_2.croppie('result', {
                type: 'canvas',
                size: 'viewport',
            }).then(function (resp) {
                $("#files_preview_2").attr('src', resp);
                $("#files_link_2").attr('href', resp);
                $("#files_preview_2").attr('data-save-img', resp);
                $("#modal_croppie_2").modal("hide");
            });
        });  
        $(document).on('click', '#modal_croppie_save_3', function(e){
            e.preventDefault();
            e.stopPropagation();
            upload_crop_img_3.croppie('result', {
                type: 'canvas',
                size: 'viewport',
            }).then(function (resp) {
                $("#files_preview_3").attr('src', resp);
                $("#files_link_3").attr('href', resp);
                $("#files_preview_3").attr('data-save-img', resp);
                $("#modal_croppie_3").modal("hide");
            });
        });     
        $(document).on('click', '#modal_croppie_save_4', function(e){
            e.preventDefault();
            e.stopPropagation();
            upload_crop_img_4.croppie('result', {
                type: 'canvas',
                size: 'viewport',
            }).then(function (resp) {
                $("#files_preview_4").attr('src', resp);
                $("#files_link_4").attr('href', resp);
                $("#files_preview_4").attr('data-save-img', resp);
                $("#modal_croppie_4").modal("hide");
            });
        });                          
        function loadFiles(product_id){
            var data = {
                action: 'read_files',
                id: product_id
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                cache: false,
                beforeSend: function () {},
                success: function (d) {
                    if (parseInt(d.status) == 1) { /* Success Message */
                        let rr = d.result;
                        if(rr.length > 0){
                            $(".gambar").html('');
                            var dsp = '';
                            rr.forEach(async (v, i) => {
                        
                                dsp += '<div class="col-md-3 col-sm-6" id="gambar_'+v['file_id']+'">';
                                    dsp += '<button class="btn btn-danger btn_remove_file" style="position:absolute;" data-id="'+v['file_id']+'"><i class="fas fa-trash"></i> Hapus</button>';
                                    dsp += '<img class="img-responsive" src="'+set_url + v['file_url']+'" style="width:100%;">';
                                dsp += '</div>';
                        
                            });
                            $(".gambar").html(dsp);
                        }                        
                    }
                },
                error: function (xhr, Status, err) {
                    notif(0, 'Error');
                }
            });                    
        }
    });

    function formReset() {
        formMasterSetDisplay(0);
        $('#content-description').summernote('code', '');
        $("#form-master input").val('');
        $("#btn-new").hide();
        $("#btn-update").hide();        
        $("#btn-save").show();
        $("#btn-cancel").show();
        $(".gambar").html('');
    }
    function formMasterSetDisplay(value) { // 1 = Untuk Enable/ ditampilkan, 0 = Disabled/ disembunyikan
        if (value == 1) {
            var flag = true;
        } else {
            var flag = false;
        }
        //Attr Input yang perlu di setel
        var form = '#form-master';
        var attrInput = [
            "tags",
            "keywords",
            "title",
        ];

        for (var i = 0; i <= attrInput.length; i++) {
            $("" + form + " input[name='" + attrInput[i] + "']").attr('readonly', flag);
        }

        //Attr Textarea yang perlu di setel
        var attrText = [
            "short",
            "content-description"
        ];
        for (var i = 0; i <= attrText.length; i++) {
            $("" + form + " textarea[name='" + attrText[i] + "']").attr('readonly', flag);
        }

        //Attr Select yang perlu di setel
        var atributSelect = [
            "categories",
            "status",
            "posisi"
        ];
        for (var i = 0; i <= atributSelect.length; i++) {
            $("" + form + " select[name='" + atributSelect[i] + "']").attr('disabled', flag);
        }
    }
</script>