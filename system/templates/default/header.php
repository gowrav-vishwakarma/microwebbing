<!DOCTYPE HTML>
<html prefix="og: http://ogp.me/ns#">
    <head>
    <title>{content_meta_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta property="og:title" content="{content_meta_title}">
    <meta name="keywords" content="{content_meta_keywords}">
    <meta name="description" content="{content_meta_description}">
    <meta property="og:type" content="{og_type}">
    <meta property="og:url" content="{content_url}">
    <meta property="og:image" content="{content_image}">
    <meta property="og:description" content="{og_description}">
    <meta property="og:site_name" content="{og_site_name}">
    <script type="text/javascript">
        mw.require("url.js");
        mw.require("tools.js");
        mw.require("<?php print( MW_INCLUDES_URL); ?>css/mw.ui.css");
        mw.lib.require("bootstrap2");
    </script>
    <?php if(isset($custom_head)): ?>
    <?php print $custom_head; ?>
    <?php else : ?>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=greek,latin,cyrillic-ext,latin-ext,cyrillic" />
    <link rel="stylesheet" href="{DEFAULT_TEMPLATE_URL}css/style.css" type="text/css" media="all">
    <script type="text/javascript" src="{DEFAULT_TEMPLATE_URL}js/default.js"></script>
    <?php endif; ?>
    </head>
    <body>
<div id="header" class="clearfix">
      <div class="container">
      <div class="edit" rel="global" field="header1">
        <div class="mw-row">
            <div class="mw-col" style="width: 20%">
                <div class="mw-col-container">
                    <div class="brand element" id="logo"><a href="<?php print site_url(); ?>">New World</a></div>
                </div>
            </div>
            <div class="mw-col" style="width: 45%">
                <div class="mw-col-container">
                    <module type="menu" name="header_menu" id="main-navigation" template="pills"  />
                </div>
            </div>
            <div class="mw-col" style="width: 35%">
                <div class="mw-col-container">
                    <module type="shop/cart" template="small" />
                </div>
            </div>
        </div>
      </div>
  </div>
    </div>
<!-- /#header --> 

