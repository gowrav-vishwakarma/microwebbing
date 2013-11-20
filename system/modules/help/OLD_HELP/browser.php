<?php 
 $path = $base_path = $config['path_to_module'].'docs'.DS;
 $from_path = '';
  
 
 if(isset($params['from_path'])){
	$from_path =  $params['from_path'];
 }
 
  if(isset($params['base_path']) and $params['base_path'] != ''){
	$path =  $base_path.html_entity_decode($params['base_path']).DS;
 }
  
 
 
 
 if($from_path != ''): ?>
<?php $path .=html_entity_decode($from_path).DS;  ?>
<?php endif; ?>
<?php
 
$kw = false;  
if(isset($params['kw'])){
	$kw = $params['kw']; 
}
 
 
 $dirs =  mw('Microweber\Utils\Files')->dir_tree($path,$kw);
  $dirs = str_replace($base_path, '', $dirs);
  if(isset($params['ul_class'])){
     $dirs = str_replace("ul class='directory_tree'","ul class='directory_tree ".$params['ul_class']."'", $dirs);
  }
    print $dirs;  ?>
