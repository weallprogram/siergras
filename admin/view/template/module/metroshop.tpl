<?php echo $header; ?>
<link  href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400" rel="stylesheet" type="text/css" >
<link rel="stylesheet" type="text/css" href="view/stylesheet/css/colorpicker.css" />
<script type="text/javascript" src="view/javascript/jquery/colorpicker.js"></script>
<script type="text/javascript" src="../catalog/view/theme/metroshop/js/jquery.form.js"></script>
<script src="view/javascript/jquery/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="view/stylesheet/css/uniform.default.css" type="text/css" media="screen">
<div id="content">
<style type="text/css">
.htabs a {
	background:#f3f3f3;
	color:#000;
	font-family:'Source Sans Pro', Arial;
	font-weight:300;
	font-size:16px;
}
a:hover {
	color:#58BAE9;
}
.font-preview {
	<?
	if (!isset($metroshop_header_fontsize)) {
                	
		 $metroshop_header_fontsize = '24';
            
	}
	?>
	font-size:<?=$metroshop_header_fontsize?>px;

}

.htabs {
	width:130px;
	float:left;
	padding-left:0px;
}
.htabs a {
	width:130px;
	text-align:left;
	padding-top:10px;
	padding-bottom:10px;
	font-weight:400;
	
	-webkit-transition: background-color 200ms linear;
	-moz-transition: background-color 200ms linear;
	-o-transition: background-color 200ms linear;
	-ms-transition: background-color 200ms linear;
	transition: background-color 200ms linear;
}
.htabs img {
	margin-right:10px;
}
.htabs a:last-child {
	border-bottom: 1px solid #DDDDDD;
}
.theme_support {
	color:#24527d!important;
}
.hcontent {
	font-family: 'Source Sans Pro', Arial;
	border-left: 1px solid #DDDDDD;
	border-top: 1px solid #DDDDDD;
	margin-left:160px;
	min-height:440px;
	padding-top:10px;
}
.content {
	font-family: 'Source Sans Pro', Arial!important;
	font-size:14px;
}
.hcontent td {
	font-family: 'Source Sans Pro', Arial;
	font-size:14px;
}
.hcontent div {
	margin-left:20px;
}
.hcontent div.selector {
	margin-left:0px!important;
}
.htabs a:hover {
	color:#000;
	background:#f9f9f9;
	
	-webkit-transition: background-color 300ms linear;
	-moz-transition: background-color 300ms linear;
	-o-transition: background-color 300ms linear;
	-ms-transition: background-color 300ms linear;
	transition: background-color 300ms linear;
}
.htabs .selected {
	color:#58BAE9;
	border-right:none;
	padding-top:10px!important;
	padding-bottom:10px!important;
}
.heading h1 {

	font-family:'Source Sans Pro', Arial;
	font-weight:500;
	color:#24527d!important;
}
h1 {
	font-family:'Source Sans Pro', Arial;
	font-weight:300!important;
	font-size:24px!important;
	margin-top:0px!important;
	padding-top:0px!important;
	color:#008C8D;
	border-bottom:1px solid #DDDDDD;
}
h2 {
	font-family:'Source Sans Pro', Arial;
	
	font-weight:300!important;
	font-size:24px!important;
	margin-top:0px!important;
	padding-top:4px!important;
	padding-left:10px;
	color:#FFFFFF!important;
	background:#58BAE9!important;
	border-bottom:none!important;
}
h3 {
	font-family:'Source Sans Pro', Arial;
	font-weight:300!important;
	font-size:24px!important;
	margin:0px!important;
	padding:0px!important;
	border-bottom:1px dotted #000;
}
.box > .content {
    border-top: 1px solid #CCCCCC;
	min-height:800px;
}
#tab_colors .form input {
	color:#fff;
	text-shadow:1px 1px 1px #000;
	padding:3px;
	width:50px;
	text-transform:uppercase;
	border:1px solid #ccc;
	margin-left:5px;
	background-image:none!important;
	-moz-box-shadow:inset 0px 0px 1px 0px #777777;
	-webkit-box-shadow:inset 0px 0px 1px 0px #777777;
	box-shadow:inset 0px 0px 1px 0px #777777;

}
.color-buttons {
	background:#f3f3f3;
	padding:10px;
	margin-top:10px;
	text-align:left;
	min-width:780px;
	margin-bottom:20px;
}
.color-buttons input,.color-buttons select {
	padding:4px;
}
.color-buttons a  {
	
	background:#6CBE42;
	
	display:inline-block;

	padding:5px;
	color: #fff;
	text-decoration:none;
	
	padding-left:15px;
	padding-right:15px;
	
	-webkit-transition: background-color 200ms linear;
	-moz-transition: background-color 200ms linear;
	-o-transition: background-color 200ms linear;
	-ms-transition: background-color 200ms linear;
	transition: background-color 200ms linear;
	
}

.color-buttons a:last-child {
	
	background:#F5253E;
}
.color-buttons a:hover {
	background:#58BAE9;
	color:#fff;
	
	-webkit-transition: background-color 300ms linear;
	-moz-transition: background-color 300ms linear;
	-o-transition: background-color 300ms linear;
	-ms-transition: background-color 300ms linear;
	transition: background-color 300ms linear;
}
.save-buttons {
	float:right;
}
.save-buttons a {
	background:#F5253E;
	
	display:inline-block;
	padding:10px;
	
	
	
	color: #fff;
	text-decoration:none;
	
	-webkit-transition: background-color 200ms linear;
	-moz-transition: background-color 200ms linear;
	-o-transition: background-color 200ms linear;
	-ms-transition: background-color 200ms linear;
	transition: background-color 200ms linear;
}
.save-buttons a:first-child {
	background:#6CBE42;
}
#exportColors {
	margin-left:10px;
}
.save-buttons a:hover {
	background:#E27043;
	
	-webkit-transition: background-color 300ms linear;
	-moz-transition: background-color 300ms linear;
	-o-transition: background-color 300ms linear;
	-ms-transition: background-color 300ms linear;
	transition: background-color 300ms linear;
}
#select-patern-image {
	margin-left:10px;
	margin-top:-10px;
}
.notification {
    background: #EAF7D9;
  
    font-size:16px;
    padding:7px;
    text-align:center;
    color:#185b0f;
}

</style>

<script type="text/javascript"><!--

