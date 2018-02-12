<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>
<?php
 $query="SELECT DISTINCT lawan_type, p.descrip,  capital_tax_pcn, deb_gl_acct, Cre_gl_acct
		FROM MST_LAWAN_BOND_TRX m ,
		( SELECT prm_cd_2, prm_desc AS descrip
		FROM MST_PARAMETER
		WHERE prm_cd_1 = 'LAWAN') p
		WHERE m.lawan_type = p.prm_cd_2
		ORDER BY 1";

$query1="select cbest_cd || ' - ' ||custody_name  as cbest,cbest_cd
			from mst_bank_custody
			where approved_sts = 'A'
			and sr_custody_cd is not null
			order by 1";
$lawan_type_list=DAO::queryAllSql($query);
$list_cbest_cd=DAO::queryAllSql($query1);


?>
<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'lawan',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'lawan_name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'ctp_cd',array('class'=>'span5','maxlength'=>25)); ?>
	<?php echo $form->dropDownListRow($model,'custody_cbest_cd',CHtml::listData($list_cbest_cd,'cbest_cd', 'cbest'),array('class'=>'span5','maxlength'=>30,'prompt'=>'-Pilih Custody Cbest-')); ?>
	<?php echo $form->dropDownListRow($model,'lawan_type',CHtml::listData($lawan_type_list,'lawan_type', 'descrip'),array('class'=>'span5','maxlength'=>30,'prompt'=>'-Pilih Type-')); ?>
	<?php echo $form->textFieldRow($model,'capital_tax_pcn',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'fax',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'contact_person',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'e_mail',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'deb_gl_acct',array('class'=>'span5','maxlength'=>4)); ?>
	<?php echo $form->textFieldRow($model,'cre_gl_acct',array('class'=>'span5','maxlength'=>4)); ?>
	<?php echo $form->textFieldRow($model,'sl_acct_cd',array('class'=>'span5','maxlength'=>8)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'cre_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'cre_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'cre_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'cre_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'upd_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'upd_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'upd_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'upd_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'upd_by',array('class'=>'span5','maxlength'=>10)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'approved_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'approved_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'approved_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'approved_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'approved_by',array('class'=>'span5','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'approved_sts',array('class'=>'span5','maxlength'=>1)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
