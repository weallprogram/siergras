<div id="cart" class="mm_shopcart">
  <div class="heading">
    <a><span id="cart-total"><?php echo $ownData['totalFakePro']; ?> product(en) - &euro;<?php echo str_replace('.', ',', $ownData['totalAll']); ?><?php // echo $text_items; ?></span></a></div>
  <div class="content">
    <?php if ($products || $vouchers) { ?>
    <?php // $this -> log -> write(print_r($products, true)); ?>
    <div class="mini-cart-info">
      <table>
        <?php foreach ($products as $product) { ?>
        <tr>
          <td>
            <table>
              <?php foreach ($product['option'] as $option) { ?>
                <tr>
                  <td class="image"><?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                  <?php } ?></td>
                  <td class="name" style="text-align: left;">
                  <?php echo $option['optTimes']; ?>x 
                  <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                  <?php echo $option['value']; ?>
                  </td>
                  <td style="text-align: left;">
                      &euro;<?php echo number_format((float)$option['optTotal'], 2, '.', '');; ?>
                  </td>
                  <td class="remove">
                    <img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove_opt=<?php echo rawurlencode($product['key']); ?>,<?php echo $option['optID']; ?>' : $('#cart').load('index.php?route=module/cart&remove_opt=<?php echo rawurlencode($product['key']); ?>,<?php echo $option['optID']; ?>' + ' #cart > *');" />
                  </td>
                </tr>
              <?php } ?>
            </table>
          </td>
        </tr><!--
        <tr>
          <td class="image"><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
            <?php } ?></td>
          <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
            </div></td>
          <td class="quantity">x&nbsp;<?php echo $product['totalOptions']; ?> </td>
          <td class="total">&euro;<?php echo $product['newTotal']; ?></td>
          <td class="remove"><img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $product['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $product['key']; ?>' + ' #cart > *');" /></td>
        </tr> -->
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td class="image"></td>
          <td class="name"><?php echo $voucher['description']; ?></td>
          <td class="quantity">x&nbsp;1</td>
          <td class="total"><?php echo $voucher['amount']; ?></td>
          <td class="remove"><img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $voucher['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $voucher['key']; ?>' + ' #cart > *');" /></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <div class="mini-cart-total">
      <table>
        <?php foreach ($totals as $total) { ?>
        <?php // $this -> log -> write("totals: " . print_r($total, true)); ?>
        <tr>
          <td style="float: right;"><b><?php echo $total['title']; ?>:</b> <?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <div class="checkout"><a class="button" href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a> <a class="button" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></div>
    <?php } else { ?>
    <div class="empty"><?php echo $text_empty; ?></div>
    <?php } ?>
  </div>
</div>