$(document).ready(function() {
      
   var options = {
	  success: function() {
	        //alert('Theme settings saved!');
		
		$(".notification").slideDown().delay(2000).slideUp();
		
		
	  }
	};
   $("#form").ajaxForm(options);
   
   
   var themesData = new Array();
   
   function getThemeList()
   {
	$("#import_scheme_name").html('');	
	
	// Get color themes
	$.get('../catalog/view/theme/metroshop/js/admin_ajax.php?act=import_colors', function(data) {
	
	var schemesList = data.split("^");
	
	for(i=0;i<schemesList.length-1;i++)
	{
		var colorList = schemesList[i].split(',');
		
		var themeid = i;
		
		// Make theme list
		var valueList = colorList[1].split(':');
		var o = new Option(valueList[1], themeid);
		$("#import_scheme_name").append(o);
		
		// Store theme data in array
		themesData.push(schemesList[i]);
		
	}
	
	$.uniform.update();
	
   });
   }
   
   function updateColorBg()
   {
	$.each($('#tab_colors input'), function() {
		$(this).css('background-color', '#'+$(this).val());
	     });
   }
   
  getThemeList();
   
  updateColorBg();


  $("#deleteColors").click(function(){
	
	$.get('../catalog/view/theme/metroshop/js/admin_ajax.php?act=delete_colors&themeid='+$("#import_scheme_name").val(), function(data) {
		alert(data);
		getThemeList();
		
	      });
  });

  $("#importColors").click(function(){
	
	var loadthemeid = ($("#import_scheme_name").val());
	
	var themeData = themesData[loadthemeid];
	
	var colorList = themeData.split(',');
	
	for(j=2;j<colorList.length-1;j++)
	{
		var valueList = colorList[j].split(':');

		$('[name='+valueList[0]+']').val(valueList[1]);
	}
	
	updateColorBg();
	
  });
  
  $("#exportColors").click(function(){
	
	var expData = '';
	
	$.each($('#tab_colors input'), function() {
		expData = expData + $(this).attr("name")+':'+$(this).val()+',';

        });
	expData = 'color_scheme_name:' + $('#color_scheme_name').val() + ',' + expData + '^';
	//alert(expData);
	
	$.get('../catalog/view/theme/metroshop/js/admin_ajax.php?act=export_colors&data='+expData, function(data) {
		alert(data);
		getThemeList();
		
	      });
  });
  
  // from footer JS
	
	function strpos (haystack, needle, offset) {
		var i = (haystack+'').indexOf(needle, (offset || 0));
		return i === -1 ? false : i;
	      }
	      
	if($("#select-patern").val()!='no_pattern')
	{
		$('#select-patern-image').attr("src","../catalog/view/theme/metroshop/image/bg/"+$("#select-patern").val()+".png");
	}
	
	$('#select-patern').change(function(){
		
		if($("#select-patern").val()!='no_pattern') {
			$('#select-patern-image').attr("src","../catalog/view/theme/metroshop/image/bg/"+$(this).val()+".png");
		}
		else
		{
			$('#select-patern-image').attr("src","../catalog/view/theme/metroshop/image/bg/none.png");
		}
		
	});
		
	var activeFont = 0;
	
	$('.font-family-select').change(function(){
		
		activeFont = 1;
		
		getWeightList();
		getSubsetsList();
		
		
		$('head #googlefont').remove();
		var link = "<link href='http://fonts.googleapis.com/css?family="+$(this).val()+":"+weightString+"&subset="+subsetsString+"' id='googlefont' rel='stylesheet' type='text/css'>";
		$('head').append(link);
		
		var fontname = 	$(this).val().replace(/\+/g," ");
		
		$('.font-preview').css("font-family",'"'+fontname+'"');
		$('.font-preview').css("font-style","normal");
		$('.font-preview').css("font-weight",$("#metroshop_header_font_weight").val());
		
		
	});
	
	$('.font-family-select2').change(function(){
		
		activeFont = 2;
		
		getWeightList();
		getSubsetsList();
		
		/*
		$('head #googlefont2').remove();
		var link = "<link href='http://fonts.googleapis.com/css?family="+$(this).val()+":"+weightString+"&subset="+subsetsString+"' id='googlefont2' rel='stylesheet' type='text/css'>";
		$('head').append(link);
		*/
		var fontname = 	$(this).val().replace(/\+/g," ");
		
		$('.font-preview').css("font-family",'"'+fontname+'"');
		$('.font-preview').css("font-style","normal");
		$('.font-preview').css("font-weight",$("#metroshop_buttons_font_weight").val());
		
	});
	
	$('.font-weight-select').change(function(){
		
		activeFont = 1;
		
		var weight = $("#metroshop_header_font_weight").val().replace(/\italic/g,"");
		
		$('.font-preview').css("font-weight",weight);
		
		if(weight.length < $("#metroshop_header_font_weight").val().length)
		{
			$('.font-preview').css("font-style","italic");
		}
		else
		{
			$('.font-preview').css("font-style","normal");
		}
		
		$('.font-preview').css("font-family",'"'+$("#metroshop_header_font").val()+'"');
		
		if($("#metroshop_header_font_weight").val()=='regular')
		{
			$('.font-preview').css("font-weight","normal");			
		}
	});
	
	$('.font-weight-select2').change(function(){
		
		activeFont = 2;
		
		var weight = $("#metroshop_buttons_font_weight").val().replace(/\italic/g,"");
		
		$('.font-preview').css("font-weight",weight);
		
		if(weight.length < $("#metroshop_buttons_font_weight").val().length)
		{
			$('.font-preview').css("font-style","italic");
		}
		else
		{
			$('.font-preview').css("font-style","normal");
		}
		$('.font-preview').css("font-family",'"'+$("#metroshop_buttons_font").val()+'"');
		
		if($("#metroshop_buttons_font_weight").val()=='regular')
		{
			$('.font-preview').css("font-weight","normal");			
		}
		
	});
	
	$('.size-select').change(function(){
			
			$('.font-preview').css("font-size",$(this).val()+'px');
		
	});
	
	$('#tab_colors .form input:not([type="radio"])').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$.each($('#tab_colors input:not([type="radio"])'), function() {
				$(this).css('background-color', '#'+$(this).val());
			     });
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});

<?php
if (!isset($metroshop_header_font)) {
                	
            	$metroshop_header_font = 'Source Sans Pro';
}
if (!isset($metroshop_buttons_font)) {
                	
            	$metroshop_buttons_font = 'Source Sans Pro';
}
if (!isset($metroshop_header_font_weight)) {
                	
            	$metroshop_header_font_weight = '300';
}
if (!isset($metroshop_buttons_font_weight)) {
                	
            	$metroshop_buttons_font_weight = 'regular';
}
if (!isset($metroshop_header_font_subset)) {
                	
            	$metroshop_header_font_subset = 'latin';
}
if (!isset($metroshop_buttons_font_subset)) {
                	
            	$metroshop_buttons_font_subset = 'latin';
}
?>
  
	
  function getFontsList()
  {
	$("#metroshop_header_font").html('');	
	$("#metroshop_header_font_weight").html('');
	$("#metroshop_header_font_subset").html('');
	
	$("#metroshop_buttons_font").html('');	
	$("#metroshop_buttons_font_weight").html('');
	$("#metroshop_buttons_font_subset").html('');
	
	// Get color themes
	$.get('../catalog/view/theme/metroshop/js/admin_ajax.php?act=get_fonts', function(data) {
	
	var fontsList = data.split("\n");
	

	for(i=0;i<fontsList.length-1;i++)
	{
		var familyList = fontsList[i].split(':');
		
		var o = new Option(familyList[0], familyList[0]);
		$("#metroshop_header_font").append(o);
	
	}
	
	$("#metroshop_buttons_font").html("<option selected value=\"<?=$metroshop_buttons_font?>\"><?=str_replace("+"," ",$metroshop_buttons_font)?></option>"+$("#metroshop_header_font").html());
	
	$("#metroshop_header_font").prepend("<option selected value=\"<?=$metroshop_header_font?>\"><?=str_replace("+"," ",$metroshop_header_font)?></option>");
	
	$.uniform.update(); 
   });
  }
  
  var weightString = "";
  var weightString2 = "";
  
  function getWeightList()
  {
	// Get color themes
	$.get('../catalog/view/theme/metroshop/js/admin_ajax.php?act=get_fonts', function(data)
	{
	
		var fontsList = data.split("\n");
		
		for(i=0;i<fontsList.length-1;i++)
		{
			var familyList = fontsList[i].split(':');
			if((activeFont == 0)||(activeFont == 1))
			if(familyList[0]==$("#metroshop_header_font").val())
			{
				var weightList = familyList[1].split(',');
				
				weightString = "";
				
				$("#metroshop_header_font_weight").html('');
				
				for(j=0;j<weightList.length;j++)
				{
					
					var q = new Option(weightList[j], weightList[j]);
					$("#metroshop_header_font_weight").append(q);
					
					if(j==(weightList.length-1))
					{
						weightString = weightString + weightList[j];
						
						$('head #googlefont').remove();
						var link = "<link href='http://fonts.googleapis.com/css?family="+$("#metroshop_header_font").val()+":"+weightString+"&subset="+subsetsString+"' id='googlefont' rel='stylesheet' type='text/css'>";
						$('head').append(link);
					}
					else
					{
						weightString = weightString + weightList[j]+',';
						
					}
					
				}
				
				
			}
			
			// buttons font
			if((activeFont == 0)||(activeFont == 2))
			if(familyList[0]==$("#metroshop_buttons_font").val())
			{
				var weightList = familyList[1].split(',');
				
				weightString2 = "";
				
				$("#metroshop_buttons_font_weight").html('');
				
				for(j=0;j<weightList.length;j++)
				{
					
					var q = new Option(weightList[j], weightList[j]);
					$("#metroshop_buttons_font_weight").append(q);
					
					if(j==(weightList.length-1))
					{
						weightString2 = weightString2 + weightList[j];
						
						$('head #googlefont2').remove();
						var link = "<link href='http://fonts.googleapis.com/css?family="+$("#metroshop_buttons_font").val()+":"+weightString2+"&subset="+subsetsString2+"' id='googlefont2' rel='stylesheet' type='text/css'>";
						$('head').append(link);
					}
					else
					{
						weightString2 = weightString2 + weightList[j]+',';
						
					}
					
				}
				
				
			}
			
		}
	
		if(activeFont == 0)
		{
			$("#metroshop_header_font_weight").prepend("<option selected value=\"<?=$metroshop_header_font_weight?>\"><?=$metroshop_header_font_weight?></option>");
			$("#metroshop_buttons_font_weight").prepend("<option selected value=\"<?=$metroshop_buttons_font_weight?>\"><?=$metroshop_buttons_font_weight?></option>");
		}
	
		$.uniform.update();
		
	});
  
  }
  
  var subsetsString = "";
  var subsetsString2 = "";
  
  function getSubsetsList()
  {
	// Get color themes
	$.get('../catalog/view/theme/metroshop/js/admin_ajax.php?act=get_fonts', function(data)
	{
	
		var fontsList = data.split("\n");
		
		
		for(i=0;i<fontsList.length-1;i++)
		{
			var familyList = fontsList[i].split(':');
			if((activeFont == 0)||(activeFont == 1))
			if(familyList[0]==$("#metroshop_header_font").val())
			{
				var subsetsList = familyList[2].split(',');
				
				subsetsString = "";
				
				$("#metroshop_header_font_subset").html('');
				for(j=0;j<subsetsList.length;j++)
				{
					
					var q = new Option(subsetsList[j], subsetsList[j]);
					$("#metroshop_header_font_subset").append(q);
					
					if(j==(subsetsList.length-1))
					{
						subsetsString = subsetsString + subsetsList[j];
					}
					else
					{
						subsetsString = subsetsString + subsetsList[j]+',';
					}
				}
				
				
			}
			// buttons font
			if((activeFont == 0)||(activeFont == 2))
			if(familyList[0]==$("#metroshop_buttons_font").val())
			{
				var subsetsList = familyList[2].split(',');
				
				subsetsString2 = "";
				
				$("#metroshop_buttons_font_subset").html('');
				for(j=0;j<subsetsList.length;j++)
				{
					
					var q = new Option(subsetsList[j], subsetsList[j]);
					$("#metroshop_buttons_font_subset").append(q);
					
					if(j==(subsetsList.length-1))
					{
						subsetsString2 = subsetsString2 + subsetsList[j];
					}
					else
					{
						subsetsString2 = subsetsString2 + subsetsList[j]+',';
					}
				}
				
				
			}
				
		}
	
		if(activeFont == 0)
		{
			$("#metroshop_header_font_subset").prepend("<option selected value=\"<?=$metroshop_header_font_subset?>\"><?=$metroshop_header_font_subset?></option>");
			$("#metroshop_buttons_font_subset").prepend("<option selected value=\"<?=$metroshop_buttons_font_subset?>\"><?=$metroshop_buttons_font_subset?></option>");
		}

		$.uniform.update(); 
	});
  }
  
  // Init fonts
  getFontsList();
  getWeightList();
  getSubsetsList();
  
  
  // show default preview
  $('.font-preview').css("font-family","<?=$metroshop_header_font?>");
  $('.font-preview').css("font-style","<? if(strpos($metroshop_header_font_weight, "italic")) { echo 'italic'; } else { echo 'normal'; }?>");
  $('.font-preview').css("font-weight","<?=$metroshop_header_font_weight?>");

  /*$("#metroshop_header_font").html('');	
  $("#metroshop_header_font_weight").html('');
  $("#metroshop_header_font_subset").html('');
  */
  $('#tab_colors input:text').focus(
   
    function(){ 
        $(this).css('background-color', '#'+$(this).val());
    });

    $('#tab_colors input:text').blur(
    function(){
        $(this).css('background-color', '#'+$(this).val());
    });
    
    $("input:not(.colorpicker input), textarea, button, select").uniform();
});

