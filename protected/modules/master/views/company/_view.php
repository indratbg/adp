<?php
/* @var $this CompanyController */
/* @var $data Company */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kd_broker')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kd_broker), array('view', 'id'=>$data->kd_broker)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_prsh')); ?>:</b>
	<?php echo CHtml::encode($data->nama_prsh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('round')); ?>:</b>
	<?php echo CHtml::encode($data->round); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit_mkbd')); ?>:</b>
	<?php echo CHtml::encode($data->limit_mkbd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jsx_listed')); ?>:</b>
	<?php echo CHtml::encode($data->jsx_listed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ssx_listed')); ?>:</b>
	<?php echo CHtml::encode($data->ssx_listed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kom_fee_pct')); ?>:</b>
	<?php echo CHtml::encode($data->kom_fee_pct); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('vat_pct')); ?>:</b>
	<?php echo CHtml::encode($data->vat_pct); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pph_pct')); ?>:</b>
	<?php echo CHtml::encode($data->pph_pct); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('levy_pct')); ?>:</b>
	<?php echo CHtml::encode($data->levy_pct); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('min_fee_flag')); ?>:</b>
	<?php echo CHtml::encode($data->min_fee_flag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('min_value')); ?>:</b>
	<?php echo CHtml::encode($data->min_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('min_charge')); ?>:</b>
	<?php echo CHtml::encode($data->min_charge); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brok_nom_asing')); ?>:</b>
	<?php echo CHtml::encode($data->brok_nom_asing); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brok_nom_lokal')); ?>:</b>
	<?php echo CHtml::encode($data->brok_nom_lokal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenis_ijin1')); ?>:</b>
	<?php echo CHtml::encode($data->jenis_ijin1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_ijin1')); ?>:</b>
	<?php echo CHtml::encode($data->no_ijin1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_ijin1')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_ijin1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenis_ijin2')); ?>:</b>
	<?php echo CHtml::encode($data->jenis_ijin2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_ijin2')); ?>:</b>
	<?php echo CHtml::encode($data->no_ijin2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_ijin2')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_ijin2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenis_ijin3')); ?>:</b>
	<?php echo CHtml::encode($data->jenis_ijin3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_ijin3')); ?>:</b>
	<?php echo CHtml::encode($data->no_ijin3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_ijin3')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_ijin3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenis_ijin4')); ?>:</b>
	<?php echo CHtml::encode($data->jenis_ijin4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_ijin4')); ?>:</b>
	<?php echo CHtml::encode($data->no_ijin4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_ijin4')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_ijin4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenis_ijin5')); ?>:</b>
	<?php echo CHtml::encode($data->jenis_ijin5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_ijin5')); ?>:</b>
	<?php echo CHtml::encode($data->no_ijin5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_ijin5')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_ijin5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cre_dt')); ?>:</b>
	<?php echo CHtml::encode($data->cre_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upd_dt')); ?>:</b>
	<?php echo CHtml::encode($data->upd_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_1')); ?>:</b>
	<?php echo CHtml::encode($data->other_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_2')); ?>:</b>
	<?php echo CHtml::encode($data->other_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('def_addr_1')); ?>:</b>
	<?php echo CHtml::encode($data->def_addr_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('def_addr_2')); ?>:</b>
	<?php echo CHtml::encode($data->def_addr_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('def_addr_3')); ?>:</b>
	<?php echo CHtml::encode($data->def_addr_3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_cd')); ?>:</b>
	<?php echo CHtml::encode($data->post_cd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_pers')); ?>:</b>
	<?php echo CHtml::encode($data->contact_pers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone_num')); ?>:</b>
	<?php echo CHtml::encode($data->phone_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hp_num')); ?>:</b>
	<?php echo CHtml::encode($data->hp_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fax_num')); ?>:</b>
	<?php echo CHtml::encode($data->fax_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('e_mail1')); ?>:</b>
	<?php echo CHtml::encode($data->e_mail1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('con_pers_title')); ?>:</b>
	<?php echo CHtml::encode($data->con_pers_title); ?>
	<br />

	*/ ?>

</div>