<script>
    $(document).ready(function() {   
        let url = "<?= base_url('website/appointment'); ?>";

        $(document).on("click","#btn_save", function(e) {
            e.preventDefault();
            e.stopPropagation();
            let form = new FormData($("#form_appointment")[0]);
            form.append('action', 'appointment_create');
            $.ajax({
                type: "post",
                url: url,
                data: form, 
                dataType: 'json', cache: 'false', 
                contentType: false, processData: false,
                beforeSend:function(x){
                    // x.setRequestHeader('Authorization',"Bearer " + bearer_token);
                    // x.setRequestHeader('X-CSRF-TOKEN',csrf_token);
                },
                success:function(d){
                    let s = d.status;
                    let m = d.message;
                    let r = d.result;
                    if(parseInt(s) == 1){
                        notif(s,m);
                        /* hint zz_for or zz_each */
                        
                    }else{
                        notif(s,m);
                    }
                },
                error:function(xhr,status,err){
                    notif(0,err);
                }
            });
        });
        
    });
</script>