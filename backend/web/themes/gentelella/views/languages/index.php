<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Languages';
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>

        </div>
        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        <?php if (Yii::$app->session->getFlash('item')): ?>
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>    
                        <?php echo Yii::$app->session->getFlash('item'); ?>
                        </div>
                        <?php endif; ?>

                        <!--<h1><?= Html::encode($this->title) ?></h1>-->
                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <p>
                            <?= Html::a('<i class="fa fa-plus"></i> Add New', ['add'], ['class' => 'btn btn-success']) ?>
                            
                            <?= Html::button('Apply Filter', ['class' => 'btn btn-primary','id'=>'btnfilterApply','style'=>'float:right']) ?>
                            <?= Html::button('Reset Filter', ['class' => 'btn btn-primary','id'=>'resetFilter','style'=>'float:right']) ?>
                        </p>
                        <?php Pjax::begin(['id' => 'PjaxLanguage', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]); ?>
                        <?= GridView::widget([
                            'id' => 'grid-container',
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'name',
                                'short_name',
                                ['attribute' => 'status',
                                 'value' =>function($dataProvider){                                      if($dataProvider->status=='1')
                                    { return 'Active'; }
                                    else if($dataProvider->status== '0' )
                                    { return 'Inactive'; }
                                 
                                 },
                                 'filter' => Html::activeDropDownList($searchModel, 'status', array('1' => 'Active', '0' => 'Inactive'),['class'=>'form-control','prompt' => 'Status']),
                                 
                                ],
                                [
                                'attribute'=>'dateCreated',
                                'value'=>'dateCreated',
                                'format'=>'date',
                                'filterOptions' => ['id' => 'tdDateCreated'],							
				],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',	
                                    'template' => '{update} {delete} {status}',
                                    'buttons' => [
                                        'status' => function ($url,$dataProvider) {
                                        return Html::dropDownList('action',$dataProvider->status,[''=>'Status','1'=>'Active','0'=>'Inactive'],['class'=>'dropdown','title' => 'Change Status','onchange' =>'updateStatus(this,'.$dataProvider->id.')']);
                                        },
                                    ],

				],
                            ],
                        ]);
                        
                        Pjax::end();
                        ?>

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

<!-- daterangepicker -->
<script type="text/javascript" src="<?php echo Url::home(); ?>/themes/gentelella/js/moment.min2.js"></script>
<script type="text/javascript" src="<?php echo Url::Home(); ?>/themes/gentelella/js/datepicker/daterangepicker.js"></script>
        
<script type="text/javascript">
		
    $(document).ready(function () {

        $('#tdDateCreated input').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
        });
        
        $('.x_title').on('click', '#resetFilter', function(){
            $('.filters').find('input').val('');
            $('.filters').find('select option:eq(0)').prop('selected', true);
            $("#grid-container").yiiGridView("applyFilter");
        });

        $('.x_title').on('click', '#btnfilterApply', function(){
            $("#grid-container").yiiGridView("applyFilter");
        });

   });	
		
    $(document).on('pjax:complete', function() {
        $('#tdDateCreated input').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
        });
    });
	
    function updateStatus(dis,id)
    {
        var post = {'UpdateLanguage':{'status':dis.value}};	
        if(dis.value && dis.value != '') 
        {
            $.ajax({
                url:'<?php echo Url::home(); ?>languages/update/'+id,
                type:'post',
                data:post,
                success:function(response){
                        window.location.reload();
                }

            });	
        }
    }
		
</script>
