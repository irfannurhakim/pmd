<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Project Management Dashboard</title>

        <link href="<?= base_url();?>public/css/style.default.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/morris.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/select2.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/style.datatables.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/dataTables.responsive.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/jquery.gritter.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/prettyPhoto.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/owl.carousel.css" rel="stylesheet">
        <link href="<?= base_url();?>public/css/owl.theme.css" rel="stylesheet">

        <!-- CUSTOM CSS HERE -->
        <style type="text/css">
          .dt-cols-center{
            text-align: center;
          }
          .dt-cols-right{
            text-align: right;
          }
          .selectable{
            cursor: pointer;
          }
          .folder-list li a {
            white-space: nowrap;
            overflow: hidden;              /* "overflow" value must be different from "visible" */ 
            text-overflow: ellipsis;
          }
          .container-dt{
            margin-top: -10px;
          }
          .table-item-list{
            font-size: 8pt;
          }
          div.FixedHeader_Cloned th,
          div.FixedHeader_Cloned td {
            background-color: white !important;
            top : 60px!important;
          }
          .form-search .form-control{
            height: 40px;
            font-size: 16px;
            padding-left: 30px;
            -moz-border-radius: 50px;
            -webkit-border-radius: 50px;
            border-radius: 50px;
          }

          .form-search{
            margin-right: 10px;
            margin-top: 0;
            position: relative;
          }

          .form-search:before {
            position: absolute;
            top: 12px;
            left: 12px;
            font-family: 'Glyphicons Halflings';
            content: '\e003';
            color: #666;
          }
          table.table-bordered th:last-child, table.table-bordered td:last-child {
            border-right-width: 1px!important;
          }
          .row-green{
            background-color:#5cb85c;
            color:#fff;
          }
          .title-section{
            min-height: 40px;
          }
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <header>
            <div class="headerwrapper">
                <div class="header-left">
                    <div class="heading-title" style="color:#FFF;font-size:22px;">PM Dashboard</div>
