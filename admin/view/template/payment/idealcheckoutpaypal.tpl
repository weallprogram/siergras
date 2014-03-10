<?php 

	// Load gateway setings
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/idealcheckout/includes/library.php');
	$aGatewaySettings = idealcheckout_getGatewaySettings(false, 'paypal');

echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">    
    <div class="heading">
      <h1>iDEAL Checkout - PayPal</h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <p>Via deze plugin kunt u PayPal betalingen ontvangen in uw webshop via diverse Payment Service Providers.</p>
      <p>Deze plugin is momenteel geconfigureerd om PayPal transacties te verwerken via <b><?php echo htmlspecialchars($aGatewaySettings['GATEWAY_NAME']); ?></b>.<br>Meer informatie over deze Payment Service Provider vind u op <a href="<?php echo htmlspecialchars($aGatewaySettings['GATEWAY_WEBSITE']); ?>" target="_blank"><?php echo htmlspecialchars($aGatewaySettings['GATEWAY_WEBSITE']); ?></a></p>

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general" class="page">
          <table class="form">
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="idealcheckoutpaypal_status">
                  <?php if ($idealcheckoutpaypal_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="idealcheckoutpaypal_sort_order" value="<?php echo $idealcheckoutpaypal_sort_order; ?>" size="1" /></td>
            </tr>
          </table>
        </div>
      </form>

<?php
	
	$sHtml = '';

	if($aGatewaySettings['GATEWAY_VALIDATION'])
	{
		$sHtml .= '
<p>&nbsp;</p>
<h2>Transacties Controleren</h2>
<p>Controleer de status van alle openstaande transacties bij uw Payment Service Provider.</p>
<p><input type="button" value="Controleer openstaande transacties." onclick="javascript: window.open(\'' . idealcheckout_getRootUrl(1) . 'idealcheckout/validate.php?gateway=paypal\', \'popup\', \'directories=no,height=550,location=no,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no,width=750\');"></p>';
	}

	$sHtml .= '
<p>&nbsp;</p>
<h2>Over deze plugin</h2>
<p>Deze PayPal plugin is ontwikkeld door <a href="https://www.ideal-checkout.nl" target="_blank">iDEAL Checkout</a> en is GRATIS te downloaden via <a href="http://www.ideal-checkout.nl" target="_blank">http://www.ideal-checkout.nl</a>.<br><br>- Voor vragen over deze plugin kunt u kijken op <a href="http://www.ideal-checkout.nl" target="_blank">http://www.ideal-checkout.nl</a> of mailen naar <a href="mailto:info@ideal-checkout.nl">info@ideal-checkout.nl</a><br>- Feedback en donaties<br>- Het gebruik van onze plugins/scripts is geheel op eigen risico.</p>';
	
	echo $sHtml;

?>

    </div>
  </div>
</div>
<?php echo $footer; ?> 