<style>
	/*h5{border-bottom: 1px solid grey;}*/
</style>

<?php
$this->breadcrumbs=array(
	'Contract Avg Price'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Cancellation','url'=>Yii::app()->request->baseUrl.'?r=contracting/cancelcontravgprice/index','icon'=>'list'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/contractavgprice/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tcontracts-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Contract Correction Based on Average Price</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'tcontracts-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
    
    'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'button',
				'type' => 'secondary',
				'size' => 'small',
				'id'	=>'btnUpdateChecked',
				'icon'=> 'ok',
				'label' => 'Update Checked',
				'click' => 'js:function(checked_element){
						var temp = new Array();
						var contrnum = new Array();
						var mrkttype = "blank";
						var stkcd = "blank";
						var belijual = "blank";
						var buybrok = "blank";
						var sellbrok = "blank";
						var temp2 = "";
						var cstr = "";
						var ismtvalid = true;
						var isscvalid = true;
						var isbjvalid = true;
						var isbbvalid = true;
						var issbvalid = true;
						for(var i =0;i<checked_element.length;i++){
							temp[i] = i;
							cstr = checked_element[i].value;
							contrnum[i] = cstr.substring(0,cstr.indexOf("#MT="));
							if(mrkttype == "blank"){
								mrkttype = cstr.substring(cstr.indexOf("#MT=")+4,cstr.indexOf("#BJ="));
							}else{
								temp2 = cstr.substring(cstr.indexOf("#MT=")+4,cstr.indexOf("#BJ="));
								if(mrkttype != temp2){
									//ismtvalid = false;
								}
							}
							
							if(ismtvalid == true){
								if(belijual == "blank"){
									belijual = cstr.substring(cstr.indexOf("#BJ=")+4,cstr.indexOf("#SC="));
								}else{
									temp2 = cstr.substring(cstr.indexOf("#BJ=")+4,cstr.indexOf("#SC="));
									if(belijual != temp2){
										isbjvalid = false;
									}
								}
							}
							
							if(isbjvalid == true){
								if(stkcd == "blank"){
									stkcd = cstr.substring(cstr.indexOf("#SC=")+4,cstr.indexOf("#BB="));
								}else{
									temp2 = cstr.substring(cstr.indexOf("#SC=")+4,cstr.indexOf("#BB="));
									if(stkcd != temp2){
										isscvalid = false;
									}
								}
							}
							
							if(mrkttype == "NG"){
								if(isscvalid == true){
									if(buybrok == "blank"){
										buybrok = cstr.substring(cstr.indexOf("#BB=")+4,cstr.indexOf("#SB="));
									}else{
										temp2 = cstr.substring(cstr.indexOf("#BB=")+4,cstr.indexOf("#SB="));
										if(buybrok != temp2){
											isbbvalid = false;
										}
									}
								}
								
								if(isbbvalid == true){
									if(sellbrok == "blank"){
										sellbrok = cstr.substring(cstr.indexOf("#SB=")+4);
									}else{
										temp2 = cstr.substring(cstr.indexOf("#SB=")+4);
										if(sellbrok != temp2){
											issbvalid = false;
										}
									}
								}
							}
							
							if((ismtvalid && isbjvalid && isscvalid && isbbvalid && issbvalid) == false) break;
						}
						if((ismtvalid && isbjvalid && isscvalid && isbbvalid && issbvalid) == true){
							window.location.href = "/insistpro/index.php?r=contracting/contractavgprice/update/id/"+contrnum;
						}else{
							if(ismtvalid == false){
								alert("Please choose transactions with similar Market Types!");
								alert(mrkttype);
							}else if(isbjvalid == false){
								alert("Please choose transactions with similar Transaction Types! (Beli / Jual)");
							}else if(isscvalid == false){
								alert("Please choose transactions with similar Stocks!");
							}else if(isbbvalid == false){
								alert("NG transactions must be from similar Buy Brokers!");
							}else{
								alert("NG transactions must be to similar Sell Brokers");
							}
						}
					}'
			)
		),
		'checkBoxColumnConfig' => array(
		    'name' => 'id',
		    'value'=> '$data->contr_num.\'#MT=\'.$data->mrkt_type.\'#BJ=\'.$data->belijual.\'#SC=\'.$data->stk_cd.\'#BB=\'.$data->buy_broker_cd.\'#SB=\'.$data->sell_broker_cd'
		),
	),
	'columns'=>array(
		array('name'=>'contr_dt','type'=>'date'),
		'client_cd',
		array('name'=>'belijual','value'=>'AConstant::$contract_belijual[$data->belijual]'),
		'stk_cd',
		'mrkt_type',
		array('name'=>'qty','value'=>'number_format($data->qty,0)','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'price','htmlOptions'=>array('style'=>'text-align:right')),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("contracting/contractavgprice/update", array("id" => $data->contr_num))',
			'template'=>'{update}',
		),
	),
)); ?>
