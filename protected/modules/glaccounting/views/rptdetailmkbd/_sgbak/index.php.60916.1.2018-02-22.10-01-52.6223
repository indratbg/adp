<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Detail Report MKBD' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Detail Report MKBD',
		'itemOptions' => array('style' => 'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	array(
		'label' => 'List',
		'url' => array('index'),
		'icon' => 'list',
		'itemOptions' => array(
			'class' => 'active',
			'style' => 'float:right'
		)
	),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'importTransaction-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>

<?php echo $form->errorSummary($model); ?>
<?php AHelper::showFlash($this)
?>
<br />
<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model, 'rpt_date', array(
				'prepend' => '<i class="icon-calendar"></i>',
				'placeholder' => 'dd/mm/yyyy',
				'class' => 'tdate span8',
				'options' => array('format' => 'dd/mm/yyyy')
			));
			?>
		</div>
		<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => 'Print',
				'id' => 'btnPrint'
			));
			?>
		</div>
		<div class="span2">
			<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
		</div>
		<div class="span2">
			<button  type="button" class="btn btn-block btn-primary"  data-toggle="collapse" data-target="#report_option">
				<strong>Show Option</strong>
			</button>
		</div>
	</div>
</div>
<br />
<!-- <button  type="button" class="btn btn-block btn-inverse"  data-toggle="collapse" data-target="#report_option">
	<strong>Report Option</strong>
</button> -->
<br/>
<div id="report_option" class="collapse">
	<div class="row-fluid">
		<div class="span6">

			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="0" <?php echo $model->rpt_type == '0' ? 'checked' : ''; ?>
					/>
					&nbsp;TRANSAKSI BELUM T3
				</div>

				<div class="span6">
					vd51.34/vd52.133
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="1" <?php echo $model->rpt_type == '1' ? 'checked' : ''; ?>
					/>
					&nbsp;SALDO DEBIT (REGULAR)
				</div>

				<div class="span6">
					vd51.103
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="2" <?php echo $model->rpt_type == '2' ? 'checked' : ''; ?>
					/>
					&nbsp;SALDO DEBIT (MARGIN)
				</div>

				<div class="span6">
					vd51.35
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="3" <?php echo $model->rpt_type == '3' ? 'checked' : ''; ?>
					/>
					&nbsp;SALDO KREDIT
				</div>
				<div class="span6">
					vd52.159
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="4" <?php echo $model->rpt_type == '4' ? 'checked' : ''; ?>
					/>
					&nbsp;KPEI
				</div>
				<div class="span6">
					vd5130/VD52.129
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="5" <?php echo $model->rpt_type == '5' ? 'checked' : ''; ?>
					/>
					&nbsp;BROKER LAIN
				</div>
				<div class="span6">
					vd51.43/vd52.141
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="6" <?php echo $model->rpt_type == '6' ? 'checked' : ''; ?>
					/>
					&nbsp;PORTOFOLIO STOCK
				</div>
				<div class="span6">
					vd51.70 - 80
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="7" <?php echo $model->rpt_type == '7' ? 'checked' : ''; ?>
					/>
					&nbsp;PORTO OBLIGASI KORPORASI
				</div>
				<div class="span6">
					vd51.65 - 69
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="8" <?php echo $model->rpt_type == '8' ? 'checked' : ''; ?>
					/>
					&nbsp;PORTO Surat Berharga Negara
				</div>
				<div class="span6">
					vd51.61 - 63
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="" <?php echo $model->rpt_type == '9' ? 'checked' : ''; ?>
					disabled="true"/>
					&nbsp;DEPOSITO
				</div>
				<div class="span6">
					vd51.16 - 20
				</div>
			</div>
			

		</div>
		<div class="span6">
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="10" <?php echo $model->rpt_type == '10' ? 'checked' : ''; ?>
					/>
					&nbsp;REPO
				</div>
				<div class="span6">
					vd51.27/VD52.127
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="11" <?php echo $model->rpt_type == '11' ? 'checked' : ''; ?>
					/>
					&nbsp;REKSADANA
				</div>
				<div class="span6">
					vd51.65 - 69
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="12" <?php echo $model->rpt_type == '12' ? 'checked' : ''; ?>
					/>
					&nbsp;VD51
				</div>
				<div class="span6">
					vd51 (selain yang diatas)
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="13" <?php echo $model->rpt_type == '13' ? 'checked' : ''; ?>
					/>
					&nbsp;VD52
				</div>
				<div class="span6">
					vd52 (selain yang diatas)
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="14" <?php echo $model->rpt_type == '14' ? 'checked' : ''; ?>
					/>
					&nbsp;RISIKO MARGIN
				</div>
				<div class="span6">
					vd53.28 - 29
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="15" <?php echo $model->rpt_type == '15' ? 'checked' : ''; ?>
					/>
					&nbsp;PENJAMINAN EMISI EFEK
				</div>
				<div class="span6">
					vd53.15 - 17
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="16" <?php echo $model->rpt_type == '16' ? 'checked' : ''; ?>
					/>
					&nbsp;vd56.10
				</div>
				<div class="span6">
					vd56.10 dana nasabah
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="17" <?php echo $model->rpt_type == '17' ? 'checked' : ''; ?>
					/>
					&nbsp;vd56.20
				</div>
				<div class="span6">
					vd56.20 dana nasabah
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="18" <?php echo $model->rpt_type == '18' ? 'checked' : ''; ?>
					/>
					&nbsp;vd56.17-19
				</div>
				<div class="span6">
					vd56.17-19 dana perusahaan efek
				</div>
			</div>
			<!-- <div class="control-group">
				<div class="span6">
					<input type="radio" name="Rptdetailmkbd[rpt_type]" value="19" <?php echo $model->rpt_type == '19' ? 'checked' : ''; ?>
					disabled="true"/>
					&nbsp;MAP GL ACCOUNT
				</div>
				<div class="span6">
					Account code & baris di MKBD
				</div>
			</div> -->
		</div>

	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%;"></iframe>

<?php $this->endWidget(); ?>
<script>
		var url_xls = '<?php echo $url_xls ?>';

		init();
		function init()
		{
			if(url_xls=='')
			{
				$('#btn_xls').attr('disabled',true);
			}
		}
</script>	