--></script>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>


       <?php 
        
        // set default values if no values were entered
       
        if(empty($metroshop_color_body_bg)) { $metroshop_color_body_bg ="F7F7F9"; }
        if(empty($metroshop_color_content_bg)) { $metroshop_color_content_bg ="FFFFFF"; }
	if(empty($metroshop_color_searchblock_bg)) { $metroshop_color_searchblock_bg ="6CBE42"; }
		
	if(empty($metroshop_color_link)) { $metroshop_color_link ="00619E"; }
	if(empty($metroshop_color_linkhover)) { $metroshop_color_linkhover ="f5253e"; }
	if(empty($metroshop_color_text)) { $metroshop_color_text ="151617"; }
	if(empty($metroshop_color_header_text)) { $metroshop_color_header_text ="252727"; }
	
	if(empty($metroshop_color_headermenu_link)) { $metroshop_color_headermenu_link ="FFFFFF"; }
	if(empty($metroshop_color_headermenu_logo)) { $metroshop_color_headermenu_logo ="008C8D"; }
	if(empty($metroshop_color_headermenu_button1)) { $metroshop_color_headermenu_button1 ="FFAA31"; }
	if(empty($metroshop_color_headermenu_button2)) { $metroshop_color_headermenu_button2 ="6CBE42"; }
	if(empty($metroshop_color_headermenu_buttoncart)) { $metroshop_color_headermenu_buttoncart ="58BAE9"; }
	
	if(empty($metroshop_color_displaybg)) { $metroshop_color_displaybg ="E2E3E1"; }
	
	if(empty($metroshop_color_productbg)) { $metroshop_color_productbg ="414E5B"; }
	if(empty($metroshop_color_hover_productbg)) { $metroshop_color_hover_productbg ="008c8d"; }
	if(empty($metroshop_color_product_link)) { $metroshop_color_product_link ="FFFFFF"; }
	if(empty($metroshop_color_product_descr)) { $metroshop_color_product_descr ="B2B2B9"; }
	if(empty($metroshop_color_product_descr_border)) { $metroshop_color_product_descr_border ="4F5E6D"; }
			
	if(empty($metroshop_color_price)) { $metroshop_color_price ="FFAA31"; }
	if(empty($metroshop_color_priceold)) { $metroshop_color_priceold ="AEAAA9"; }
	if(empty($metroshop_color_buttonbg)) { $metroshop_color_buttonbg ="6CBE42"; }
	if(empty($metroshop_color_wlbuttonbg)) { $metroshop_color_wlbuttonbg ="F5253E"; }
	if(empty($metroshop_color_cmpbuttonbg)) { $metroshop_color_cmpbuttonbg ="E27043"; }
	if(empty($metroshop_color_buttonhoverbg)) { $metroshop_color_buttonhoverbg ="58BAE9"; }
	
	if(empty($metroshop_color_buttonlink)) { $metroshop_color_buttonlink ="FFFFFF"; }
	if(empty($metroshop_color_navbuttonbg)) { $metroshop_color_navbuttonbg ="18191D"; }
	
	if(empty($metroshop_color_topmenu_link)) { $metroshop_color_topmenu_link ="4B4747"; }
	if(empty($metroshop_color_topmenu_hover_link)) { $metroshop_color_topmenu_hover_link ="FFFFFF"; }
	if(empty($metroshop_color_topmenu_hover_bg)) { $metroshop_color_topmenu_hover_bg ="008C8D"; }
	if(empty($metroshop_color_topmenu_separator)) { $metroshop_color_topmenu_separator ="E0E0E4"; }
	if(empty($metroshop_color_topmenu_submenu_bg)) { $metroshop_color_topmenu_submenu_bg ="FFFFFF"; }
	if(empty($metroshop_color_topmenu_submenu_hover_bg)) { $metroshop_color_topmenu_submenu_hover_bg ="58BAE9"; }
	if(empty($metroshop_color_topmenu_submenu_hover_link)) { $metroshop_color_topmenu_submenu_hover_link ="FFFFFF"; }
	
	if(empty($metroshop_color_tableheader_bg)) { $metroshop_color_tableheader_bg ="58BAE9"; }
	if(empty($metroshop_color_tableheader_text)) { $metroshop_color_tableheader_text ="FFFFFF"; }
	
	if(empty($metroshop_color_border)) { $metroshop_color_border ="E6E6E9"; }
	if(empty($metroshop_color_aboutheader)) { $metroshop_color_aboutheader ="61ABE7"; }
	if(empty($metroshop_color_aboutbg)) { $metroshop_color_aboutbg ="FFFFFF"; }
	if(empty($metroshop_color_abouttext)) { $metroshop_color_abouttext ="676767"; }
	if(empty($metroshop_color_footerbg)) { $metroshop_color_footerbg ="1F2B36"; }
	if(empty($metroshop_color_footerheader)) { $metroshop_color_footerheader ="E27043"; }
	if(empty($metroshop_color_footerlink)) { $metroshop_color_footerlink ="FFFFFF"; }
	if(empty($metroshop_color_footertext)) { $metroshop_color_footertext ="CCCCCC"; }
	if(empty($metroshop_color_formbg)) { $metroshop_color_formbg ="FFFFFF"; }
	
        // BG
        if(empty($metroshop_body_bg_pattern)) {
        	$metroshop_body_bg_pattern ="no_pattern";
        }
        
       
        ?>
