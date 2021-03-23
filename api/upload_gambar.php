<?php 
 
// be aware of file / directory permissions on your server 
 
move_uploaded_file($_FILES['webcam']['tmp_name'], '../data/absen-cam/webcam'.md5(time()).rand(383,1000).'.jpg'); 
 
?>