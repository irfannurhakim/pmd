<div class="leftpanel">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="profile.html">
            <img class="img-circle" src="<?= base_url();?>public/images/photos/profile.png" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><?= @$this->session->userdata('NAME');?></h4>
            <small class="text-muted"><?= @$this->session->userdata('AFFILIATION');?></small>
        </div>
    </div><!-- media -->
    
    <h5 class="leftpanel-title"></h5>
    <ul class="nav nav-pills nav-stacked">
      <?php 
        if($this->session->userdata('ID_USER_TYPE') == 1 || $this->session->userdata('ID_USER_TYPE') == 2){ ?>
        <li id="menu-home" class="activable"><a href="#/home"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
      <?php } ?>
        <li id="menu-quick-access" class="activable"><a href="#/quick_access"><i class="fa fa-magic"></i> <span>Akses Cepat</span></a></li>
        <li id="menu-projects" class="activable"><a href="#/projects"><i class="fa fa-suitcase"></i> <span>Proyek</span></a></li>
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
    </ul>
</div><!-- leftpanel -->

                