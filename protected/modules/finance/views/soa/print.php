<?php
$this->breadcrumbs=array(
	'List'=>array('index'),
	'Generate',
);

$this->menu=array(
	array('label'=>'Print Statement of Account ', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Generate', 'url'=>array('generate'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Print', 'url'=>array('print','update_date'=>$model->update_date,'update_seq'=>$model->update_seq),'icon'=>'print','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::applyFormatting() ?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'soa-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<br/>
<!--
	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Transaction Date',array('class'=>'control-label')) ?>
				</div>
				From &nbsp;
				<?php echo $form->textField($model,'from_dt',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3','readonly'=>true, 'value'=>Tmanydetail::reformatDate($model->from_dt))); ?>
				&emsp;
				To &nbsp;
				<?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3','readonly'=>true, 'value'=>Tmanydetail::reformatDate($model->to_dt))); ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Purpose',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'purpose',array('class'=>'purpose span8','label'=>false,'readonly'=>true)) ?>
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'From Client',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'client_from',array('id'=>'clientFrom','class'=>'span2','style'=>'width:85px','readonly'=>true)) ?>
				<?php echo $form->textField($model, 'client_from_susp',array('id'=>'clientFromSusp','class'=>'clientSusp span1','readonly'=>true,'style'=>'width:25px')) ?>
				<?php echo $form->textField($model, 'client_from_branch',array('id'=>'clientFromBranch','class'=>'clientBranch span1','readonly'=>true,'style'=>'width:35px')) ?>
				<?php echo $form->textField($model, 'client_from_name',array('id'=>'clientFromName','class'=>'clientName span5','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'To Client',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'client_to',array('id'=>'clientTo','class'=>'span2','style'=>'width:85px','readonly'=>true)) ?>
				<?php echo $form->textField($model, 'client_to_susp',array('id'=>'clientToSusp','class'=>'clientSusp span1','readonly'=>true,'style'=>'width:25px')) ?>
				<?php echo $form->textField($model, 'client_to_branch',array('id'=>'clientToBranch','class'=>'clientBranch span1','readonly'=>true,'style'=>'width:35px')) ?>
				<?php echo $form->textField($model, 'client_to_name',array('id'=>'clientToName','class'=>'clientName span5','readonly'=>true)) ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'From Branch',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'branch_from',array('id'=>'branchFrom','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($model, 'branch_from_name',array('id'=>'branchFromName','class'=>'branchName span4','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'To Branch',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'branch_to',array('id'=>'branchTo','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($model, 'branch_to_name',array('id'=>'branchToName','class'=>'branchName span4','readonly'=>true)) ?>
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'From Sales',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'sales_from',array('id'=>'salesFrom','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($model, 'sales_from_name',array('id'=>'salesFromName','class'=>'salesName span6','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'To Sales',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'sales_to',array('id'=>'salesTo','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($model, 'sales_to_name',array('id'=>'salesToName','class'=>'salesName span6','readonly'=>true)) ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Online Trading',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'olt_flg',array('class'=>'oltFlg span2','label'=>false,'readonly'=>true)) ?>
			</div>
		</div>
	</div>
-->
<?php $this->endWidget(); ?>

<br/>

<div id="showloading" style="display:none;margin: auto; width: auto; text-align: center;">
	Please wait...<br />
	<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
</div>

<iframe id="iframe" src="<?php echo $url; ?>" style="min-height:600px;"></iframe>

<script>
	$(document).ready(function()
	{
		if('<?php echo $url ?>')
		{
			$("#showloading").show();
			adjustIframeSize();
		}
	});

	$(window).resize(function()
	{
		adjustIframeSize();
	});
	
	$("#iframe").load(function()
	{
		$("#showloading").hide();
	});
	
	function adjustIframeSize()
	{
		$("#iframe").offset({left:-26});
		$("#iframe").css('width',($(window).width()+35));
	}
</script>