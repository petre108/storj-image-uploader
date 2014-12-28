<?php
error_reporting(0);

?><!DOCTYPE html>
<head>
<meta charset="utf-8">
		<title>Storj Img</title>

		<link href="assets/css/style.css" rel="stylesheet" />
        
		<!-- JavaScript Includes -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

</head>
<body>
<center>
<br />
<h1>Storj Img</h1>
<br /><br />
<form id="upload_form" method="post" action="upload.php" enctype="multipart/form-data">

    <div class="file-upload-container">
        <div class="file-upload-override-button left myButton">
        Choose image file
        <input type="file" name="upl" class="file-upload-button" id="file-upload-button"/>
        </div>
        
        <div class="file-upload-filename left" id="file-upload-filename">No file selected</div>
        <div class="both"></div>
        
        <br /><br />
        <input type="submit" class="myButton" value="Submit"/>
    </div>

</form>

<?php
if(isset($_GET['filehash']))
{
    
    $file_info = file_get_contents('http://node1.metadisk.org/api/find/'.$_GET['filehash']);
    $file_info = json_decode($file_info, true);
    
    //$file = file_get_contents('http://node1.metadisk.org/api/download/'.$_GET['filehash']);
    
    $file = 'http://node1.metadisk.org/api/download/'.$_GET['filehash'].'?key='.$_GET['key'];
    
    
    ?>
    <div >
    <br />
    <?php
    echo "<img src='".$file."' style=\"max-width: 500px;\"/>";
    ?>
    
    <br /><br />
    Download url: <input type='text' value="<?php echo 'http://node1.metadisk.org/api/download/'.$_GET['filehash']; ?>" style="width: 300px;" readonly onclick="this.focus(); this.select();"/>
    <br /><br />
    Edit url: <input type='text' value="<?php echo 'http://bitcoin.info.ro/test/storj-img/index.php?filehash='.$_GET['filehash'].'&key='.$_GET['key']; ?>" style="width: 300px;" readonly onclick="this.focus(); this.select();"/>
    <br /><br />
    
    <?php
    if(!$file_info) echo "<h3>Plese refresh the page in 2-3 seconds in order to see the file info!</h3><h4>The Storj network needs a few seconds at the moment to process...</h4>";
    ?>
    <div class="CSSTableGenerator" style="width: 450px;">
    <table>
        <tr><td>Date Uploaded:</td><td><?php echo date('d M Y', $file_info['datetime']); ?></td></tr>
        <tr><td>Filename:</td><td><?php echo $file_info['filename']; ?></td></tr>
        <tr><td>Filesize:</td><td><?php echo humanFileSize($file_info['filesize']); ?></td></tr>
    </table>
    </div>
    
    </div>
    
    
<?php
     
}





function humanFileSize($size,$unit="") {
  if( (!$unit && $size >= 1<<30) || $unit == "GB")
    return number_format($size/(1<<30),2)."GB";
  if( (!$unit && $size >= 1<<20) || $unit == "MB")
    return number_format($size/(1<<20),2)."MB";
  if( (!$unit && $size >= 1<<10) || $unit == "KB")
    return number_format($size/(1<<10),2)."KB";
  return number_format($size)." bytes";
}
?>


<br /><br /><br /><br /><br />
<a href="http://storj.io/">
<img src="assets/img/Storj_Powered.png"/>
</a>
</center>


</body>
</html>

<script>
$("#file-upload-button").change(function () {
var fileName = $(this).val().replace('C:\\fakepath\\', '');
$("#file-upload-filename").html(fileName);
});
</script>