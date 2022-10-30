<script>
    $('.btn-action').on('click',function(e){
        let id = e.target.dataset.id;
        show_loading()
        $.ajax({
            method: "POST",
            url : "<?= base_url($this->uri->segment(1,0).$this->uri->slash_segment(2,'both')) ?>edit",
            data : "level_user="+id,
            success : function(response){
                hide_loading();
                $('.tampil-modal').html(response);
                $('.modal-action').modal({
                    backdrop:'static',
                    keyboard:false
                },'show');
            }
        })
    })

</script>