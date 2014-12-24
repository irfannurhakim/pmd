
<div class="row">
    <div class="col-md-12">
        <h5 class="lg-title mb10">Bantuan</h5>
        <p class="mb20">Berikut adalah dokumen petunjuk penggunaan aplikasi, dipisahkan berdasarkan Hak Akses.</p>
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab"><strong>Panduan Pengawas</strong></a></li>
            <li><a href="#profile" data-toggle="tab"><strong>Panudan Admin Proyek</strong></a></li>
            <li><a href="#about" data-toggle="tab"><strong>Panduan Administrator</strong></a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content mb30">
            <div class="tab-pane active" id="home">
                <iframe id="viewer1" src="<?=base_url();?>public/pdfjs/web/viewer.html?file=<?=base_url();?>public/guide/manual_pengawas.pdf" width='100%' height='700'  allowfullscreen webkitallowfullscreen></iframe>                 
            </div><!-- tab-pane -->
          
            <div class="tab-pane" id="profile">
                <iframe id="viewer1" src="<?=base_url();?>public/pdfjs/web/viewer.html?file=<?=base_url();?>public/guide/manual_admin_proyek.pdf" width='100%' height='700'  allowfullscreen webkitallowfullscreen></iframe>                 
            </div><!-- tab-pane -->
          
            <div class="tab-pane" id="about">
                <iframe id="viewer1" src="<?=base_url();?>public/pdfjs/web/viewer.html?file=<?=base_url();?>public/guide/manual_admin.pdf" width='100%' height='700'  allowfullscreen webkitallowfullscreen></iframe>                 
            </div><!-- tab-pane -->
          
        </div><!-- tab-content -->
        
    </div><!-- col-md-6 -->
</div>

