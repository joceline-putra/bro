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
                                                    <!-- <button id="btn_export_name" onClick="" class="btn btn-default btn-small" type="button" style="display: inline;">
                                                        <i class="fas fa-file-excel"></i>
                                                        Ekspor Excel
                                                    </button> -->
                                                    <!-- <button id="btn_new_name" class="btn btn-success btn-small" type="button" style="display: inline;">
                                                        <i class="fas fa-plus"></i>
                                                        Buat <?php echo $title; ?> Baru
                                                    </button> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side" style="padding-top:8px;">
                                            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6 form-group padding-remove-right prs-15">
                                                <label class="form-label">Periode Awal</label>
                                                <div class="col-md-12 col-sm-12 padding-remove-side">
                                                    <div class="input-append success date col-md-12 col-lg-12 no-padding">
                                                        <input name="filter_start_date" id="filter_start_date" type="text" class="form-control input-sm" readonly="true" value="<?php echo $end_date;?>">
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
                                            <div class="col-lg-4 col-md-8 col-xs-12 col-sm-12 form-group padding-remove-right prs-15">
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
                                                        <option value="1">Konfirmasi</option>
                                                        <option value="0">Nonaktif</option>
                                                        <option value="4">Batal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6 form-group padding-remove-right prs-15">
                                                <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                                    <label class="form-label">Terbayar</label>
                                                    <select id="filter_paid_flag" name="filter_paid_flag" class="form-control">
                                                        <option value="All">Semua</option>
                                                        <option value="0">Unpaid</option>
                                                        <option value="1">Paid</option>                                                                                                                        
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
                                        <div class="col-md-12 col-xs-12 col-sm-12" style="padding-top:10px;padding-bottom:40px;">
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
<div class="modal fade" id="modal_order" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-12 col-sm-12 col-xs-12 padding-remove-side">
                        <h5><b><?php echo $title;?></b></h5>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-remove-side"> 
                                <form id="form_order" name="form_forder" action="">
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                        <label class="form-label">Nomor</label>    
                                            <div class="controls">                                        
                                                <input id="order_number" name="order_number" class="form-control" type="text" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4 col-xs-12 padding-remove-side">
                                        <div class="form-group">
                                            <label class="form-label">Label</label>
                                            <div class="controls">
                                                <input name="input_name" id="input_name" type="text" class="form-control input-sm" readonly="true">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                        <label class="form-label">Tanggal</label>
                                            <div class="controls">       
                                                <input id="order_date" name="order_date" type="text" class="form-control" value="" readonly>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                        <label class="form-label">Customer</label>
                                            <div class="controls">       
                                                <input id="order_contact_name" name="order_contact_name" class="form-control" type="text" value="" readonly>
                                            </div>    
                                        </div>
                                    </div>   
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                        <label class="form-label">WhatsApp</label>
                                            <div class="controls">       
                                                <input id="order_contact_phone" name="order_contact_phone" class="form-control" type="text" value="" readonly>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                        <label class="form-label">Tgl Kedatangan</label>
                                            <div class="controls">       
                                                <input id="order_item_start_date" name="order_item_start_date" class="form-control" type="text" value="" readonly>
                                            </div>    
                                        </div>
                                    </div>   
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                        <label class="form-label">Layanan</label>
                                            <div class="controls">       
                                                <input id="order_item_product_id" name="order_item_product_id" class="form-control" type="text" value="" readonly>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                        <label class="form-label">Total</label>
                                            <div class="controls">       
                                                <input id="order_total" name="order_total" type="text" value="" readonly>
                                            </div>
                                        </div>
                                    </div>                                                                           
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group padding-remove-side">
                                        <div class="col-lg-12 col-md-12 col-xs-12 padding-remove-side form-group">
                                            <label class="form-label">Status</label>
                                            <select id="order_flag" name="order_flag" class="form-control" style="width:100%;">
                                                <option value="1">Aktif</option>
                                                <option value="0">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group padding-remove-side">
                                        <div class="col-lg-12 col-md-12 col-xs-12 padding-remove-side form-group">
                                            <label class="form-label">Pembayaran</label>
                                            <select id="order_paid" name="order_paid" class="form-control" style="width:100%;">
                                                <option value="1">Aktif</option>
                                                <option value="0">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>                   
            </div>
            <div class="modal-footer">
                <!-- <button id="btn_cancel_faq" class="btn btn-warning btn-small" type="reset" style="display: inline;">
                    <i class="fas fa-ban"></i> 
                    Cancel
                </button>
                <button id="btn_save_faq" class="btn btn-primary btn-small" type="button" style="display:inline;">
                    <i class="fas fa-save"></i>
                    Save
                </button>               -->
            </div>
        </div>
    </div>
</div>