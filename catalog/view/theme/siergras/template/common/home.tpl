<?php echo $header; ?></div><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" ><?php echo $content_top; ?>
<h1 style="display: none;"><?php echo $heading_title; ?></h1>

<div class="container">
    <div class="span-24">
        <div class="span-13">
           	<div id='my_carousel_ct' class='carousel-container' style="float:left;">  
				<div id="my_carousel_1" class="carousel slide">
					<div id="my_carousel_2" class="carousel-inner rs-slider">
						<?php $first = true; ?>
						<?php foreach ($products_for_slider as $key => $value) {
							if($first == TRUE){ ?>
								<div class="item active">
							<?php $first = false; } else{ ?>
								<div class="item ">
							<?php } ?>
									<a href="index.php?route=product/product&product_id=<?php echo $value['product_id']; ?>" style="text-decoration: none;">
										<div class="ts_border">
											<img src="<?php echo '/image/' . $value['image']; ?>" />
											<!-- <div class="carousel-caption"> -->
											<div class="homePageSliderCaption">
												<h4 style="color:white; font-size: 20px;"><?php echo $value['name']; ?></h4>
											</div>
										</div>
									</a>
								</div>
						<?php } ?>
					</div>
					
					<!-- Carousel nav -->
					<a class="carousel-custom" href="#my_carousel_1" data-slide="prev">&lsaquo;</a>
					<a class="carousel-custom" href="#my_carousel_1" data-slide="next">&rsaquo;</a>
				</div>
			</div>
        </div>
        <div class="span-11 last">
        	<a href="index.php?route=product/special">
	        	<div style="position: relative; background: url('/image/IG_7719_1.jpg'); background-size: cover; width: 400px; height: 200px;">
	        		<div style="position: absolute; bottom: 0; width: 400px; font-weight: bold; color: #fff;" class="homePageCaption">
						<p>AANBIEDINGEN</p>
					</div>
	        	</div>
	        </a>
	        <br />

			<a href="index.php?route=information/information&information_id=8">
				<div style="position: relative; background: url('/image/Luzula_sylvatica_Marginata_I32784P98262.jpg'); background-size: cover; width: 400px; height: 200px;">
	        		<div style="position: absolute; bottom: 0; width: 400px; font-weight: bold; color: #fff;" class="homePageCaption">
						<p>OVER ONS</p>
					</div>
	        	</div>
			</a>

        </div>
        <div class="span-15 append-1" style="margin-top: 20px;">
            <a href="index.php?route=information/information&information_id=10">
				<div style="position: relative; background: url('/image/newsletter.png'); background-size: cover; width: 600px; height: 200px;">
	        		<div style="position: absolute; bottom: 0; width: 600px; font-weight: bold; color: #fff;" class="homePageCaption">
						<p>VEEL GESTELDE VRAGEN</p>
					</div>
	        	</div>
			</a>
        </div>
        <div class="span-8 last" style="margin-top: 20px;">
            <a href="#">
				<div style="position: relative; background: url('/image/facebook.png'); background-size: cover; width: 280px; height: 200px;">
	        		<div style="position: absolute; bottom: 0; width: 280px; font-weight: bold; color: #fff;" class="homePageCaption">
						<p>VOLG ONS OP<br />FACEBOOK</p>
					</div>
	        	</div>
			</a>
        </div>
    </div>
</div>


<?php echo $content_bottom; ?></div>

<script src="/catalog/view/theme/siergras/js/wpts_slider_multiple.js"></script>
<script>
	$(document).ready(function(e) {
		// autoplay : 3000,
		$('#my_carousel_ct').tsSlider({
			thumbs : '',
			width : '500',
			showText : true,
			autoplay : 3000,
			imgWidth : 100,
			imgHeight : 100,
			imgMarginTop : 0,
			imgMarginLeft : 0,
			squared : true,
			textSquarePosition : 4,
			textPosition : 'bottom',
			imgAlignment : 'Center',
			textColor : 'F00',
			skin : 'transparent',
			arrows : 'ts-arrow-1',
			sliderHeight : 420,
			effects : '',
			titleBold : 'false',
			titleItalic : 'false',
			textBold : 'true',
			textItalic : 'false',
			textWidth : 90,
			background_sld : '#FFF',
			background_caption : '#000'
		});
	}); 
</script>
<?php echo $footer; ?>