<?php if (count($items)) { ?>

<table id="cart" class="table table-hover table-condensed">
  <thead>
    <tr>
      <th style="width:47%">Product</th>
      <th style="width:8%">Price</th>
      <th style="width:10%">Quantity</th>
      <th style="width:20%" class="text-center">Subtotal</th>
      <th style="width:15%"></th>
    </tr>
  </thead>
  <?php foreach ($items as $k => $store) { ?>
  <tbody>
    <tr>
      <th colspan="5" style="vertical-align: middle;">
        <b><a class="text-info" href="<?php echo site_url('business/'. $store['slug']) ?>"><?php echo $store['name'] ?></a></b>
      </th>
    </tr>
  <?php foreach ($store['items'] as $i) { ?>
    <tr id="rowid_<?php echo $i['rowid']; ?>">
      <td data-th="Product" style="padding-left: 30px;">
          <div class="float-left" style="width: 100px;"><img src="<?php echo public_url('assets/products/') . $i['img']?>" style="width: 60px;height: auto;" class="img-responsive" /></div>
          <div class="itemname">
            <b class="nomargin cart_product_name"><?php echo $i['name']; ?></b>
          </div>
          <div class="clearfix"></div>
      </td>
      <td data-th="Price"><?php echo show_price($i['distribution']['srp'], $i['distribution']['discount']); ?></td>
      <td data-th="Quantity">
        <input type="number" min="1" class="form-control text-center cart_item_qty" value="<?php echo $i['qty']; ?>">
      </td>
      <td data-th="Subtotal" class="text-center cart_item_subtotal"><?php echo peso($i['subtotal']); ?></td>
      <td class="actions text-right" data-th="">
        <button onclick="Marketplace.updateCartItem('<?php echo $i['rowid']; ?>')" class="btn btn-info btn-sm" title="Update"><i class="fa fa-refresh"></i></button>
        <button onclick="Marketplace.removeCartItem('<?php echo $i['rowid']; ?>')"class="btn btn-danger btn-sm" title="Remove"><i class="fa fa-trash-o"></i></button>
        <div class="clearfix"></div>
      </td>
    </tr>
  <?php } ?>
  </tbody>
  <?php } ?>
  <tfoot>
    <tr>
      <td><a href="<?php echo site_url('marketplace') ?>" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
      <td colspan="2" class=""></td>
      <td class="text-center"><strong class="cart_total_amount"><?php echo peso($this->cart->total()) ?></strong></td>
      <td><a href="<?php echo site_url('marketplace/checkout') ?>" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
    </tr>
  </tfoot>
</table>

<?php } else { ?>
  <div class="text-center">
    <h4>No item on cart!</h4>
    <a href="<?php echo site_url('marketplace') ?>" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
  </div>
<?php } ?>