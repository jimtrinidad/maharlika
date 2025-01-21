<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form id="categoryForm" name="categoryForm" class="modalForm" action="<?php echo site_url('product/save_category') ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide row">
            <br>
            <div class="error_messages no-border-radius alert alert-danger" role="alert"></div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-xs-12 logo padding-top-10">
                <div class="image-upload-container">
                  <img class="image-preview" src="<?php echo public_url(); ?>assets/uploads/default.png">
                  <span class="hiddenFileInput hide">
                    <input type="file" data-default="<?php echo public_url(); ?>assets/uploads/default.png" accept="image/*" class="image-upload-input" id="Logo" name="Logo"/>
                  </span>
                </div>
              </div>
              <div class="col-xs-12 padding-top-15">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label" for="Name">Category Name</label>
                      <input type="text" class="form-control" id="Name" name="Name" placehoder="Name">
                      <span class="help-block hidden"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" id="Code" name="Code">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="subCategoryModal" tabindex="-1" role="dialog" aria-labelledby="subCategoryModal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form id="subCategoryForm" name="subCategoryForm" class="modalForm" action="<?php echo site_url('product/save_sub_category') ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide row">
            <br>
            <div class="error_messages no-border-radius alert alert-danger" role="alert"></div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-xs-12 logo padding-top-10">
                <div class="image-upload-container">
                  <img class="image-preview" src="<?php echo public_url(); ?>assets/uploads/default.png">
                  <span class="hiddenFileInput hide">
                    <input type="file" data-default="<?php echo public_url(); ?>assets/uploads/default.png" accept="image/*" class="image-upload-input" id="Logo" name="Logo"/>
                  </span>
                </div>
              </div>
              <div class="col-xs-12 padding-top-15">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label" for="Name">Sub Category Name</label>
                      <input type="text" class="form-control" id="Name" name="Name" placehoder="Name">
                      <span class="help-block hidden"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" id="Code" name="Code">
          <input type="hidden" id="CategoryID" name="CategoryID">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>