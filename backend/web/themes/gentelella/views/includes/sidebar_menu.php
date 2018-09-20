<?php
use yii\helpers\Url;
use yii\helpers\Html;
$adminArr = Yii::$app->user->identity;
?>
<div class="col-md-3 left_col">
    <div class="left_col"><!--scroll-view-->
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo Url::home(); ?>" class="site_title"><i class="fa fa-paw"></i> <span><?php echo SITE_NAME; ?></span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="<?php echo Url::home(); ?>themes/gentelella/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo Yii::$app->user->identity->username; ?></h2>
            </div>
        </div>
        <!-- /menu prile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
					<?php if(isset($adminArr['admin_type']) && $adminArr['admin_type'] == '1') { ?>
                    <!--  manage banner -->
                    <li><?php echo Html::a('<i class="fa fa-picture-o"></i>Banner', Url::home() . 'banner', ['banner']); ?></li> 
                    <li><?php echo Html::a('<i class="fa fa-file-video-o"></i>Home Page Banner Video', Url::home() . 'homebannervideo', ['homebannervideo']); ?></li> 
                     <li><?php echo Html::a('<i class="fa fa-file-video-o"></i> Home Page Videos', Url::home() . 'homepagevideo', ['homevideo']); ?></li>
                    <!--  manage Users -->
                    <li><?php echo Html::a('<i class="fa fa-users"></i>Users', Url::home() . 'users', ['users']); ?></li> 
                     <li>
                        <a style="cursor:pointer"><i class="fa fa-globe" aria-hidden="true"></i> Locations <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <!--  Country -->
                            <li>
                                <?php echo Html::a('<i class="fa fa-map-marker"></i> Main Cities ', Url::home() . 'maincity', ['maincity']); ?>
                            </li>
                            <!--  State -->
                            <li>
                                <?php echo Html::a('<i class="fa fa-map-marker"></i> Sub Cities ', Url::home() . 'subcity', ['subcity']); ?>
                            </li>          
                            <!--City-->        
                        </ul>
                    </li>
                    <li><?php echo Html::a('<i class="fa fa-money"></i> Seasons', Url::home() . 'seasons', ['seasons']); ?></li>
                     <li><?php echo Html::a('<i class="fa fa-user"></i> Contestants', Url::home() . 'contestant', ['contestant']); ?></li>
                    <li><?php echo Html::a('<i class="fa fa-files-o"></i>Posts', Url::home() . 'posts', ['posts']); ?></li>
                    <li><?php echo Html::a('<i class="fa fa-comments"></i>Comments', Url::home() . 'comments', ['comments']); ?></li>
                    <li><?php echo Html::a('<i class="fa fa-money"></i>Faq', Url::home() . 'faq', ['faq']); ?></li>
                    <!--  Page -->
                    <li><?php echo Html::a('<i class="fa fa-files-o"></i> Pages', Url::home() . 'page', ['page']); ?></li>
                    <?php } ?>					
                </ul>
            </div>
        </div>
    </div>
</div>
