<ul class="nav nav-pills nav-stacked">
    <?php

    if(count($projects) < 1){ ?>
      <div class="alert alert-info">Belum ada proyek yang sedang berlangsung. Untuk membuat proyek, silahkan menuju <a href="<?=base_url();?>#/projects">kesini.</a></div>
    <?php } else {
      foreach ($projects as $project) { ?>
      <li style="background-color:#eee;">
          <a href="<?=base_url();?>#/realisasi/<?=$project['ID'];?>">
              <!-- <span class="badge pull-right"><?=$project['TOTAL_TASK'];?></span> -->
              <strong><?=$project['NAME'];?></strong>
          </a>
      </li>
      <?php }
    } ?>
</ul>