<div class="box">

  <div class="content">
	<div class="save-buttons"><a onclick="$('#form').submit();"><?php echo $button_save; ?> theme settings</a><a onclick="location = '<?php echo $cancel; ?>';"><?php echo $button_cancel; ?></a></div><h2>Welcome to MetroShop theme options panel</h2>
	<div class="notification" style="display:none;">Theme settings saved!</div>
	<p>
	
      Changes will be visible <b>only</b> if you select <b>Enabled</b> for "Enable custom theme options" selector. <span style="color:red;">If you enabled theme options first time you <b>must</b> click <b>Save theme settings button!</b></span>
	
  </p>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <div style="color:green;font-weight:bold;">Enable custom theme options? &nbsp;</span><select name="metroshop_status">
              <?php
														if ($metroshop_status) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select></div> 
	    <br>
	    <b>Enable Custom Footer:  &nbsp;</b>
		<select name="customFooter_status">
              <?php
														if ($customFooter_status) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select>
            </br></br>
	    
    <div id="tabs" class="htabs"><a href="#tab_colors"><img src="../catalog/view/theme/metroshop/image/admin/colors.png"> Colors</a><a
	href="#tab_bg"><img src="../catalog/view/theme/metroshop/image/admin/background.png"> Backgrounds</a><a href="#tab_fonts"><img src="../catalog/view/theme/metroshop/image/admin/fonts.png"> Fonts</a><a
	href="#tab_layout"><img src="../catalog/view/theme/metroshop/image/admin/layout.png"> Layout</a>
	<a
	href="#tab_custommenu"><img src="../catalog/view/theme/metroshop/image/admin/menu.png"> Custom Menu</a>
	
	<a
	href="#tab_effects"><img src="../catalog/view/theme/metroshop/image/admin/effects.png"> Effects</a>
    <a href="#tab_about"><img src="../catalog/view/theme/metroshop/image/admin/about.png"> About block</a><a
	href="#tab_contact"><img src="../catalog/view/theme/metroshop/image/admin/contact.png"> Contact info</a><a href="#tab_facebook"><img src="../catalog/view/theme/metroshop/image/admin/facebook.png"> Facebook</a><a
	href="#tab_twitter"><img src="../catalog/view/theme/metroshop/image/admin/twitter.png"> Twitter</a>
	<a
	href="#tab_customcode"><img src="../catalog/view/theme/metroshop/image/admin/code.png"> Custom code</a>
	<a class="theme_support" 
	href="#theme_support"><img src="../catalog/view/theme/metroshop/image/admin/support.png"> Support</a>
    </div>
   <div class="hcontent">
      <div id="tab_colors">
	<h1>Theme colors</h1>
	In this section, you can change theme colors. To change the color of element just <b>click inside text field</b> and use color picker. Choose color and <b>click <img src="../catalog/view/theme/metroshop/image/admin/picker.png" align="absmiddle"/> icon</b> at the bottom right of color picker window to Save color</b>. 
	<p>You can create you own color schemes and save / load it when you want. Dont forget to click <b>Save theme settings</b> button to apply new colors.</p>
	<div class="color-buttons" style="margin-left:0px;"><div style="float:left;margin-left:0px;"><input id="color_scheme_name" class="color_scheme_name" name="color_scheme_name" value="My theme"> 
	</div><a id="exportColors">Save color scheme</a>   <div style="float:right;margin-left:0px;"><select name="import_scheme_name" id="import_scheme_name">
          
             

            </select> <a id="importColors">Load color scheme</a> <a id="deleteColors">Delete selected scheme</a></div></div>
	<div style="clear:both"></div>
      <h3>Main colors</h3>
      <table class="form">
      
        <tr>
          <td>Body background</td>
          <td>#<input id="metroshop_color_body_bg" type="text" name="metroshop_color_body_bg" value="<?php echo $metroshop_color_body_bg ; ?>" ></td>
        </tr>
	<tr>
          <td>Content background</td>
          <td>#<input id="metroshop_color_content_bg" type="text" name="metroshop_color_content_bg" value="<?php echo $metroshop_color_content_bg ; ?>" ></td>
        </tr>
	<tr>
          <td>Body text</td>
          <td>#<input id="metroshop_color_text" type="text" name="metroshop_color_text" value="<?php echo $metroshop_color_text ; ?>" ></td>
        </tr>
	<tr>
          <td>Body links</td>
          <td>#<input id="metroshop_color_link" type="text" name="metroshop_color_link" value="<?php echo $metroshop_color_link ; ?>" ></td>
        </tr>
	<tr>
          <td>Body links hover</td>
          <td>#<input id="metroshop_color_linkhover" type="text" name="metroshop_color_linkhover" value="<?php echo $metroshop_color_linkhover ; ?>" ></td>
        </tr>
	<tr>
          <td>Headers text</td>
          <td>#<input id="metroshop_color_header_text" type="text" name="metroshop_color_header_text" value="<?php echo $metroshop_color_header_text ; ?>" ></td>
        </tr>
	
	<!-- search block -->
	<tr>
          <td>Search block background</td>
          <td>#<input id="metroshop_color_searchblock_bg" type="text" name="metroshop_color_searchblock_bg" value="<?php echo $metroshop_color_searchblock_bg ; ?>" ></td>
        </tr>
	<tr>
          <td>Category "Filter" block background</td>
          <td>#<input id="metroshop_color_displaybg" type="text" name="metroshop_color_displaybg" value="<?php echo $metroshop_color_displaybg ; ?>" ></td>
        </tr>
	
	<tr>
          <td>Button background</td>
          <td>#<input id="metroshop_color_buttonbg" type="text" name="metroshop_color_buttonbg" value="<?php echo $metroshop_color_buttonbg ; ?>" ></td>
        </tr>
	

	<tr>
          <td>Button hover background</td>
          <td>#<input id="metroshop_color_buttonhoverbg" type="text" name="metroshop_color_buttonhoverbg" value="<?php echo $metroshop_color_buttonhoverbg ; ?>" > (also used for search button hover background)</td>
        </tr>
	<tr>
          <td>Navigation button background</td>
          <td>#<input id="metroshop_color_navbuttonbg" type="text" name="metroshop_color_navbuttonbg" value="<?php echo $metroshop_color_navbuttonbg ; ?>" > (also used for search button background)</td>
        </tr>	
	<tr>
          <td>Button link color</td>
          <td>#<input id="metroshop_color_buttonlink" type="text" name="metroshop_color_buttonlink" value="<?php echo $metroshop_color_buttonlink ; ?>" ></td>
        </tr>
	
	<tr>
          <td>Borders color</td>
          <td>#<input id="metroshop_color_border" type="text" name="metroshop_color_border" value="<?php echo $metroshop_color_border ; ?>" ></td>
        </tr>
	<tr>
          <td>Form elements background</td>
          <td>#<input id="metroshop_color_formbg" type="text" name="metroshop_color_formbg" value="<?php echo $metroshop_color_formbg ; ?>" ></td>
        </tr>
	<tr>
          <td>Table headers background</td>
          <td>#<input id="metroshop_color_tableheader_bg" type="text" name="metroshop_color_tableheader_bg" value="<?php echo $metroshop_color_tableheader_bg ; ?>" ></td>
        </tr>
	<tr>
          <td>Table headers text</td>
          <td>#<input id="metroshop_color_tableheader_text" type="text" name="metroshop_color_tableheader_text" value="<?php echo $metroshop_color_tableheader_text ; ?>" ></td>
        </tr>

      </table>
	
	
      <h3>Header menu colors</h3>
      <table class="form">
	<!-- header menu -->
	<tr>
          <td>Header menu links</td>
          <td>#<input id="metroshop_color_headermenu_link" type="text" name="metroshop_color_headermenu_link" value="<?php echo $metroshop_color_headermenu_link ; ?>" ></td>
        </tr>
	<tr>
          <td>Header menu logo</td>
          <td>#<input id="metroshop_color_headermenu_logo" type="text" name="metroshop_color_headermenu_logo" value="<?php echo $metroshop_color_headermenu_logo ; ?>" > (also used for tabs)</td>
        </tr>
	<tr>
          <td>Header menu odd button</td>
          <td>#<input id="metroshop_color_headermenu_button1" type="text" name="metroshop_color_headermenu_button1" value="<?php echo $metroshop_color_headermenu_button1 ; ?>" > (also used for tabs)</td>
        </tr>
	<tr>
          <td>Header menu even button</td>
          <td>#<input id="metroshop_color_headermenu_button2" type="text" name="metroshop_color_headermenu_button2" value="<?php echo $metroshop_color_headermenu_button2 ; ?>" > (also used for tabs)</td>
        </tr>
	<tr>
          <td>Header menu cart button</td>
          <td>#<input id="metroshop_color_headermenu_buttoncart" type="text" name="metroshop_color_headermenu_buttoncart" value="<?php echo $metroshop_color_headermenu_buttoncart ; ?>" ></td>
        </tr>
	
      </table>
      <h3>Menu colors</h3>
      <table class="form">
	<!-- top category menu -->
	<tr>
          <td>Top category menu link</td>
          <td>#<input id="metroshop_color_topmenu_link" type="text" name="metroshop_color_topmenu_link" value="<?php echo $metroshop_color_topmenu_link ; ?>" ></td>
        </tr>
	<tr>
          <td>Top category menu hover link</td>
          <td>#<input id="metroshop_color_topmenu_hover_link" type="text" name="metroshop_color_topmenu_hover_link" value="<?php echo $metroshop_color_topmenu_hover_link ; ?>" > (also used for category module link)</td>
        </tr>
	<tr>
          <td>Top category menu hover background</td>
          <td>#<input id="metroshop_color_topmenu_hover_bg" type="text" name="metroshop_color_topmenu_hover_bg" value="<?php echo $metroshop_color_topmenu_hover_bg ; ?>" > (also used for category module background)</td>
        </tr>
	<tr>
          <td>Top category menu separator</td>
          <td>#<input id="metroshop_color_topmenu_separator" type="text" name="metroshop_color_topmenu_separator" value="<?php echo $metroshop_color_topmenu_separator ; ?>" ></td>
        </tr>
	<tr>
          <td>Top category menu submenu background</td>
          <td>#<input id="metroshop_color_topmenu_submenu_bg" type="text" name="metroshop_color_topmenu_submenu_bg" value="<?php echo $metroshop_color_topmenu_submenu_bg ; ?>" ></td>
        </tr>
	<tr>
          <td>Top category menu submenu hover background</td>
          <td>#<input id="metroshop_color_topmenu_submenu_hover_bg" type="text" name="metroshop_color_topmenu_submenu_hover_bg" value="<?php echo $metroshop_color_topmenu_submenu_hover_bg ; ?>" > (also used for category module hover background)</td>
        </tr>
	<tr>
          <td>Top category menu submenu hover link</td>
          <td>#<input id="metroshop_color_topmenu_submenu_hover_link" type="text" name="metroshop_color_topmenu_submenu_hover_link" value="<?php echo $metroshop_color_topmenu_submenu_hover_link ; ?>" ></td>
        </tr>
	
      </table>
      <!-- products -->
	<h3>Products colors</h3>
      <table class="form">
	<tr>
          <td>Product info background</td>
          <td>#<input id="metroshop_color_productbg" type="text" name="metroshop_color_productbg" value="<?php echo $metroshop_color_productbg ; ?>" > (used in grid, list, category info and product display page)</td>
        </tr>
	<tr>
          <td>Product info background hover</td>
          <td>#<input id="metroshop_color_hover_productbg" type="text" name="metroshop_color_hover_productbg" value="<?php echo $metroshop_color_hover_productbg ; ?>" > (used in grid)</td>
        </tr>
	<tr>
          <td>Product info text and link</td>
          <td>#<input id="metroshop_color_product_link" type="text" name="metroshop_color_product_link" value="<?php echo $metroshop_color_product_link ; ?>" > (also used for category info)</td>
        </tr>
	<tr>
          <td>Product info page description text</td>
          <td>#<input id="metroshop_color_product_descr" type="text" name="metroshop_color_product_descr" value="<?php echo $metroshop_color_product_descr ; ?>" ></td>
        </tr>
	<tr>
          <td>Product info page description borders</td>
          <td>#<input id="metroshop_color_product_descr_border" type="text" name="metroshop_color_product_descr_border" value="<?php echo $metroshop_color_product_descr_border ; ?>" ></td>
        </tr>
	<!-- price and buttons -->
	<tr>
          <td>Price color</td>
          <td>#<input id="metroshop_color_price" type="text" name="metroshop_color_price" value="<?php echo $metroshop_color_price ; ?>" ></td>
        </tr>
	<tr>
          <td>Old Price color</td>
          <td>#<input id="metroshop_color_priceold" type="text" name="metroshop_color_priceold" value="<?php echo $metroshop_color_priceold ; ?>" ></td>
        </tr>
		<tr>
          <td>Wishlist button background</td>
          <td>#<input id="metroshop_color_wlbuttonbg" type="text" name="metroshop_color_wlbuttonbg" value="<?php echo $metroshop_color_wlbuttonbg ; ?>" ></td>
        </tr>
	<tr>
          <td>Compare button background</td>
          <td>#<input id="metroshop_color_cmpbuttonbg" type="text" name="metroshop_color_cmpbuttonbg" value="<?php echo $metroshop_color_cmpbuttonbg ; ?>" ></td>
        </tr>
	</table>
      <h3>Footer colors</h3>
      <table class="form">
	 <tr>   
           <td>Invert icons images: <br>(for dark backgrounds)</br>
                      
                    </td>
              <td>
		
		  <?php 
           if(isset($metroshop_invert_images) && $metroshop_invert_images == '1'){
           	 ?>
           	 <input type="radio"  name="metroshop_invert_images" value="1" CHECKED/> Yes<br />
			<input type="radio" name="metroshop_invert_images" value="0"> No
           	<?php 
           }     else {   ?>
           <input type="radio"  name="metroshop_invert_images" value="1" /> Yes<br />
			<input type="radio" name="metroshop_invert_images" value="0" CHECKED> No
         <?php   } ?>
	 
			
              </td>         
          </td>
        </tr>
	<tr>
          <td>Footer about block background</td>
          <td>#<input id="metroshop_color_aboutbg" type="text" name="metroshop_color_aboutbg" value="<?php echo $metroshop_color_aboutbg ; ?>" ></td>
        </tr>
	<tr>
          <td>Footer about block headers color</td>
          <td>#<input id="metroshop_color_aboutheader" type="text" name="metroshop_color_aboutheader" value="<?php echo $metroshop_color_aboutheader ; ?>" ></td>
        </tr>
	<tr>
          <td>Footer about block text</td>
          <td>#<input id="metroshop_color_abouttext" type="text" name="metroshop_color_abouttext" value="<?php echo $metroshop_color_abouttext ; ?>" ></td>
        </tr>
	<tr>
          <td>Footer background color</td>
          <td>#<input id="metroshop_color_footerbg" type="text" name="metroshop_color_footerbg" value="<?php echo $metroshop_color_footerbg ; ?>" ></td>
        </tr>
	<tr>
          <td>Footer headers color</td>
          <td>#<input id="metroshop_color_footerheader" type="text" name="metroshop_color_footerheader" value="<?php echo $metroshop_color_footerheader ; ?>" ></td>
        </tr>
	<tr>
          <td>Footer links color</td>
          <td>#<input id="metroshop_color_footerlink" type="text" name="metroshop_color_footerlink" value="<?php echo $metroshop_color_footerlink ; ?>" ></td>
        </tr>
	<tr>
          <td>Footer text color</td>
          <td>#<input id="metroshop_color_footertext" type="text" name="metroshop_color_footertext" value="<?php echo $metroshop_color_footertext ; ?>" ></td>
        </tr>
	
      </table>
      </div>
      <!-- end colors tab -->
      <div id="tab_bg">
	<h1>Theme backgrounds</h1>
      <table class="form">
              
        
        
            <tr>
          <td>Background pattern:
             : <?php if (!isset($metroshop_body_bg_pattern)) {
                	
		 $metroshop_body_bg_pattern = 'no_pattern';
            }
          
           
            ?>
          
          
          </td>
          <td>
          <select name="metroshop_body_bg_pattern" id="select-patern">
          
              <option value="<?=$metroshop_body_bg_pattern?>"selected="selected"><?=$metroshop_body_bg_pattern?></option>
	      <option value="no_pattern">No Pattern</option>

