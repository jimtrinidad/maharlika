<section class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="<?php echo public_url('assets/profile/') . photo_filename($accountInfo->Photo); ?>" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p><?php echo user_full_name($accountInfo, false); ?></p>
      <!-- Status -->
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- /.search form -->
  <!-- Sidebar Menu -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">Main Menu</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="<?php echo (is_current_url('dashboard', 'index') ? 'active' : ''); ?>"><a href="<?php echo site_url() ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
    <li class="<?php echo (is_current_url('orders', 'index') ? 'active' : ''); ?>"><a href="<?php echo site_url('orders') ?>"><span>Orders</span></a></li>
    <li class="<?php echo (is_current_url('deposits', 'index') ? 'active' : ''); ?>"><a href="<?php echo site_url('deposits') ?>"><span>Deposits</span></a></li>
    <li class="<?php echo (is_current_url('transactions', 'ecpay') ? 'active' : ''); ?>"><a href="<?php echo site_url('transactions/ecpay') ?>"><span>Link Transactions</span></a></li>
    <li class="<?php echo (is_current_url('delivery', 'agents') ? 'active' : ''); ?>"><a href="<?php echo site_url('delivery/agents') ?>"><span>Delivery Agents</span></a></li>
    <li class="treeview">
      <a href="#"><span>Services</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="<?php echo (is_current_url('billers', 'index') ? 'active' : ''); ?>"><a href="<?php echo site_url('billers') ?>"><span>Billers</span></a></li>
        <li class="<?php echo (is_current_url('billers', 'ecash_services') ? 'active' : ''); ?>"><a href="<?php echo site_url('billers/ecash_services') ?>"><span>Ecash Services</span></a></li>
        <li class="<?php echo (is_current_url('billers', 'telco_topups') ? 'active' : ''); ?>"><a href="<?php echo site_url('telco/topups') ?>"><span>Telco Topups</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><span>Marketplace</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="<?php echo (is_current_url('product', 'categories') ? 'active' : ''); ?>"><a href="<?php echo site_url('product/categories') ?>">Categories</a></li>
        <li class="<?php echo (is_current_url('product', 'stores') ? 'active' : ''); ?>"><a href="<?php echo site_url('product/stores') ?>">Stores</a></li>
        <li class="<?php echo (is_current_url('product', 'manufacturers') ? 'active' : ''); ?>"><a href="<?php echo site_url('product/manufacturers') ?>">Manufacturers</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><span>Settings</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="<?php echo (is_current_url('settings', 'terms') ? 'active' : ''); ?>"><a href="<?php echo site_url('settings/terms') ?>">Terms & Condition</a></li>
        <li class="<?php echo (is_current_url('settings', 'how') ? 'active' : ''); ?>"><a href="<?php echo site_url('settings/how') ?>">How it Works</a></li>
        <li class="<?php echo (is_current_url('settings', 'fund_wallet_instruction') ? 'active' : ''); ?>"><a href="<?php echo site_url('settings/fund_wallet_instruction') ?>">Funding Wallet</a></li>
        <li class="<?php echo (is_current_url('settings', 'cloud') ? 'active' : ''); ?>"><a href="<?php echo site_url('settings/cloud') ?>">Ambilis Cloud</a></li>
      </ul>
    </li>
    <li class="<?php echo (is_current_url('outlets', 'index') ? 'active' : ''); ?>"><a href="<?php echo site_url('outlets') ?>"><span>Partner Outlets</span></a></li>
    <li class="<?php echo (is_current_url('accounts', 'index') ? 'active' : ''); ?>"><a href="<?php echo site_url('accounts') ?>"><span>Accounts</span></a></li>
  </ul>
<!-- /.sidebar-menu -->
</section>