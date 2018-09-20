<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $pageTitle;
$this->params['breadcrumbs'][] = $this->title;
?>

<section>
    <?php echo $this->render('//common/searchbox'); ?>
    
    <?php
    if(strtolower($slug) == 'tips' && !empty($image) )
    {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div style="text-align: center; max-width: 100%;" class="sthumb">
                        <img alt="" src="<?= SITE_URL . 'common/uploads/page/'."$image"; ?>">
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    
    <?= $pageContent; ?>
    
</section>