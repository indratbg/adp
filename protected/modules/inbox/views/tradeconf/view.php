<?php
$this->breadcrumbs=array(
	'Trade Confirmation Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Trade Confirmation Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Trade Confirmation Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('Ttcdoc-grid', {
				data: $(this).serialize()
			});
			return false;
		});
		");
?>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/template/_searchtcdoc',array(
	'modeltc'=>$modeltc,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'Ttcdoc-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$modeltc->search(),
	'filter'=>$modeltc,
    'filterPosition'=>'',
	'columns'=>array(
	array('name'=>'tc_date','type'=>'date'),
	'client_cd',
	'client_name',
	
	
		array(
		
			'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{english}{indonesia}',
			'buttons'=>array(
		        'english'=>array(
		        	'url' => 'Yii::app()->createUrl("inbox/tradeconf/view&id=".$data->update_seq."&client_cd=".$data->client_cd."&lang=".\'english\')',	
		            'label'=>'English',
		           	'options' => array(  // set all kind of html options in here
				         'style' => 'font-weight: bold;margin-right:10px',
				       	//'target'=>'_blank',
				       
				    ),
		         ),
		         
		        'indonesia'=>array(
		        	'url' => 'Yii::app()->createUrl("inbox/tradeconf/view&id=".$data->update_seq."&client_cd=".$data->client_cd."&lang=".\'indo\')',	
		            'label'=>'Indonesia',
		           	'options' => array(  // set all kind of html options in here
				         'style' => 'font-weight: bold',
				     //  	'target'=>'_blank'
				    ),
				),
	),
	'htmlOptions'=>array('style'=>'width:90px'),
	),
	
	),
)); ?>
<h4>Approval Attributes</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'status','value'=>AConstant::$inbox_stat[$model->status]),
				array('name'=>'update_date','type'=>'datetime'),
				'user_id',
				'ip_address',
				array('name'=>'cancel_reason','type'=>'raw','value'=>nl2br($model->cancel_reason)),
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'approved_status','value'=>AConstant::$inbox_app_stat[$model->approved_status]),
				array('name'=>'approved_date','type'=>'datetime'),
				'approved_user_id',
				array('name'=>'reject_reason','type'=>'raw','value'=>nl2br($model->reject_reason)),
			),
		)); ?>
	</div>
</div>

<?php if($model->approved_status == AConstant::INBOX_APP_STAT_ENTRY): ?>	
	<br/>
	<div style="text-align:right;">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'label'=>'Preview All English TC',
			'url'=>Yii::app()->request->baseUrl.'?r=inbox/tradeconf/view&id='.$modeltc->update_seq.'&client_cd=%&lang=english',
			
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'label'=>'Preview All Indonesian TC',
			'url'=>Yii::app()->request->baseUrl.'?r=inbox/tradeconf/view&id='.$modeltc->update_seq.'&client_cd=%&lang=indo',
		)); ?>
		&emsp;&emsp;&emsp;&emsp;
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'ok',
			'url'=>$this->createUrl('approve',array('id'=>$model->primaryKey)),
			'label'=>'Approve',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'remove',
			'url'=>$this->createUrl('reject',array('id'=>$model->primaryKey)),
			'htmlOptions'=>array('class'=>'reject-inbox'),
			'label'=>'Reject',
		)); ?>
	</div>
	<?php 
		$param  = array(array('class'=>'reject-inbox','title'=>'Reject Reason','url'=>'AjxPopReject','urlparam'=>array('id'=>$model->primaryKey,'label'=>false)));
	  	AHelper::popupwindow($this, 600, 500, $param);
	?>
<?php endif; ?>

<script>
	var url = '<?php echo $url; ?>';
	
	init();
	function init()
	{
		if(url !='')
		{
		 var myWindow = window.open('<?php echo $url;?>','_blank');
		 myWindow.document.title = 'Trade Confirmation';
		}
	}
	
	
</script>