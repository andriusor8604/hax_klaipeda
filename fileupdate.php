<?php
$file = 'data.txt';
$result = array();
clearstatcache(true, $file);

///$data['time']    = filemtime($file);
$data['content'] = file_get_contents($file);

 $files = glob('last*.jpg');
 $filemtime = filemtime($files[0]);
 $data['img'] = $files[0]."?".$filemtime;
 
 $json = file_get_contents('./unix.txt');
 $json_data = json_decode($json,true);

//Print data
 $data['unix'] = gmdate("M d Y H:i:s", strtotime('+3 hours',$json_data['time']));
 
 
   /// ? file_get_contents($file)
  ///  : false;

echo json_encode($data);