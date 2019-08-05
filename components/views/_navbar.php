<?php

/* @var $items array|mixed */

?>

<ul class="navbar-nav mx-auto ">
  <?php foreach ($items as $item) { ?>
    <li class="nav-item <?php echo $item['active'] ? 'active' : ''; ?>">
      <a class="nav-link <?php echo $item['additionalClass'] ? $item['additionalClass'] : ''; ?>" href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a>
    </li>
  <?php } ?>
</ul>
