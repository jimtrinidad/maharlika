<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Uploaded Products</span>
          <span class="info-box-number"><?php echo number_format($product_count) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-tags"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Manufacturers/Origin</span>
          <span class="info-box-number"><?php echo number_format($origin_count) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-shopping-basket"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Stores</span>
          <span class="info-box-number"><?php echo number_format($store_count) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Registered Users</span>
          <span class="info-box-number"><?php echo number_format($user_count) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-orange"><i class="fa fa-credit-card-alt"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Link Wallet Balance</span>
          <span class="info-box-number"><?php echo peso($ecpay_wallet) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-olive"><i class="fa fa-credit-card"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Link Gate Balance</span>
          <span class="info-box-number"><?php echo peso($ecpay_gate) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-maroon"><i class="fa fa-briefcase"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Deposits</span>
          <span class="info-box-number"><?php echo peso($deposits) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-navy"><i class="fa fa-money"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Purchase/Payments</span>
          <span class="info-box-number"><?php echo peso($debits) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-teal"><i class="fa fa-gift"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Rewards</span>
          <span class="info-box-number"><?php echo peso($rewards) ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

  </div>