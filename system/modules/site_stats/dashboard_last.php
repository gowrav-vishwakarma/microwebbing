<?php   $users_last5 = get_visits('last5');
//$requests_num = get_visits('requests_num');
$requests_num = false;
?><div id="users_online"><h2><?php _e("Users Online"); ?></h2>
  <div class="users_online" id="real_users_online">
    <?php $users_online = get_visits('users_online'); print intval($users_online); ?>
  </div>  </div>
  <div id="visits_info_table">
  <h2><?php _e("User Info"); ?><?php if($requests_num != false): ?> <small>(<?php print $requests_num ?> <?php _e("req/s"); ?>)</small><?php endif; ?></h2>
  <?php

    ?>
  <?php if(!empty($users_last5)): ?>
  <table border="0" cellspacing="0" cellpadding="0" class="stats_table">
    <thead>
      <tr>
        <th scope="col"><?php _e("Date"); ?></th>
        <?php if(function_exists('ip2country')): ?>
        <th scope="col"><?php _e("Country"); ?></th>
        <?php endif; ?>
        <th scope="col"><?php _e("IP"); ?></th>
        <th scope="col"><?php _e("Last page"); ?></th>
        <th scope="col"><?php _e("Page views"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; foreach($users_last5 as $item) : ?>
      <tr>
        <td><?php print $item['visit_date'] ?> <?php print $item['visit_time'] ?></td>
        <?php if(function_exists('ip2country')): ?>
        <td><?php   print ip2country($item['user_ip']); ?></td>
        <?php endif; ?>
        <td><?php print $item['user_ip'] ?></td>
        <td style="word-break: break-all;word-wrap: break-word"><a href="<?php print $item['last_page'] ?>"><u><?php print $item['last_page']; ?></u></a></td>
        <td><?php print $item['view_count'] ?></td>
      </tr>
      <?php $i++; endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>