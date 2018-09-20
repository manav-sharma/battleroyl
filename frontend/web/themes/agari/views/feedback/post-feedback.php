<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('yii','Post Rating');
$this->params['breadcrumbs'][] = $this->title;
?>
<section>
<?php echo $this->render('//common/searchbox'); ?>  
<div class="searchresult">
   <div class="container">
      <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <?php echo $this->render('//common/sidebar'); ?>
            </div>   
			<div class="col-xs-12 col-sm-8 col-md-9">
				
				<?php if (Yii::$app->session->getFlash('item')): ?>
					 <div class="alert alert-grey alert-dismissible">
						   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
						   </button>
						   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
					 </div>														
				<?php endif; ?>	  
				<div class="detailright">
				<?php
					$form = ActiveForm::begin(
						[ 'id' => 'feedback-form', 'method' => 'post',
							'options' => ['class' => 'inner'],
							'fieldConfig' => [
								'template' => "<div class=\"form-group\">\n
									{label}\n<div class=\"val\"><div class=\"controls unrated\">
									<i class='fa fa-2x fa-star' data-val='1'></i>
									<i class='fa fa-2x fa-star' data-val='2'></i>
									<i class='fa fa-2x fa-star' data-val='3'></i> 
									<i class='fa fa-2x fa-star' data-val='4'></i> 
									<i class='fa fa-2x fa-star' data-val='5'></i>
									
									{input}<div class=\"col-lg-10\">
									{error}</div></div></div></div>",
								'labelOptions' => [],
							],
					]);
                ?>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="fullwidth">
                        <?= $form->field($model, 'starrating')->textInput(['type' => 'hidden', 'class' => 'form-control txtstar']) ?>
                    </div>

                    <div class="fullwidth comments">
                    <?= $form->field($model, 'comment')->textArea(['cols' => 0, 'rows' => 5, 'class' => 'form-control textarea textfeild']) ?>
                    </div>
                    
					<div class="fullwidth">
                            <button class="btn btn-primary orangebtn" type="submit"><?php echo Yii::t('yii','Send');?></button>
                    </div>
                     
                </div>

				<div class="col-lg-3 col-md-3 col-sm-3">
						<img width="100%" src="<?php echo Yii::getAlias('@webThemeUrl'); ?>/images/ratings example.jpg" alt="Star Rating Reference">
				</div>    
                <?php ActiveForm::end(); ?>
            
				</div>
            </div>
            </div> <!--row -->
         </div>
      </div>
</section>


<style>
    .comments i.fa-star{display:none;}
    .yellow{color:#f88e49 !important;}
    .mrgntop{margin-top:10px;}
    .unrated i{color:#a7a6a6;}
    #feedback-form{padding-top:14px;}
</style>
<script type="text/javascript">

    $('ul.nav.nav-tabs  a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    (function ($) {
        fakewaffle.responsiveTabs(['xs']);
    })(jQuery);

    $(document).ready(function () {
        $('.controls i.fa-star').on('click', function () {
            var value = parseInt($(this).data('val'));
            prt = $(this).parent();
            $(prt).children('i.fa-star').removeClass('yellow');
            $(prt).children('input.txtstar').val(value);

            for (var i = 1; i <= value; i++)
            {
                $(prt).children('i[data-val="' + i + '"]').addClass('yellow');
            }
            
        });


        $('input.txtstar').each(function () {
            var prt = $(this).parent();
            value = $(this).val();
            $(prt).children('i[data-val="' + value + '"]').click();

        });


    });
</script>