<!--                     <a href="index-2.html" class="logo">
                        <img src="<?= base_url();?>public/images/logo.png" alt="" /> 
                    </a> -->
                    <div class="pull-right">
                        <a href="#" class="menu-collapse">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                </div><!-- header-left -->
                
                <div class="header-right">
                    <div class="pull-left"></div>
                    <div class="pull-right">
                   
                       
                        <div class="btn-group btn-group-list btn-group-notification">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-bell-o"></i>
                              <span class="badge">5</span>
                            </button>
                            <div class="dropdown-menu pull-right">
                                <a href="#" class="link-right"><i class="fa fa-search"></i></a>
                                <h5>Notification</h5>
                                <ul class="media-list dropdown-list">
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user1.png" alt="">
                                        <div class="media-body">
                                          <strong>Nusja Nawancali</strong> likes a photo of you
                                          <small class="date"><i class="fa fa-thumbs-up"></i> 15 minutes ago</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user2.png" alt="">
                                        <div class="media-body">
                                          <strong>Weno Carasbong</strong> shared a photo of you in your <strong>Mobile Uploads</strong> album.
                                          <small class="date"><i class="fa fa-calendar"></i> July 04, 2014</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user3.png" alt="">
                                        <div class="media-body">
                                          <strong>Venro Leonga</strong> likes a photo of you
                                          <small class="date"><i class="fa fa-thumbs-up"></i> July 03, 2014</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user4.png" alt="">
                                        <div class="media-body">
                                          <strong>Nanterey Reslaba</strong> shared a photo of you in your <strong>Mobile Uploads</strong> album.
                                          <small class="date"><i class="fa fa-calendar"></i> July 03, 2014</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user1.png" alt="">
                                        <div class="media-body">
                                          <strong>Nusja Nawancali</strong> shared a photo of you in your <strong>Mobile Uploads</strong> album.
                                          <small class="date"><i class="fa fa-calendar"></i> July 02, 2014</small>
                                        </div>
                                    </li>
                                </ul>
                                <div class="dropdown-footer text-center">
                                    <a href="#" class="link">See All Notifications</a>
                                </div>
                            </div><!-- dropdown-menu -->
                        </div><!-- btn-group -->
                        
                        <div class="btn-group btn-group-list btn-group-messages">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge">2</span>
                            </button>
                            <div class="dropdown-menu pull-right">
                                <a href="#" class="link-right"><i class="fa fa-plus"></i></a>
                                <h5>New Messages</h5>
                                <ul class="media-list dropdown-list">
                                    <li class="media">
                                        <span class="badge badge-success">New</span>
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user1.png" alt="">
                                        <div class="media-body">
                                          <strong>Nusja Nawancali</strong>
                                          <p>Hi! How are you?...</p>
                                          <small class="date"><i class="fa fa-clock-o"></i> 15 minutes ago</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <span class="badge badge-success">New</span>
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user2.png" alt="">
                                        <div class="media-body">
                                          <strong>Weno Carasbong</strong>
                                          <p>Lorem ipsum dolor sit amet...</p>
                                          <small class="date"><i class="fa fa-clock-o"></i> July 04, 2014</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user3.png" alt="">
                                        <div class="media-body">
                                          <strong>Venro Leonga</strong>
                                          <p>Do you have the time to listen to me...</p>
                                          <small class="date"><i class="fa fa-clock-o"></i> July 03, 2014</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user4.png" alt="">
                                        <div class="media-body">
                                          <strong>Nanterey Reslaba</strong>
                                          <p>It might seem crazy what I'm about to say...</p>
                                          <small class="date"><i class="fa fa-clock-o"></i> July 03, 2014</small>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="img-circle pull-left noti-thumb" src="<?= base_url();?>public/images/photos/user1.png" alt="">
                                        <div class="media-body">
                                          <strong>Nusja Nawancali</strong>
                                          <p>Hey I just met you and this is crazy...</p>
                                          <small class="date"><i class="fa fa-clock-o"></i> July 02, 2014</small>
                                        </div>
                                    </li>
                                </ul>
                                <div class="dropdown-footer text-center">
                                    <a href="#" class="link">See All Messages</a>
                                </div>
                            </div><!-- dropdown-menu -->
                        </div><!-- btn-group -->
                        
                        <div class="btn-group btn-group-option">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" data-toggle="modal" data-target=".modal-profile"><i class="glyphicon glyphicon-user"></i> Profil</a></li>
                              <li><a href="#" data-toggle="modal" data-target=".modal-change-password"><i class="fa fa-key"></i> Ubah Password</a></li>
                              <li><a href="<?=base_url();?>#/help"><i class="glyphicon glyphicon-question-sign"></i> Bantuan</a></li>
                              <li class="divider"></li>
                              <li><a href="<?= base_url();?>logout"><i class="glyphicon glyphicon-log-out"></i>Sign Out</a></li>
                            </ul>
                        </div><!-- btn-group -->
                        
                    </div><!-- pull-right -->
                    
                </div><!-- header-right -->
                
            </div><!-- headerwrapper -->

            <div class="modal fade modal-profile" tabindex="-1" role="dialog" id="modal-profile" >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                    <h4 class="modal-title">Profil Pengguna</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <form class="form-horizontal" id="form-update-profile" method="POST" action="<?= base_url();?>profile/update">
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                            </div>
                            <div class="panel-body">
                              <div class="errorForm"></div>

                              <div class="form-group">
                                  <label class="col-sm-4 control-label">Foto Profil</label>
                                  <div class="col-sm-8">  
                                      <img alt="..." src="<?=base_url() . $this->session->userdata('PROFILE_IMAGE_URL');?>" class="img-circle img-online form-control my-profile-picture" style="width:90px!important;">
                                      <input type="file" name="profile-picture" class="form-control" id="field-update-profile-picture"/>
                                  </div>
                              </div><!-- form-group -->
                         
                              <div class="form-group">
                                  <label class="col-sm-4 control-label">Nama<span class="asterisk">*</span></label>
                                  <div class="col-sm-8">
                                      <input type="text" name="name" class="form-control" required title="Kolom Nama wajib diisi!" value="<?=$this->session->userdata('NAME');?>" />
                                  </div>
                              </div><!-- form-group -->

                              <div class="form-group">
                                  <label class="col-sm-4 control-label">Email<span class="asterisk">*</span></label>
                                  <div class="col-sm-8">
                                      <input type="text" name="email" class="form-control" required title="Kolom Email wajib diisi!" value="<?=$this->session->userdata('EMAIL');?>" />
                                  </div>
                              </div><!-- form-group -->

                              <div class="form-group">
                                  <label class="col-sm-4 control-label">Afiliasi<span class="asterisk">*</span></label>
                                  <div class="col-sm-8">
                                      <input type="text" name="affiliation" class="form-control" required title="Kolom Afiliasi wajib diisi!" value="<?=$this->session->userdata('AFFILIATION');?>" />
                                  </div>
                              </div><!-- form-group -->

                            </div><!-- panel-body -->
                            <div class="panel-footer">
                                <button class="btn btn-primary mr5" type="submit" id="btn-update-profile">Simpan</button>
                                <button  aria-hidden="true" data-dismiss="modal" type="button" class="btn btn-default">Cancel</button>
                            </div><!-- panel-footer -->
                          </div><!-- panel-default -->
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade modal-change-password" tabindex="-1" role="dialog" id="modal-change-password" >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                    <h4 class="modal-title">Ubah Password</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <form class="form-horizontal" id="form-change-password" method="POST" action="<?= base_url();?>profile/update_password">
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                            </div>
                            <div class="panel-body">
                              <div class="errorForm"></div>
                         
                              <div class="form-group">
                                  <label class="col-sm-4 control-label">Password Lama<span class="asterisk">*</span></label>
                                  <div class="col-sm-8">
                                      <input type="password" name="my-old-password" class="form-control" required title="Kolom Password Lama wajib diisi!" />
                                  </div>
                              </div><!-- form-group -->

                              <div class="form-group">
                                  <label class="col-sm-4 control-label">Password Baru<span class="asterisk">*</span></label>
                                  <div class="col-sm-8">
                                      <input type="password" name="my-new-password" class="form-control" required title="Kolom Password Baru wajib diisi!" />
                                  </div>
                              </div><!-- form-group -->

<!--                               <div class="form-group">
                                  <label class="col-sm-4 control-label">Ulangi Password<span class="asterisk">*</span></label>
                                  <div class="col-sm-8">
                                      <input type="password" name="confirm-new-password" class="form-control" required title="Kolom Ulangi Password wajib diisi!" />
                                  </div>
                              </div>
 -->
                            </div><!-- panel-body -->
                            <div class="panel-footer">
                                <button class="btn btn-primary mr5" type="submit" id="btn-update-profile">Simpan</button>
                                <button  aria-hidden="true" data-dismiss="modal" type="button" class="btn btn-default">Cancel</button>
                            </div><!-- panel-footer -->
                          </div><!-- panel-default -->
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </header>

        <section>
            <div class="mainwrapper">

