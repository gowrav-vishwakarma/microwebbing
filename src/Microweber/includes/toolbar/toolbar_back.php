


 

<link href="<?php   print( MW_INCLUDES_URL);  ?>api/api.css" rel="stylesheet" type="text/css" />
<link href="<?php   print( MW_INCLUDES_URL);  ?>css/mw_framework.css" rel="stylesheet" type="text/css" />
 
  <a href="<?php
  if(defined('CONTENT_ID') and CONTENT_ID != 0){
	  $u  = mw('content')->link(CONTENT_ID);
  } else {
	  $u  =mw('url')->current(1,1);
  }
 print $u ?>?editmode:y"  class="mw-ui-btn mw-ui-btn-small mw-ui-btn-green" id="mw_toolbar_back_to_live_edit"><span class="ico ilive"></span><?php _e("Back to Live Edit"); ?></a> 

