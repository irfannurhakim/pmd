<div class="leftpanel">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="#" data-toggle="modal" data-target=".modal-profile">
            <img class="img-circle my-profile-picture" src="<?= base_url() . $this->session->userdata('PROFILE_IMAGE_URL');?>" alt="" width="60px">
        </a>
        <div class="media-body">
            <h4 class="media-heading my-profile-name"><?= @$this->session->userdata('NAME');?></h4>
            <small class="text-muted my-profile-affiliation"><?= @$this->session->userdata('AFFILIATION');?></small>
        </div>
    </div><!-- media -->
    
    <h5 class="leftpanel-title"></h5>
    <ul class="nav nav-pills nav-stacked">
      <?php 
        if($this->session->userdata('ID_USER_TYPE') == 1 || $this->session->userdata('ID_USER_TYPE') == 2 || $this->session->userdata('ID_USER_TYPE') == 6){ ?>
        <li id="menu-home" class="activable"><a href="#/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <?php } ?>
        <li id="menu-quick-access" class="activable"><a href="#/quick_access"><i class="fa fa-magic"></i> <span>Akses Cepat</span></a></li>
        <li id="menu-projects" class="activable"><a href="#/projects"><i class="fa fa-suitcase"></i> <span>Proyek</span></a></li>
<!--         <li id="menu-reports" class="parent activable"><a href="#"><i class="fa fa-bar-chart-o"></i> <span>Laporan</span></a>
          <ul class="children">
            <li class="activable" id="menu-weekly"><a href="<?=base_url();?>#/weekly_report"> Laporan Mingguan</a></li>
             <li class="activable" id="menu-statistics"><a href="<?=base_url();?>#/statistik"> Statistik</a></li>
           </ul>
        </li>  -->
      <?php 
        if($this->session->userdata('ID_USER_TYPE') == 1){ ?>        
        <li id="menu-settings" class="parent activable"><a href="#"><i class="fa fa-gear"></i> <span>Pengaturan</span></a>
          <ul class="children">
            <li class="activable" id="menu-users"><a href="<?=base_url();?>#/users"> Pengguna</a></li>
            <li class="activable" id="menu-notices"><a href="<?=base_url();?>#/notices"> Master Surat Peringatan</a></li>
<!--             <li class="activable" id="menu-apps"><a href="<?=base_url();?>#/apps"> Aplikasi</a></li>
 -->          </ul>
        </li>    
      <?php } ?> 
      <li id="menu-help" class="activable"><a href="#/help"><i class="glyphicon glyphicon-question-sign"></i> <span>Bantuan</span></a></li>
    </ul>
</div><!-- leftpanel -->

                