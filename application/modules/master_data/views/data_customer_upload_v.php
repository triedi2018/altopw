<div class="modal fade modal-action" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= ucwords($this->uri->segment(3,0))?> Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
  <form method="post" action="" enctype="multipart/form-data" role="form" id="form-action2">
  <div style="padding:10px;">
  	  <div class="form-group">
		<label for="file">File : </label>
		<input type="file" name='file' id="uploadFile" value="" class='form-control' placeholder='file' title='File' />
	  </div>
  </div>
  
	
  <div class="form-group">
	<div class="col-md-6"><input id="btn-upload" type="submit" name='submit' id='submit' value='Upload' class="form-control btn btn-success" /></div>
  </div>
  </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
