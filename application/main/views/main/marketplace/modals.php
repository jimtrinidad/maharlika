<div class="modal fade" id="addedToCartModal" role="dialog" aria-labelledby="addedToCartModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
          <div class="row p-2">
            <div class="col-12">
              <span class="text-success added_to_cart_message"></span>
            </div>
            <div class="col-12">
              <div style="width: 100px;" class="float-left">
                <img src="" class="added_to_cart_image" style="width: 90px;height: 90px;">
              </div>
              <div class="float-left">
                <h5 class="text-red added_to_cart_name"></h5>
                <p class="small added_to_cart_seller"></p>
                <strong class="price text-red added_to_cart_price"></strong>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="<?php echo site_url('marketplace/cart') ?>" class="btn btn-success">Go to cart</a>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Continue Shopping</button>
        </div>
      </form>
    </div>
  </div>
</div>