<?php 

for ($i = 1; $i <= 40; $i++) {
	
	echo '<option value="'. $i . '">' . $i .'</option>';
}
?>
            </select> <img align="absmiddle" src="../catalog/view/theme/metroshop/image/bg/none.png" id="select-patern-image"> 
            </td>  
            </tr> 
            <tr>   
           <td>Upload your own background pattern: </br>
           <?php 
           if(isset($dxmetroshop_bg_image) && $dxmetroshop_bg_image == '1'){
           	 ?>
           	 <input type="radio"  name="dxmetroshop_bg_image" value="1" CHECKED/> Yes<br />
			<input type="radio" name="dxmetroshop_bg_image" value="0"> No
           	<?php 
           }     else {   ?>
           <input type="radio"  name="dxmetroshop_bg_image" value="1" /> Yes<br />
			<input type="radio" name="dxmetroshop_bg_image" value="0" CHECKED> No
         <?php   } ?>
           </td>
              <td>
             
              <input type="hidden" name="dxmetroshop_image" value="<?php echo $dxmetroshop_image; ?>" id="dxmetroshop_image" />
                <img src="<?php echo $metroshop_preview; ?>" alt="" id="metroshop_preview" class="image" onclick="image_upload('dxmetroshop_image', 'metroshop_preview');" /></td>         
          </td>
        </tr>
        
              <tr>   
           <td>Upload your image as full size background: </br>
           <?php 
           if(isset($dxmetroshop_full_bg_image) && $dxmetroshop_full_bg_image == '1'){
           	 ?>
           	 <input type="radio"  name="dxmetroshop_full_bg_image" value="1" CHECKED/> Yes<br />
			<input type="radio" name="dxmetroshop_full_bg_image" value="0"> No
           	<?php 
           }     else {   ?>
           <input type="radio"  name="dxmetroshop_full_bg_image" value="1" /> Yes<br />
			<input type="radio" name="dxmetroshop_full_bg_image" value="0" CHECKED> No
         <?php   } ?>
           </td>
              <td>
             
              <input type="hidden" name="dxmetroshop_full_image" value="<?php echo $dxmetroshop_full_image; ?>" id="dxmetroshop_full_image" />
                <img src="<?php echo $metroshop_full_preview; ?>" alt="" id="metroshop_full_preview" class="image" onclick="image_upload('dxmetroshop_full_image', 'metroshop_full_preview');" /></td>         
          </td>
        </tr>
        <!--
        <tr>
        <td>
        Partially transparent content background:
        
        </td>
        
       <td>
        <?php 
           if(isset($metroshop_transparent_content) && $metroshop_transparent_content == '1'){
           	 ?>
           	 <input type="radio"  name="metroshop_transparent_content" value="1" CHECKED/> Yes<br />
			<input type="radio" name="metroshop_transparent_content" value="0"> No
           	<?php 
           }     else {   ?>
           <input type="radio"  name="metroshop_transparent_content" value="1" /> Yes<br />
			<input type="radio" name="metroshop_transparent_content" value="0" CHECKED> No
         <?php   } ?>
        </td>
        
        </tr>
	      -->
      </table>
      </div>
        <!-- end tab bg -->
	
       <div id="tab_fonts">
	<h1>Theme fonts</h1>
	
	<table class="form">
		<tr><td>Font preview:</td>
		<td><span class="font-preview">Grumpy wizards make toxic brew for the evil Queen and Jack.</span></td>
		</tr>
                <tr>
          <td>Body font:</td>
          <td>
          <select name="metroshop_body_font">

              <?php if (isset($metroshop_body_font)) {
              $selected = "selected";
              ?>
	      <option value="Source Sans Pro" <?php if($metroshop_body_font=='Source Sans Pro'){echo $selected;} ?>>Source Sans Pro</option>
	      <option value="Myriad Pro" <?php if($metroshop_body_font=='Myriad Pro'){echo $selected;} ?>>Myriad Pro</option>
              <option value="Arial" <?php if($metroshop_body_font=='Arial'){echo $selected;} ?>>Arial</option>
              <option value="Verdana" <?php if($metroshop_body_font=='Verdana'){echo $selected;} ?>>Verdana</option>
              <option value="Helvetica" <?php if($metroshop_body_font=='Helvetica'){echo $selected;} ?>>Helvetica</option>
              
              <option value="Lucida Grande" <?php if($metroshop_body_font=='Lucida Grande'){echo $selected;} ?>>Lucida Grande</option>
              <option value="Trebuchet MS" <?php if($metroshop_body_font=='Trebuchet MS'){echo $selected;} ?>>Trebuchet MS</option>
              <option value="Times New Roman" <?php if($metroshop_body_font=='Times New Roman'){echo $selected;} ?>>Times New Roman</option>
              <option value="Tahoma" <?php if($metroshop_body_font=='Tahoma'){echo $selected;} ?>>Tahoma</option>
              <option value="Georgia" <?php if($metroshop_body_font=='Georgia'){echo $selected;} ?>>Georgia</option>
                           
              <?php } else { ?>
	      <option value="Source Sans Pro" selected="selected">Source Sans Pro</option>
	      <option value="Myriad Pro">Myriad Pro</option>
              <option value="Arial">Arial</option>
              <option value="Verdana">Verdana</option>    
           <option value="Helvetica">Helvetica</option>
              <option value="Lucida Grande">Lucida Grande</option>
             <option value="Trebuchet MS">Trebuchet MS</option>
            <option value="Times New Roman">Times New Roman</option>
             <option value="Tahoma">Tahoma</option>
            <option value="Georgia">Georgia</option>
              
              <?php } ?>
            </select>  Default font: Source Sans Pro      
          </td>
        </tr>
				 <tr>
          <td>Body text font size:
              <?php if (!isset($metroshop_body_fontsize)) {
                	
		 $metroshop_body_fontsize = '14';
            }
          
           
            ?>
          
          
          </td>
          <td>
          <select name="metroshop_body_fontsize">
          
              <option value="<?=$metroshop_body_fontsize?>"selected="selected"><?=$metroshop_body_fontsize?></option>

