<?
// BeatyShop ajax

if($_REQUEST['act']=='export_colors')
{
    file_put_contents("../../../../../image/data/ms_theme_colors.bst", $_REQUEST['data'], FILE_APPEND);
    
    echo 'Color scheme saved!';
}
if($_REQUEST['act']=='import_colors')
{
    
    $file = file_get_contents("../../../../../image/data/ms_theme_colors.bst");
    
    echo $file;
}
if($_REQUEST['act']=='delete_colors')
{
    $themeid = $_REQUEST['themeid'];
     
    if($themeid>0)
    {
        
        $file = file_get_contents("../../../../../image/data/ms_theme_colors.bst");
        
        $schemas = explode("^",$file);
        unset($schemas[$themeid]);
        $schemas = implode("^", $schemas);
        
        file_put_contents("../../../../../image/data/ms_theme_colors.bst", $schemas);
        
        echo 'Color scheme deleted!';
    }
    else
    {
        echo 'You can\'t delete default theme!';
    }
}
if($_REQUEST['act']=='get_fonts')
{
    $file = file_get_contents("../../../../../image/data/ms_fonts.data");
    
    echo $file;
}
?>