<style type="text/css">
  .menu-box {
    width: 80px;
    height: 110px;
    display:inline-block; 
    margin: 15px 5px;
    cursor: pointer;
  }
  .menu-box .menu-img-box {
    width: 75px;
    height: 90px;
    white-space: nowrap;
    border-radius: 5px;
    -moz-border-radius: 5px;
    text-align: center; 
  }
  .menu-box .helper {
    display: inline-block;
    height: 100%;
    vertical-align: middle;
  }

  .menu-box img {
    vertical-align: middle;
    max-height: 55px;
    max-width: 60px;
  }

  .menu-box .menu-box-label {
    color: gray;
    margin-top: 10px;
    text-align: center;
    font-size: 12px;
    display: inline-flex;
  }
</style>

<div class="row justify-content-center" id="dashboard-menu">
  <div class="col-md-7 text-center">

    <?php
      $menu_items = array(
        array(
          'icon'  => 'business.png',
          'bg'    => '#2b3d7f',
          'label' => 'My Business',
          'href'  => site_url('store')
        ),
        // array(
        //   'icon'  => 'eloading.png',
        //   'bg'    => '#fab33b',
        //   'label' => 'eLoad',
        //   'attr'  => array(
        //     'onclick' => 'Wallet.sendELoad()'
        //   )
        // ),
        // array(
        //   'icon'  => 'remittance.png',
        //   'bg'    => '#005f96',
        //   'label' => 'Fund MyWallet',
        //   'attr'  => array(
        //     'onclick' => 'Wallet.addDeposit()'
        //   )
        // ),
        // array(
        //   'icon'  => 'payment-services.png',
        //   'bg'    => '#004b68',
        //   'label' => 'Encash from MyWallet',
        // ),
        array(
          'icon'  => 'mywallet-rewards.png',
          'bg'    => '#fe6b3e',
          'label' => 'MyWallet & Rewards',
          'href'  => site_url('ewallet')
        ),
        array(
          'icon'  => 'bills-payment.png',
          'bg'    => '#b43343',
          'label' => 'Bills Payment',
          'attr'  => array(
            'onclick' => 'Wallet.addPayment()'
          )
        ),
        // array(
        //   'icon'  => 'ticketing.png',
        //   'bg'    => '#8c9ca1',
        //   'label' => 'Ticketing',
        // ),
        array(
          'icon'  => 'market.png',
          'bg'    => '#fd423e',
          'label' => 'Marketplace',
          'href'  => site_url('marketplace')
        ),
      );

      foreach ($menu_items as $i) {
        echo '<div class="menu-box" ';

        if (isset($i['attr'])) {
          foreach ($i['attr'] as $k => $v) {
            echo $k . '="' . $v . '" ';
          }
        }

        echo '>';

        if (isset($i['href']) && $i['href']) {
          echo '<a href="' . $i['href'] . '" style="text-decoration: none;">';
        }

          echo '<div class="menu-img-box" style="background: '. $i['bg'] .'">
                  <span class="helper"></span>
                  <img src="' . public_url() . 'resources/images/dashboard/' . $i['icon'] . '">
                </div>
                <div class="menu-box-label">
                  '. $i['label'] .'
                </div>';

        if (isset($i['href']) && $i['href']) {
          echo '</a>';
        }

        echo  '</div>';
      }
    ?>

  </div>
</div>