<ul class="nav nav-pills nav-stacked">
    <?php
    foreach ($projects as $project) { ?>
    <li style="background-color:#eee;">
        <a href="<?=base_url();?>#/realisasi/<?=$project['ID'];?>">
            <!-- <span class="badge pull-right"><?=$project['TOTAL_TASK'];?></span> -->
            <strong><?=$project['NAME'];?></strong>
        </a>
    </li>
    <?php } ?>
</ul>

