<?php $this_field_name = (!isset($field_name) or !$field_name) ? "category":$field_name;  ?>
<select name="<?php print $this_field_name ?>"    class="mw-exec-option"  >
  <option     value="">false</option>
  <?php
$pt_opts = array();
$pt_opts['link'] = " <option value='{id}'>({id}) {title}</option>";
$pt_opts['list_tag'] = " ";
 
 mw('category')->tree($pt_opts);

  ?>
</select>
