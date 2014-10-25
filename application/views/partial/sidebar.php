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
        <li id="menu-home" class="activable"><a href="#/home"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
        <li id="menu-projects" class="activable"><a href="#/projects"><i class="fa fa-suitcase"></i> <span>Proyek</span></a></li>
        <li id="menu-settings" class="activable"><a href="#/settings"><i class="fa fa-gear"></i> <span>Pengaturan</span></a></li>                        
    </ul>
</div><!-- leftpanel -->

                