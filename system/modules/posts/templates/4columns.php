<?php

/*

type: layout

name: 4 Columns

description: 4 Columns

*/
?>



<div class="clearfix container-fluid module-posts-template-columns module-posts-template-columns-4">
  <div class="row-fluid">
    <?php if (!empty($data)): ?>
    <?php
        $count = -1;
        foreach ($data as $item):
        $count++;
    ?>
    <?php if($count % 4 == 0) { ?><div class="v-space"></div><?php } ?>
    <div class="span3<?php if($count % 4 == 0) { ?> first <?php } ?>" >
        <?php if(!isset($show_fields) or $show_fields == false or in_array('thumbnail', $show_fields)): ?>
            <a class="img-polaroid img-rounded" href="<?php print $item['link'] ?>">
                <span class="valign">
                    <span class="valign-cell">
                        <img <?php if($item['image']==false){ ?>class="pixum"<?php } ?> src="<?php print thumbnail($item['image'], 290, 120); ?>" alt="<?php print addslashes($item['title']); ?> - <?php _e("image"); ?>" title="<?php print addslashes($item['title']); ?>" />
                    </span>
                </span>
            </a>
        <?php endif; ?>
        <div class="module-posts-head">
        <?php if(!isset($show_fields) or $show_fields == false or in_array('title', $show_fields)): ?>
            <h3><a class="lead" href="<?php print $item['link'] ?>"><?php print $item['title'] ?></a></h3>
        <?php endif; ?>
        <?php if(!isset($show_fields) or $show_fields == false or in_array('created_on', $show_fields)): ?>
            <small class="muted"><?php _e("Posted on"); ?>: <?php print $item['created_on']; ?></small>
        <?php endif; ?>
        </div>
        <?php if(!isset($show_fields) or $show_fields == false or in_array('description', $show_fields)): ?>
            <p class="description"><?php print $item['description'] ?></p>
        <?php endif; ?>


      <?php if(!isset($show_fields) or $show_fields == false or in_array('read_more', $show_fields)): ?>
      <div class="blog-post-footer">
        <a href="<?php print $item['link'] ?>" class="btn pull-fleft">
        <?php $read_more_text ? print $read_more_text : print _e('Continue Reading', true); ?>
        <i class="icon-chevron-right"></i></a>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>



    <?php endif; ?>
  </div>
 <?php if (isset($pages_count) and $pages_count > 1 and isset($paging_param)): ?>
    <?php print mw('content')->paging("num={$pages_count}&paging_param={$paging_param}&curent_page={$curent_page}") ?>
    
 <?php endif; ?>
</div>