<?php 

for ($i = 10; $i <= 25; $i++) {
	
	echo '<option value="'. $i . '">' . $i .'</option>';
}
?>
            </select>   Default: 14
            </td>  
            </tr>  
		<tr>
          <td>Headers font:
              
          
            <br>Default font: Source Sans Pro 300</b>
          </p>
          
          </td>
          <td>
          <select name="metroshop_header_font" class="font-select font-family-select" id="metroshop_header_font">
 
            </select>
	  &nbsp;Weight: <select name="metroshop_header_font_weight" class="font-select font-weight-select" id="metroshop_header_font_weight"></select> &nbsp;Subset: <select name="metroshop_header_font_subset" class="font-select" id="metroshop_header_font_subset"></select>
	  
          </td>
	  </tr>
		<tr>
          <td>Headers text font size:
         <?php if (!isset($metroshop_header_fontsize)) {
                	
		 $metroshop_header_fontsize = '24';
            }
          
           
            ?>
          
          
          </td>
          <td>
          <select name="metroshop_header_fontsize" class="size-select">
          
              <option value="<?=$metroshop_header_fontsize?>"selected="selected"><?=$metroshop_header_fontsize?></option>

<?php 

for ($i = 17; $i <= 35; $i++) {
	
	echo '<option value="'. $i . '">' . $i .'</option>';
}
?>
            </select> Default: 24 
            </td>  
            </tr>   
		<tr>
	  <td>Headers font transform:</td>
	  <td>
		<select name="metroshop_fonts_transform">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_fonts_transform)) {
		$selected_1 = "selected";
	      }
	      
              ?>
	      <option value="none" <? echo $selected_1; ?> <?php if($metroshop_fonts_transform=='none'){echo 'selected';} ?>>None</option>
              <option value="uppercase" <?php if($metroshop_fonts_transform=='uppercase'){echo 'selected';} ?>>Uppercase letters (Default)</option>
	      <option value="capitalize" <?php if($metroshop_fonts_transform=='capitalize'){echo 'selected';} ?>>Capitalize letters</option>
                 
            </select>        
		
          </td>
        </tr>
		<!--
                  <tr>
          <td>Buttons font:
              
	    <br>Default font: Source Sans Pro regular
          </p>
          
          </td>
          <td>
          <select name="metroshop_buttons_font" class="font-select2 font-family-select2" id="metroshop_buttons_font">
		 
            </select> &nbsp;Weight: <select name="metroshop_buttons_font_weight" class="font-select2 font-weight-select2" id="metroshop_buttons_font_weight"></select> &nbsp;Subset: <select name="metroshop_buttons_font_subset" class="font-select2" id="metroshop_buttons_font_subset"></select>
          </td>
	  </tr>
		 <tr>
          <td>Buttons text font size:
              <?php if (!isset($metroshop_buttons_fontsize)) {
                	
		 $metroshop_buttons_fontsize = '12';
            }
          
           
            ?>
          
          
          </td>
          <td>
          <select name="metroshop_buttons_fontsize" class="size-select">
          
              <option value="<?=$metroshop_buttons_fontsize?>"selected="selected"><?=$metroshop_buttons_fontsize?></option>

