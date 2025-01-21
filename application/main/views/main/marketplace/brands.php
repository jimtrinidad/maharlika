<div class="product-listing mt-4">
    <?php
    if (count($records)) {
      $i = 1;
      echo '<div class="row gutter-5">';
      foreach ($records as $item) {
        // var_dump(($i % 8));
        
        echo '<div class="col text-center d-none d-md-block">';
          echo '<a href="'.site_url('marketplace/?b=' . $item['Name']).'">';
            echo '<img class="p-2 img-fluid" src="'.public_url() . 'assets/products/' . product_filename($item['PartnerImage']) .'" title="'.$item['Name'].'">';
          echo '</a>';
        echo '</div>';

        echo '<div class="col-3 text-center d-block d-md-none">';
          echo '<a href="'.site_url('marketplace/?b=' . $item['Name']).'">';
            echo '<img class="p-2 img-fluid" src="'.public_url() . 'assets/products/' . product_filename($item['PartnerImage']) .'" title="'.$item['Name'].'">';
          echo '</a>';
        echo '</div>';
        
        if (($i % 8) == 0) {
          echo '</div><div class="row gutter-5">';
        }
        if ($i >= count($records)) {
          echo '</div>';
        }
        $i++;
      }
    } else {
        echo '<div class="col-sm-12"><h4 class="h4">No record found.</h4></div>';
    }
    ?>
</div>