<?php only_admin_access(); ?>
<script  type="text/javascript">



mw.require('forms.js', true);
mw.require('options.js', true);
</script>
<script  type="text/javascript">
$(document).ready(function(){

  mw.options.form('.<?php print $config['module_class'] ?>', function(){
      mw.notification.success("<?php _e("User settings updated"); ?>.");
    });


mw.tools.tabGroup({
   tabs:'.group-logins',
   nav:'.login-tab-group',
   toggle:true,
   onclick:function(){
     mw.$(".social-providers-list li").removeClass("active");
     if($(this).hasClass("active")){
       $(this.parentNode).addClass("active")
     }
     else{
        $(this.parentNode).removeClass("active")
     }
   }
});

});
</script>
 <style type="text/css">
     .group-logins{
       display: none;
     }

     [class*="mw-social-ico"]{
       cursor: pointer;
     }

     .social-providers-list{
       clear: both;
       padding-bottom: 20px;
       overflow: hidden;
     }

     .social-providers-list li{
       list-style: none;
       float: left;
       margin-right: 10px;
       padding: 5px;
       border: 1px solid transparent;
       border-radius:2px;
     }

     .social-providers-list li:hover, .social-providers-list li.active{
       background-color: #F4F4F4;
       border-color: #E0E0E0;
     }

     .group-logins{
       padding: 14px;
       border: 1px solid #E0E0E0;
       border-radius:2px;
       background: #F4F4F4;
     }

     .group-logins ul{
       padding: 0 0 20px 14px;
     }

     .social-providers-list .mw-ui-check {
          cursor: pointer;
          display: inline-block;
          float: left;
          margin-right: 2px;
          margin-top: 11px;
          white-space: nowrap;
      }

      .group-logins .mw-title-field{
        width: 380px;
      }

 </style>
<div class="<?php print $config['module_class'] ?>">
  <?php  $curent_val = get_option('enable_user_registration','users'); ?>
  <label class="mw-ui-label"><?php _e("Enable User Registration"); ?></label>
  <div class="mw-ui-select">
    <select name="enable_user_registration" class="mw_option_field"   type="text" option-group="users">
      <option value="y" <?php if($curent_val == 'y'): ?> selected="selected" <?php endif; ?>><?php _e("Yes"); ?></option>
      <option value="n" <?php if($curent_val == 'n'): ?> selected="selected" <?php endif; ?>><?php _e("No"); ?></option>
    </select>
  </div>

 <div class="vSpace"></div>

<label class="mw-ui-label"><?php _e("Allow Social Login with"); ?></label>


  <?php

 $enable_user_fb_registration = get_option('enable_user_fb_registration','users');
 $enable_user_google_registration = get_option('enable_user_google_registration','users');
 $enable_user_github_registration = get_option('enable_user_github_registration','users');
 $enable_user_twitter_registration = get_option('enable_user_twitter_registration','users');
 $enable_user_windows_live_registration = get_option('enable_user_windows_live_registration','users');


 if($enable_user_fb_registration == false){
	$enable_user_fb_registration = 'n';
 }

 if($enable_user_google_registration == false){
	$enable_user_google_registration = 'n';
 }

 if($enable_user_github_registration == false){
    $enable_user_github_registration = 'n';
 }

 if($enable_user_twitter_registration == false){
    $enable_user_twitter_registration = 'n';
 }

 if($enable_user_windows_live_registration == false){
    $enable_user_windows_live_registration = 'n';
 }


  ?>


<ul class="social-providers-list">
    <li class="active">
      <label class="mw-ui-check"><input type="checkbox" value="y" <?php if($enable_user_fb_registration == 'y'): ?> checked <?php endif; ?> name="enable_user_fb_registration" class="mw_option_field" option-group="users" <?php /*data-refresh="settings/group/users"*/ ?>><span></span></label>
      <span class="mw-social-ico-facebook login-tab-group active"></span>
    </li>
    <li>
      <label class="mw-ui-check"><input type="checkbox" value="y" <?php if($enable_user_google_registration == 'y'): ?> checked <?php endif; ?> name="enable_user_google_registration" class="mw_option_field" option-group="users"><span></span></label>
      <span class="mw-social-ico-google login-tab-group"></span>
    </li>
    <li>
      <label class="mw-ui-check"><input type="checkbox" value="y" <?php if($enable_user_github_registration == 'y'): ?> checked <?php endif; ?> name="enable_user_github_registration" class="mw_option_field" option-group="users"><span></span></label>
      <span class="mw-social-ico-github login-tab-group"></span>
    </li>
    <li>
      <label class="mw-ui-check"><input type="checkbox" value="y" <?php if($enable_user_twitter_registration == 'y'): ?> checked <?php endif; ?> name="enable_user_twitter_registration" class="mw_option_field" option-group="users"><span></span></label>
      <span class="mw-social-ico-twitter login-tab-group"></span>
    </li>
    <li>
      <label class="mw-ui-check"><input type="checkbox" value="y" <?php if($enable_user_windows_live_registration == 'y'): ?> checked <?php endif; ?> name="enable_user_windows_live_registration" class="mw_option_field" option-group="users" ><span></span></label>
      <span class="mw-social-ico-live login-tab-group"></span>
    </li>