<?php 

for ($i = 10; $i <= 25; $i++) {
	
	echo '<option value="'. $i . '">' . $i .'</option>';
}
?>
            </select>   Default: 12
            </td>  
            </tr>   -->
		  <tr>
	  <td>Buttons, top menu and footer headers font transform:</td>
	  <td>
		<select name="metroshop_bfonts_transform">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_bfonts_transform)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="uppercase" <?php echo $selected_1; if($metroshop_bfonts_transform=='uppercase'){echo 'selected';} ?>>Uppercase letters (Default)</option>
	      <option value="capitalize" <?php if($metroshop_bfonts_transform=='capitalize'){echo 'selected';} ?>>Capitalize letters</option>
              <option value="none" <?php if($metroshop_bfonts_transform=='none'){echo 'selected';} ?>>None</option>
                 
            </select>        
		
          </td>
        </tr>
	</table>
       </div>
       <!-- end tab fonts -->
       <div id="tab_layout">
	<h1>Theme layout</h1>
	
	<table class="form">
	<tr>
		<td><b>Responsive layout</b></td>
		<td><select name="metroshop_layout_responsive">
              <?php
														if ($metroshop_layout_responsive) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select></td>
	</tr>
	<tr>
	  <td>Related products display:</td>
	  <td>
		<select name="metroshop_layout_related">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_layout_related)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="tab" <?php echo $selected_1; if($metroshop_layout_related=='tab'){echo 'selected';} ?>>As Tab (default)</option>
              <option value="carousel" <?php if($metroshop_layout_related=='carousel'){echo 'selected';} ?>>As carousel</option>
     
                 
            </select> How will look related products display at the Product details page.   
		
          </td>
        </tr>
	
	
	<tr>
	  <td>Show banners at the slider right:</td>
	  <td>
		<select name="metroshop_layout_rightbaners">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_layout_rightbaners)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="show" <?php echo $selected_1; if($metroshop_layout_rightbaners=='show'){echo 'selected';} ?>>Show (default)</option>
              <option value="hide" <?php if($metroshop_layout_rightbaners=='hide'){echo 'selected';} ?>>Hide</option>
     
                 
            </select> Note: this banners hidden automatically if you use 2 or 3 columns    
		
          </td>
        </tr>
	<!--
	<tr>
	  <td>Show banners at the slider bottom:</td>
	  <td>
		<select name="metroshop_layout_bottombaners">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_layout_bottombaners)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="show" <?php echo $selected_1; if($metroshop_layout_bottombaners=='show'){echo 'selected';} ?>>Show (default)</option>
              <option value="hide" <?php if($metroshop_layout_bottombaners=='hide'){echo 'selected';} ?>>Hide</option>
     
                 
            </select> Note: this banners hidden automatically if you use 2 or 3 columns       
		
          </td>
        </tr>-->
	
	<tr>
	  <td>Default products display type:</td>
	  <td>
		<select name="metroshop_layout_pdisplay">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_layout_pdisplay)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="list" <?php echo $selected_1; if($metroshop_layout_pdisplay=='list'){echo 'selected';} ?>>List (default)</option>
              <option value="grid" <?php if($metroshop_layout_pdisplay=='grid'){echo 'selected';} ?>>Grid</option>
     
                 
            </select>       
		
          </td>
        </tr>    
      </table>
	
      </div>
      <div id="tab_custommenu">
	<h1>Custom top menu</h1>
	<table class="form">
	<tr>
		<td><b>Enable custom top menu:</b></td>
		<td><select name="metroshop_layout_custommenu">
              <?php
														if ($metroshop_layout_custommenu) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select> Will show custom top menu instead of standard OpenCart categories menu</td>
	</tr>
	<tr>
	
		<td>Custom menu item 1:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item1_text" value="<?php echo $metroshop_layout_custommenu_item1_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item1_url" value="<?php echo $metroshop_layout_custommenu_item1_url; ?>"></td></tr>
		<tr><td>Custom menu item 2:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item2_text" value="<?php echo $metroshop_layout_custommenu_item2_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item2_url" value="<?php echo $metroshop_layout_custommenu_item2_url; ?>"></td></tr>
		<tr><td>Custom menu item 3:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item3_text" value="<?php echo $metroshop_layout_custommenu_item3_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item3_url" value="<?php echo $metroshop_layout_custommenu_item3_url; ?>"></td></tr>
		<tr><td>Custom menu item 4:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item4_text" value="<?php echo $metroshop_layout_custommenu_item4_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item4_url" value="<?php echo $metroshop_layout_custommenu_item4_url; ?>"></td></tr>
		<tr><td>Custom menu item 5:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item5_text" value="<?php echo $metroshop_layout_custommenu_item5_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item5_url" value="<?php echo $metroshop_layout_custommenu_item5_url; ?>"></td></tr>
		<tr><td>Custom menu item 6:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item6_text" value="<?php echo $metroshop_layout_custommenu_item6_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item6_url" value="<?php echo $metroshop_layout_custommenu_item6_url; ?>"></td></tr>
		<tr><td>Custom menu item 7:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item7_text" value="<?php echo $metroshop_layout_custommenu_item7_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item7_url" value="<?php echo $metroshop_layout_custommenu_item7_url; ?>"></td></tr>
		<tr><td>Custom menu item 8:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item8_text" value="<?php echo $metroshop_layout_custommenu_item8_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item8_url" value="<?php echo $metroshop_layout_custommenu_item8_url; ?>"></td></tr>
		<tr><td>Custom menu item 9:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item9_text" value="<?php echo $metroshop_layout_custommenu_item9_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item9_url" value="<?php echo $metroshop_layout_custommenu_item9_url; ?>"></td></tr>
		<tr><td>Custom menu item 10:</td><td> Text: <input type="text" name="metroshop_layout_custommenu_item10_text" value="<?php echo $metroshop_layout_custommenu_item10_text; ?>"> URL: <input type="text" name="metroshop_layout_custommenu_item10_url" value="<?php echo $metroshop_layout_custommenu_item10_url; ?>"></td>
		
	</tr>
	</table>
      </div>
      <!-- end tab layout -->
      <div id="tab_customcode">
	<h1>Custom CSS/Javascript code</h1>
	<p><b>Note:</b> this place for advanced users only. If you write wrong code here you can break theme work and design.</p>
	<table class="form">
	<tr>
		<td><b>Custom CSS code:</b></td>
		<td><textarea name="metroshop_custom_css" rows="10" style="width:100%"><?php
		echo trim($metroshop_custom_css);
		?></textarea></td>
	</tr>
	<tr>
		<td><b>Custom JavaScript code:</b></td>
		<td><textarea name="metroshop_custom_js" rows="10" style="width:100%"><?php
		echo trim($metroshop_custom_js);
		?></textarea></td>
	</tr>
	</table>
      </div>
      <!-- end tab code -->
      <div id="tab_effects">
	<h1>Theme effects</h1>
      <table class="form">
	<tr>
	  <td>Carousel for modules:</td>
	  <td>
		<select name="metroshop_effects_carousel">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_effects_carousel)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="enable" <?php echo $selected_1; if($metroshop_effects_carousel=='enable'){echo 'selected';} ?>>Enable (default)</option>
              <option value="disable" <?php if($metroshop_effects_carousel=='disable'){echo 'selected';} ?>>Disable</option>
                 
            </select>        
		
          </td>
        </tr>
	<tr>
	  <td>Slider animation:</td>
	  <td>
		<select name="metroshop_effects_slideranim">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_effects_slideranim)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="fade" <?php echo $selected_1; if($metroshop_effects_slideranim=='fade'){echo 'selected';} ?>>Fade (default)</option>
              <option value="slide" <?php if($metroshop_effects_slideranim=='slide'){echo 'selected';} ?>>Slide</option>
                 
            </select>        
		
          </td>
        </tr>
	<tr>
	  <td>Product image effect:</td>
	  <td>
		<select name="metroshop_effects_productimage">

              <?php
	      $selected_1 = '';
	      if (!isset($metroshop_effects_productimage)) {
		$selected_1 = "selected";
	      }
	      
              ?>
              <option value="zoom" <?php echo $selected_1; if($metroshop_effects_productimage=='zoom'){echo 'selected';} ?>>Mouseover Zoom (default)</option>
              <option value="lightbox" <?php if($metroshop_effects_productimage=='lightbox'){echo 'lightbox';} ?>>Mouseclick Lightbox</option>
                 
            </select>        
		
          </td>
        </tr>
      </table>
      </div>
	<div id="tab_about">
		<h1>Theme about block</h1>
