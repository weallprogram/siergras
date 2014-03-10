<?php
/*
  Project: Ka Extensions
  Author : karapuz <support@ka-station.com>

  Version: 2.0 ($Revision$)
*/

?>
<?php if (!empty($breadcrumbs)) { ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php } ?>

<?php if (!empty($top_messages)) { ?>
  <?php foreach ($top_messages as $top_message) { ?>
    <?php if ($top_message['type'] == 'E') { ?>
    <div class="warning"><?php echo $top_message['content']; ?></div>
    <?php } else { ?>
    <div class="success"><?php echo $top_message['content']; ?></div>
    <?php } ?>
  <?php } ?>
<?php } ?>