</ul>




<div class="group-logins" style="display: block">
  <ul class="mw-small-help">
    <li><?php _e("Api access"); ?> <a class="mw-ui-link" target="_blank" href="https://developers.facebook.com/apps">https://developers.facebook.com/apps</a></li>
    <li><?php _e("In"); ?> <em><?php _e("Website with Facebook Login"); ?></em> <?php _e("please enter"); ?> <em><?php print site_url(); ?></em></li>
    <li><?php _e("If asked for callback url - use"); ?> <em><?php print mw('url')->api_link('social_login_process?hauth.done=Facebook') ?></em></li>
  </ul>
  <label class="mw-ui-label-inline"><?php _e("App ID/API Key"); ?></label>
  <input name="fb_app_id" class="mw_option_field mw-ui-field mw-title-field "   type="text" option-group="users"  value="<?php print get_option('fb_app_id','users'); ?>" />
  <div class="vSpace"></div>
  <label class="mw-ui-label-inline"><?php _e("App Secret"); ?></label>
  <input name="fb_app_secret" class="mw_option_field mw-ui-field mw-title-field"   type="text" option-group="users"  value="<?php print get_option('fb_app_secret','users'); ?>" />
</div>


  <div class="group-logins">

  <ul class="mw-small-help">
    <li><?php _e("Set your"); ?> <em><?php _e("Api access"); ?></em> <a class="mw-ui-link" target="_blank" href="https://code.google.com/apis/console/">https://code.google.com/apis/console/</a></li>
    <li><?php _e("In redirect URI  please enter"); ?> <em><?php print mw('url')->api_link('social_login_process?hauth.done=Google') ?></em></li>
  </ul>
  <label class="mw-ui-label-inline"><?php _e("Client ID"); ?></label>
  <input name="google_app_id" class="mw_option_field mw-ui-field mw-title-field" style=""   type="text" option-group="users"  value="<?php print get_option('google_app_id','users'); ?>" />
  <div class="vSpace"></div>
  <label class="mw-ui-label-inline"><?php _e("Client secret"); ?></label>
  <input name="google_app_secret" class="mw_option_field mw-ui-field mw-title-field"  style=""  type="text" option-group="users"  value="<?php print get_option('google_app_secret','users'); ?>" />

 </div>


  <div class="group-logins">

  <ul class="mw-small-help">
    <li><?php _e("Register your application"); ?> <a class="mw-ui-link" target="_blank" href="https://github.com/settings/applications/new">https://github.com/settings/applications/new</a></li>
    <li><?php _e("In"); ?> <em><?php _e("Main URL"); ?></em> <?php _e("enter"); ?> <em><?php print site_url() ?></em></li>
    <li><?php _e("In"); ?> <em><?php _e("Callback URL"); ?></em> <?php _e("enter"); ?> <em><?php print mw('url')->api_link('social_login_process?hauth.done=Github') ?></em></li>
  </ul>
  <label class="mw-ui-label-inline"><?php _e("Client ID"); ?></label>
  <input name="github_app_id" class="mw_option_field mw-ui-field mw-title-field" style=""   type="text" option-group="users"  value="<?php print get_option('github_app_id','users'); ?>" />
  <div class="vSpace"></div>
  <label class="mw-ui-label-inline"><?php _e("Client secret"); ?></label>
  <input name="github_app_secret" class="mw_option_field mw-ui-field mw-title-field"  style=""  type="text" option-group="users"  value="<?php print get_option('github_app_secret','users'); ?>" />

  </div>






  <div class="group-logins">
  <ul class="mw-small-help">
    <li><?php _e("Register your application"); ?> <a class="mw-ui-link" target="_blank" href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a></li>
    <li><?php _e("In"); ?> <em><?php _e("Website"); ?></em> <?php _e("enter"); ?> <em><?php print site_url(); ?></em></li>
    <li><?php _e("In"); ?> <em><?php _e("Callback URL"); ?></em> <?php _e("enter"); ?> <em><?php print mw('url')->api_link('social_login_process?hauth.done=Twitter') ?></em></li>
  </ul>
  <label class="mw-ui-label-inline"><?php _e("Consumer key"); ?></label>
  <input name="twitter_app_id" class="mw_option_field mw-ui-field mw-title-field" style=""   type="text" option-group="users"  value="<?php print get_option('twitter_app_id','users'); ?>" />
  <div class="vSpace"></div>
  <label class="mw-ui-label-inline"><?php _e("Consumer secret"); ?></label>
  <input name="twitter_app_secret" class="mw_option_field mw-ui-field mw-title-field"  style=""  type="text" option-group="users"  value="<?php print get_option('twitter_app_secret','users'); ?>" />

 </div>
   <div class="group-logins">
  <ul class="mw-small-help">
    <li><?php _e("Register your application"); ?> <a class="mw-ui-link" target="_blank" href="https://manage.dev.live.com/ApplicationOverview.aspx">https://manage.dev.live.com/ApplicationOverview.asp</a></li>
    <li><?php _e("In"); ?> <em><?php _e("Redirect Domain"); ?></em> <?php _e("enter"); ?> <em><?php print site_url() ?></em></li>
    <li><?php _e("In"); ?> <em><?php _e("Callback URL"); ?></em> <?php _e("enter"); ?> <em><?php print mw('url')->api_link('social_login_process?hauth.done=Live') ?></em></li>
  </ul>
  <label class="mw-ui-label-inline"><?php _e("Client ID"); ?></label>
  <input name="windows_live_app_id" class="mw_option_field mw-ui-field mw-title-field" style=""   type="text" option-group="users"  value="<?php print get_option('windows_live_app_id','users'); ?>" />
  <div class="vSpace"></div>
  <label class="mw-ui-label-inline"><?php _e("Client secret"); ?></label>
  <input name="windows_live_app_secret" class="mw_option_field mw-ui-field mw-title-field"  style=""  type="text" option-group="users"  value="<?php print get_option('windows_live_app_secret','users'); ?>" />
 </div>



  <?php


  /*
  ..

   <h2>Yahoo</h2>
  <label class="mw-ui-label">Enable Yahoo Login </label>
  <?php   $enable_user_yahoo_registration = get_option('enable_user_yahoo_registration','users');

 if($enable_user_yahoo_registration == false){
  $enable_user_yahoo_registration = 'n';
 }
  ?>
  <div class="mw-ui-select">
    <select name="enable_user_yahoo_registration" class="mw_option_field"   type="text" option-group="users" data-refresh="settings/group/users">
      <option value="y" <?php if($enable_user_yahoo_registration == 'y'): ?> selected="selected" <?php endif; ?>>Yes</option>
      <option value="n" <?php if($enable_user_yahoo_registration == 'n'): ?> selected="selected" <?php endif; ?>>No</option>
    </select>
  </div>
  <div class="vSpace"></div>
  <div class="vSpace"></div>
  <?php if($enable_user_yahoo_registration == 'y'): ?>
  <ul class="mw-small-help">
    <li>Go here to register your application <a target="_blank" href="https://developer.apps.yahoo.com/dashboard/createKey.html">https://developer.apps.yahoo.com/dashboard/createKey.html</a></li>
    <li>In Website please enter <em><?php print site_url() ?></em></li>
    <li>In Callback URL please enter <em><?php print mw('url')->api_link('social_login_process?hauth.done=Yahoo') ?></em></li>
  </ul>
  <label class="mw-ui-label-inline">Consumer key</label>
  <input name="yahoo_app_id" class="mw_option_field mw-ui-field mw-title-field" style="width: 380px;"   type="text" option-group="users"  value="<?php print get_option('yahoo_app_id','users'); ?>" />
  <div class="vSpace"></div>
  <label class="mw-ui-label-inline">Consumer secret</label>
  <input name="yahoo_app_secret" class="mw_option_field mw-ui-field mw-title-field"  style="width: 380px;"  type="text" option-group="users"  value="<?php print get_option('yahoo_app_secret','users'); ?>" />
  <?php endif; ?>
  <div class="vSpace"></div>
  <div class="vSpace"></div>


  */

  ?>
</div>