<table class="form">
	<tr>
		<td>Enable About block</td>
		<td><select name="about_status">
              <?php
														if ($about_status) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select></td>
	</tr>
	
	<tr>
		<td>Header text:</td>
		<td><input type="text" name="about_header"
			value="<?php
			echo $about_header;
			?>"></td>
	</tr>

	<tr>
		<td>About text:</td>
		<td><textarea name="about_text" rows="10" cols="50"><?php
		echo trim($about_text);
		?></textarea>
		</td>
	</tr>
	<tr>
 <td>Image: </br>
           <?php 
           if(isset($about_us_image_status) && $about_us_image_status == '1'){
           	 ?>
           	 <input type="radio"  name="about_us_image_status" value="1" CHECKED/> Yes<br />
			<input type="radio" name="about_us_image_status" value="0"> No
           	<?php 
           }     else {   ?>
           <input type="radio"  name="about_us_image_status" value="1" /> Yes<br />
			<input type="radio" name="about_us_image_status" value="0" CHECKED> No
         <?php   } ?>
           </td>
	<td>
             
              <input type="hidden" name="about_us_image" value="<?php echo $about_us_image; ?>" id="about_us_image" />
                <img src="<?php echo $about_us_image_preview; ?>" alt="" id="about_us_image_preview" class="image" onclick="image_upload('about_us_image', 'about_us_image_preview');" /></td>         
          </td>
	
	
	</tr>

</table>
</div>

<div id="tab_contact">
	<h1>Theme contact information</h1>
<table class="form">
	<tr>
		<td>Show phone number in header</td>
		<td><select name="contact_status">
              <?php
														if ($contact_status) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select></td>
	</tr>
	<tr>
		<td>Text under header phone:</td>
		<td><input type="text" name="contact_subheader"
			value="<?php
			if(empty($contact_subheader))
			{
				$contact_subheader = 'Call us Monday - Saturday: 8:30 am - 6:00 pm';
			}
			echo $contact_subheader;
			?>"></td>
	</tr>
	<tr> Fill in contact details you want to be displayed in your custom footer. If you don't want some of contact details to be displayed, just leave these fields empty</tr>
	
		<tr>
		<td>About right header name:</td>
		<td><input type="text" name="contact_header"
			value="<?php
			if(empty($contact_header))
			{
				$contact_header = 'Find us';
			}
			echo $contact_header;
			?>"></td>
	</tr>
	
	
	<tr>
		<td>Phone 1:</td>
		<td><input type="text" name="telephone1"
			value="<?php
			echo $telephone1;
			?>"></td>
	</tr>

	<tr>
		<td>Phone 2:</td>
		<td><input type="text" name="telephone2"
			value="<?php
			echo $telephone2;
			?>"></td>
	</tr>
	
		<tr>
		<td>Fax</td>
		<td><input type="text" name="fax"
			value="<?php
			echo $fax;
			?>"></td>
	</tr>
	
	
	<tr>
		<td>E-mail 1:</td>
		<td><input type="text" name="email1"
			value="<?php
			echo $email1;
			?>"></td>
	</tr>

	<tr>
		<td>E-mail 2:</td>
		<td><input type="text" name="email2"
			value="<?php
			echo $email2;
			?>"></td>
	</tr>
	
	<tr>
		<td>Skype:</td>
		<td><input type="text" name="skype"
			value="<?php
			echo $skype;
			?>"></td>
	</tr>
	

</table>
</div>

<div id="tab_facebook">
	<h1>Facebook Footer Like Box</h1>
<table class="form">
	
	<tr>
		<td>Facebook Column Status</td>
		<td><select name="facebook_status">
              <?php
														if ($facebook_status) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select></td>
	</tr>
	
		<tr>
		<td>Facebook page ID:<br>(Sample ID: 115403961948855)</td>
		<td><input type="text" name="facebook_id"
			value="<?php
			echo $facebook_id;
			?>"> You can get your facebook page ID by page url <a target="_blank" href="http://wallflux.com/facebook_id/">here</a>.</td>
	</tr>
	
	
</table>
</div>

<div id="tab_twitter">
	<h1>Twitter Footer Tweets Box</h1>
<table class="form">
	<tr>
		<td>Twitter Column Status</td>
		<td><select name="twitter_column_status">
              <?php
														if ($twitter_column_status) {
															?>
              <option value="1" selected="selected"><?php
															echo $text_enabled;
															?></option>
			<option value="0"><?php
															echo $text_disabled;
															?></option>
              <?php
														} else {
															?>
              <option value="1"><?php
															echo $text_enabled;
															?></option>
			<option value="0" selected="selected"><?php
															echo $text_disabled;
															?></option>
              <?php
														}
														?>
            </select></td>
	</tr>
	
	<tr>
		<td>Twitter column header name: </td>
		<td><input type="text" name="twitter_column_header"
			value="<?php
			echo $twitter_column_header;
			?>"></td>
	</tr>
	
		<tr>
		<td>
            <label style="width: 110px">Tweets number</label></td><td>
            <select name="twitter_number_of_tweets">
              <option value="1"<?php if($twitter_number_of_tweets == '1') echo ' selected="selected"';?>>1</option>
              <option value="2"<?php if($twitter_number_of_tweets == '2') echo ' selected="selected"';?>>2</option>
              <option value="3"<?php if($twitter_number_of_tweets == '3') echo ' selected="selected"';?>>3</option>
            </select></td>
         </tr>

          <tr><td>
            <label style="width: 110px">Twitter username: </label></td>
            <td><input type="text" name="twitter_username" value="<?php echo $twitter_username; ?>" /></td>
          </tr>
		
		
		
	</tr>
</table>
</div>

<div id="theme_support">
	<h1>MetroShop theme for Open Cart 1.5.5.1 Theme version: <a href="http://metro-oc.any-themes.com/Documentation/release-history.html" target="_blank">1.5</a></h1>
	<p style="font-weight:bold">Theme designed and developed by <a href="http://themeforest.net/user/dedalx">dedalx</a>.</p>
<p>Thank you for buying my theme! If you have any questions or problems with my item you can contact me via <a href="http://themeforest.net/user/dedalx">Theme Forest contact form</a>.</p>
<p>If you like my theme dont forget to rate theme with stars (you can do it in your Downloads tab, inside your ThemeForest profile. Just click on stars! This little thing helps me to make new theme updates! Thank you!</p>
<p>
Now my personal blog available at <a href="http://dedalx.com">dedalx.com</a>!
</p>

<h3><a href="https://twitter.com/dedalx" target="_blank">Follow me on twitter</a> or <a href="https://www.facebook.com/dedalxDev" target="_blank">join my facebook page</a> to get noticed about all theme updates and news!</h3>
<br>
<a href="http://codecanyon.net/user/dedalx/follow/"><img src="http://any-themes.com/images/followcc.png"/></a> <a href="http://codecanyon.net/feeds/users/dedalx"><img src="http://any-themes.com/images/rsscc.png"/></a><br>
<a href="http://themeforest.net/user/dedalx/follow/"><img src="http://any-themes.com/images/followtf.png"/></a> <a href="http://themeforest.net/feeds/users/dedalx"><img src="http://any-themes.com/images/rsstf.png"/></a><br>
<a href="http://graphicriver.net/user/dedalx/follow/"><img src="http://any-themes.com/images/followgr.png"/></a> <a href="http://graphicriver.net/feeds/users/dedalx"><img src="http://any-themes.com/images/rssgr.png"/></a><br>
<a href="https://twitter.com/dedalx"><img src="http://any-themes.com/images/followtwitter.png"/></a> <a href="http://www.facebook.com/dedalxDev"><img src="http://any-themes.com/images/followfb.png"/></a><br>
<a href="http://instagram.com/dedalx"><img src="http://any-themes.com/images/followig.png"/></a>
</div>


   </div>

    </form>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 


<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript" src="view/javascript/jquery/ckeditor.jquery.js"></script> 
<script type="text/javascript"><!--

$('#form').bind('submit', function() {
	var module = new Array(); 

	$('#module tbody').each(function(index, element) {
		module[index] = $(element).attr('id').substr(10);
	});
	
	$('input[name=\'my_module_module\']').attr('value', module.join(','));
});
//--></script>


<script type="text/javascript"><!--
function image_upload(field, preview) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>',
					type: 'GET',
					data: 'image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<?php echo $footer; ?>