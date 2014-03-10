<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if (isset($error_warning) && $error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/information.png" alt="" width="22" height="22" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#le_form').submit();" class="button"><?php echo $button_save; ?></a></div>
        </div>
        <div class="content">
            <?php if (isset($succes_message) && $succes_message) { ?>
                <div class="success"><?php echo $succes_message; ?></div>
            <?php } ?>
            
            <form method="post" action="index.php?route=aselsi/aselsi/insert&token=<?php echo $_GET['token']; ?>" id="le_form">
                <table class="form">
                    <tbody>
                        <tr>
                            <td><span class="required">*</span> Titel:<br><span class="help">Titel van de pagina zoals deze wordt weergegeven in de winkel.</span></td>
                            <td><input type="text" name="title" size="100" value=""></td>
                        </tr>
                        <tr>
                            <td><span class="required">*</span> Bericht:<br><span class="help">Inhoud (content) van de pagina zoals deze wordt weergegeven in de winkel.</span></td>
                            <td><textarea name="msg" id="msg" ></textarea></td>
                        </tr>
                        <tr>
                            <td><span class="required">*</span>Volgorde:</td>
                            <td><input type="text" name="sort" size="2" value="0" /> </td>
                        </tr>
                        <tr>
                            <td><span class="required">*</span>Actief:</td>
                            <td><select name="status">
                                <option value="1" selected="selected">Actief</option>
                                <option value="0" >Non-Actief</option>
                            </select></td>
                        </tr>
                    </tbody>
                </table>
            
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script>
    CKEDITOR.replace('msg', {
        filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
        filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
        filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
        filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
        filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
        filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
    });
</script>
<?php echo $footer; ?>
