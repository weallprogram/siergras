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
            <div class="buttons"><a href="<?php echo $link_add; ?>" class="button"><?php echo $button_add; ?></a></div>
        </div>
        <div class="content">
            <?php if (isset($succes_message) && $succes_message) { ?>
                <div class="success"><?php echo $succes_message; ?></div>
            <?php } ?>
            
            <table class="list">
                <thead>
                    <tr>
                        <td class="left">ID</td>
                        <td class="left">Titel</td>
                        <td class="left">Volgorde</td>
                        <td class="left">Status</td>
                        <td class="left">Bekeken</td>
                        <td class="right">Actie</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($missions as $key => $missie) {
                        echo "<tr>";
                        echo '<td class="left">' . $missie['id'] . '</td>';
                        echo '<td class="left">' . $missie['title'] . '</td>';
                        echo '<td class="left">' . $missie['sort'] . '</td>';
                        echo '<td class="left">' . $missie['status'] . '</td>';
                        echo '<td class="left">' . $missie['visited'] . '</td>';
                        echo '<td class="right">[ <a href="index.php?route=aselsi/aselsi/edit&token=' . $_GET['token'] . '&id=' . $missie['id'] . '"> Bewerken</a> ] &nbsp;[ <a href="index.php?route=aselsi/aselsi/delete&token=' . $_GET['token'] . '&id=' . $missie['id'] . '"> Verwijderen </a> ]</td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<?php echo $footer; ?>
