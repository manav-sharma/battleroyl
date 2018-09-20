<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Subcity;
$parentCity = new Subcity();
$val = $parentCity->parentcityname($model->main_city_id);
//echo '<pre>'; print_r($val);

/* @var $this yii\web\View */
/* @var $model common\models\State */

$this->title = $model->sub_city_name;
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $this->title; ?></h3>
            </div>

        </div>
        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" >
                    <div class="x_title">

                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->sub_city_id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->sub_city_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
								[
									'attribute' => 'sub_city_id',
									'label' => 'Sub City ID',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'sub_city_name',
									'label' => 'Sub City Name',
									'encodeLabel' => false,
								],
								[	'attribute' => 'parentCity_id',
									'label' => 'Parent City Name',
									'value' => $val['main_city_name'],
								],
						],
                        ]) ?>



                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer content -->
<?php echo $this->render('../includes/footer'); ?>
    <!-- /footer content -->

</div>
<!-- /page content -->
