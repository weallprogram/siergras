<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  
  <h1 style="padding-left: 25px;"><?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?></h1>
  
  <?php if ($thumb || $description) { ?>
  <div class="category-info clearfix">
    <?php if ($thumb) { ?>
    <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <div class="description">
    <?php if ($description) { ?>
    <?php echo $description; ?>
    <?php } ?>
    </div>
    
  </div>
  <?php } ?>
  <?php if ($categories) { ?>
	<?php $tdCounter = 0; ?>
	<h2><?php echo $text_refine; ?></h2>
	<div class="category-list">
		<table style="border-spacing: 10px;">
		<?php if (count($categories) <= 5) { ?>
			<tr>
				<?php foreach ($categories as $category) { ?>
					<td><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></td>
					<?php $tdCounter++;
					if($tdCounter == 4){ ?>
						</tr><tr>
						<?php $tdCounter = 0; ?>
					<?php } ?>
				<?php } ?>
			</tr>
		<?php } else { ?>
			<tr>
			<?php for ($i = 0; $i < count($categories);) { ?>
					<?php $j = $i + ceil(count($categories) / 4); ?>
					<?php for (; $i < $j; $i++) { ?>
						<?php if (isset($categories[$i])) { ?>
							<td><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></td>
							<?php $tdCounter++;
							if($tdCounter == 4){ ?>
								</tr><tr>
								<?php $tdCounter = 0; ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
			<?php } ?>
			</tr>
		<?php } ?>
		</table>
  </div>
  <?php } ?>
  <?php if ($products) { ?>

  <div class="container">
    <div class="span-24">
      <?php
        $collCounter = 0;
        $collMax = 3;
        foreach ($products as $product) {
          if($collCounter >= $collMax){
            echo '</div><div class="span-24" style="margin-top: 20px;">';
            $collCounter = 0;
          }
          $thumb = str_replace("/cache", "", $product['thumb']);
          $thumb = str_replace("-200x200", "", $thumb);
          ?>
          <div class="span-8" style="border-style:groove; background: url('<?php echo $thumb; ?>');width: 300px; height: 300px; background-size: cover;background-repeat: no-repeat;background-position: 50% 50%;" >
            <a href="<?php echo $product['href']; ?>">
              <div style="position: relative; height: 300px;">
                <div style="position: absolute; bottom: 0; width: 280px; font-weight: bold; padding-left: 10px; padding-right: 10px;" class="catPageTextCaption">
                  <p style="height: 50px;vertical-align: middle;"><?php echo $product['name']; ?></p>
                </div>
              </div>
            </a>
          </div>
          <?php $collCounter++;
        }
      ?>
    </div>
  </div>
  
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } ?>
  <?php if (!$categories && !$products) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div> 
<?php echo $footer; ?>