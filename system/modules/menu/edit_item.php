<?php
$rand = uniqid();
if(is_admin() == false){
    mw_error('Must be admin');
}
$id = false;
if(isset($params['item-id'])){
	$id = intval($params['item-id']);
}
 

if($id == 0){
	$data = array();
	$data['id'] = $id;
	$data['parent_id'] = 0;
	if(isset($params['parent_id'])){
		$data['parent_id'] = intval($params['parent_id']);
	}else if(isset($params['menu-id'])){
		$data['parent_id'] = intval($params['menu-id']);
	}
	if(!isset($params['content_id'])){
		$data['content_id'] = '';
	} else {
		$data['content_id'] = $params['content_id'];
	}
	if(!isset($params['categories_id'])){
		$data['categories_id'] = '';
	} else {
		$data['categories_id'] = $params['categories_id'];
	}
	$data['is_active'] = 'y';
	$data['position'] = '9999';
	$data['url'] = '';
	$data['title'] = '';
//	$data['categories_id'] = '';
} else {

	$data = mw('content')->menu_item_get($id);
}
if( $id != 0){
//$data = menu_tree( $id);
}

?>
<?php if($data != false): ?>
<?php //$rand = uniqid(); ?>


<div class="vSpace"></div>
<div class="<?php print $config['module_class']; ?> menu_item_edit" id="mw_content/menu_item_save_<?php  print $rand ?>">
  <?php if((!isset($data['title']) or $data['title']=='' ) and isset($data["content_id"]) and intval($data["content_id"]) > 0 ): ?>
  <?php $cont = mw('content')->get_by_id($data["content_id"]);
	if(isset($cont['title'])){
		$data['title'] = $cont['title'];
		$item_url = mw('content')->link($cont['id']);
	}
	?>
  <?php else: ?>
  <?php if((!isset($data['title']) or $data['title']=='' )and isset($data["categories_id"]) and intval($data["categories_id"])>0): ?>
  <?php $cont = get_category_by_id($data["categories_id"]);
    if(isset($cont['title'])){
    	$data['title'] = $cont['title'];
    	  $item_url = category_link($cont['id']);
    }
?>
  <?php endif; ?>
  <?php endif; ?>
  <?php
  if (isset($data['content_id']) and intval($data['content_id']) != 0) {
		 	$item_url = mw('content')->link($data['content_id']);

	}

	if (isset($data['categories_id']) and intval($data['categories_id']) != 0) {

	$item_url = category_link($data['categories_id']);
	}


  if ((isset($item_url)  and $item_url != false) and (!isset($data['url']) or trim($data['url']) == '')) {
    $data['url'] = $item_url ;
  }


  ?>
  <div id="custom_link_inline_controller" class="mw-ui-gbox" style="display: none;"> <span onclick="cancel_editing_menu(<?php  print $data['id'] ?>);" class="mw-ui-btnclose"></span>
    <h4>Edit menu item</h4>
    <div class="custom_link_delete_header"> <span class="mw-ui-delete" onclick="mw.menu_item_delete(<?php  print $data['id'] ?>);"><?php _e("Delete"); ?></span></div>
    <input type="hidden" name="id" value="<?php  print $data['id'] ?>" />
	
    <input type="text" placeholder="<?php _e("Title"); ?>" class="mw-ui-field" name="title" value="<?php  print $data['title'] ?>" /> 
	<?php  if(isset($params['menu-id'])): ?>
    <input type="hidden" name="parent_id" value="<?php  print $params['menu-id'] ?>" />
	<?php else: ?>
 
    <?php endif; ?>
    <button class="mw-ui-btn2" onclick="mw.$('#menu-selector-<?php  print $data['id'] ?>').toggle();">
    <?php _e("Select"); ?>
    </button>
    <div class="mw_clear vSpace"></div>
    <input type="text" placeholder="<?php _e("URL"); ?>" class="mw-ui-field"  name="url" value="<?php  print $data['url'] ?>" />
    <button class="mw-ui-btn2 mw-ui-btn-green left" onclick="mw.menu_save_new_item('#custom_link_inline_controller');"><?php _e("Save"); ?></button>
    <div class="mw_clear vSpace"></div>
    <?php if($data['id'] != 0): ?>
    <div id="menu-selector-<?php  print $data['id'] ?>" class="mw-ui mw-ui-category-selector mw-tree mw-tree-selector">
      <microweber module="categories/selector" active_ids="<?php  print $data['content_id'] ?>" categories_active_ids="<?php  print $data['categories_id'] ?>"  for="content" rel_id="<?php print 0 ?>" input-type-categories="radio"  input-name-categories="link_id" input-name="link_id"  />
    </div>
    <script>mw.treeRenderer.appendUI('#menu-selector-<?php  print $data['id'] ?>'); </script>
    <?php endif; ?>
   
  </div>
  <input type="hidden" name="id" value="<?php  print $data['id'] ?>" />
  <input type="hidden" name="content_id" value="<?php  print $data['content_id'] ?>" />
  <input type="hidden" name="categories_id" value="<?php  print $data['categories_id'] ?>" />
  <?php  if(isset($params['menu-id'])): ?>
  <input type="hidden" name="parent_id" value="<?php  print $params['menu-id'] ?>" />
  <?php  elseif(isset($data['parent_id']) and $data['parent_id'] !=0): ?>
  <input type="hidden" name="parent_id" value="<?php  print $data['parent_id'] ?>" />
  <?php  elseif(isset($params['parent_id'])): ?>
  <input type="hidden" name="parent_id" value="<?php  print $params['parent_id'] ?>" />
  <?php endif; ?>
</div>
<?php else: ?>
<?php endif; ?>
