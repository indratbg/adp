<?php
$this->breadcrumbs=array(
	'Tbondprices'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tbondprice', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	//array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tbondprice-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Bond Market Price</h1>
<?php AHelper::applyFormatting() ?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tbondprice-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->datePickerRow($model,'price_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','value'=>$pricedt,'name'=>'pricedt','id'=>'pricedt','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Retrieve',
			'id'=>'retbtn'
		)); ?>
		&emsp;
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
			'label'=>'Duplicate',
			'id'=>'dupbtn'
		)); ?>
	</div>
	<?php if($model1){
		foreach($model1 as $m1){
			echo $form->errorSummary($m1);
		}
		
	} ?>
	<?php if($model1 && isset($model1)){
			$j = 0;?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-data" class="tablebond items table table-striped table-bordered table-condensed">
        <thead>
        	<th><input type="checkbox" id="checkall"value="<?php echo $j;?>" /></th>
            <th>Date</th>
            <th>Bond</th>
            <th>Price</th>
            <th>Yield</th>
            <th>Rating</th>
        </thead>
       	<tbody>
		<?php foreach($model1 as $row){?>
			<tr>
				<td><input type="checkbox" id="updbondflag<?php echo $j;?>" class="bondflag" onclick="checkBond();" value="<?php echo $j;?>" /></td>
				<td><?php echo $form->textField($row,'price_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice0_price_dt'.$j.'','name'=>'Tbondprice0['.$j.'][price_dt]')); ?></td>				
				<td><?php echo $form->dropDownList($row,'bond_cd',Chtml::listData($dropdownbond,'bond_cd', 'bond_desc'), array('class'=>'bondcd span','disabled'=>'disabled','id'=>'Tbondprice0_bond_cd'.$j.'','name'=>'Tbondprice0['.$j.'][bond_cd]')); ?></td>
				<td><?php echo $form->textField($row,'price',array('style'=>'text-align: right;','class'=>'price span tnumber','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice0_price'.$j.'','name'=>'Tbondprice0['.$j.'][price]')); ?></td>
				<td><?php echo $form->textField($row,'yield',array('style'=>'text-align: right;','class'=>'yield span tnumber','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice0_yield'.$j.'','name'=>'Tbondprice0['.$j.'][yield]')); ?></td>
				<td><?php echo $form->textField($row,'bond_rate',array('class'=>'bondrate span','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice0_bond_rate'.$j.'','name'=>'Tbondprice0['.$j.'][bond_rate]')); ?></td>
			</tr>
		<?php $j++;}?>
		</tbody>
	</table>
	<?php }?>
	<h4 id="duplabel" style="display: none;">Duplicated Data</h4>
	<?php if($modelInsert){
		foreach($modelInsert as $m2){
			echo $form->errorSummary($m2);
		}
		
	} ?>
	<?php if($modelInsert && isset($modelInsert)){
			$j = 0;?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-data1" class="tablebond1 items table table-striped table-bordered table-condensed">
        <thead>
        	<th><input type="checkbox" id="checkall"value="<?php echo $j;?>" /></th>
            <th>Date</th>
            <th>Bond</th>
            <th>Price</th>
            <th>Yield</th>
            <th>Rating</th>
        </thead>
       	<tbody>
		<?php foreach($model2 as $row){?>
			<tr>
				<td><input type="checkbox" id="insbondflag<?php echo $j;?>" class="bondflag1" onclick="checkBond1();" value="<?php echo $j;?>" /></td>
				<td><?php echo $form->textField($row,'price_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice1_price_dt'.$j.'','name'=>'Tbondprice1['.$j.'][price_dt]')); ?></td>				
				<td><?php echo $form->dropDownList($row,'bond_cd',Chtml::listData($dropdownbond,'bond_cd', 'bond_desc'), array('class'=>'bondcd span','disabled'=>'disabled','id'=>'Tbondprice1_bond_cd'.$j.'','name'=>'Tbondprice1['.$j.'][bond_cd]')); ?></td>
				<td><?php echo $form->textField($row,'price',array('style'=>'text-align: right;','class'=>'price span tnumber','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice1_price'.$j.'','name'=>'Tbondprice1['.$j.'][price]')); ?></td>
				<td><?php echo $form->textField($row,'yield',array('style'=>'text-align: right;','class'=>'yield span tnumber','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice1_yield'.$j.'','name'=>'Tbondprice1['.$j.'][yield]')); ?></td>
				<td><?php echo $form->textField($row,'bond_rate',array('class'=>'bondrate span','maxlength'=>12,'disabled'=>'disabled','id'=>'Tbondprice1_bond_rate'.$j.'','name'=>'Tbondprice1['.$j.'][bond_rate]')); ?></td>
			</tr>
		<?php $j++;}?>
		</tbody>
	</table>
	<?php }?>
	<input type="hidden" id="updateflg" name="updateflg" />
	<input type="hidden" id="insertflg" name="insertflg" />
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Save Checked',
		'id'=>'savebtn'
	)); ?>

<?php $this->endWidget(); ?>

<script>
	<?php if($model1 && isset($model1)){?>
		<?php for($n=0;$n<count($model1);$n++){?>
			$("#Tbondprice0_price_dt<?php echo $n;?>").datepicker({format : "dd/mm/yyyy"});
		<?php }?>
		$("#dupbtn").attr('disabled',false);
	<?php }else{?>
		$("#savebtn").hide();
		$("#dupbtn").attr('disabled','disabled');
	<?php }?>
	
	//returning values when error
	//------------------------------------
	<?php if($modelInsert){?>
		$("#dupbtn").attr('disabled','disabled');
		$("#table-data1").find(".tdate").each(function(){
			$(this).datepicker({format : "dd/mm/yyyy"});
			$(this).val("");
			$(this).attr('placeholder','dd/mm/yyyy');
		})
		<?php if($insindex){
			foreach ($insindex as $ins){
		?>
			$("#Tbondprice1_price_dt<?php echo $ins;?>").val("<?php echo $modelInsert[$ins]->price_dt;?>");
			$("#Tbondprice1_bond_cd<?php echo $ins;?>").val("<?php echo $modelInsert[$ins]->bond_cd;?>");
			$("#Tbondprice1_price<?php echo $ins;?>").val("<?php echo $modelInsert[$ins]->price;?>");
			$("#Tbondprice1_yield<?php echo $ins;?>").val("<?php echo $modelInsert[$ins]->yield;?>");
			$("#Tbondprice1_bond_rate<?php echo $ins;?>").val("<?php echo $modelInsert[$ins]->bond_rate;?>");
			$("#insbondflag<?php echo $ins?>").prop('checked',true);
		<?php
			}?>
			checkBond1();
		<?php	
		}
	}?>
	<?php if($updindex){
		foreach ($updindex as $upd){
	?>
		$("#updbondflag<?php echo $upd?>").prop('checked',true);
	<?php } ?>
		checkBond();
	<?php } ?>
	//------------------------------------
	
	checkSave();
	
	$("#checkall").click(function(){
		if(this.checked) { // check select status
            $('.bondflag').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes
            });
        }else{
            $('.bondflag').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes                      
            });
        }
        checkBond();
	});
	
	$("#retbtn").click(function(){
		$("#updateflg").val("");
		$("#insertflg").val("");
		return true;
	})
	
	$("#dupbtn").click(function(){
		duplicate();
	})
	
	function duplicate(){
		$("#duplabel").show();
		$(".tablebond").clone().insertAfter("#insertflg");
		var tablecnt = 0;
		$(".tablebond").each(function(){
			$(this).attr('id',this.id+tablecnt);
			tablecnt++;
		})
		var contentcnt = 0;
		$("#table-data1").find(".tdate").each(function(){
			$(this).datepicker({format : "dd/mm/yyyy"});
			$(this).val("");
			$(this).attr('placeholder','dd/mm/yyyy');
			$(this).attr('name','Tbondprice1['+contentcnt+'][price_dt]');
			$(this).attr('id','Tbondprice1_price_dt'+contentcnt);
			$(this).attr('disabled','disabled');
			contentcnt++;	
		})
		contentcnt = 0;
		$("#table-data1").find(".bondcd").each(function(){
			$(this).attr('name','Tbondprice1['+contentcnt+'][bond_cd]');
			$(this).attr('id','Tbondprice1_bond_cd'+contentcnt);
			$(this).attr('disabled','disabled');
			contentcnt++;
		})
		contentcnt = 0;
		$("#table-data1").find(".price").each(function(){
			$(this).attr('name','Tbondprice1['+contentcnt+'][price]');
			$(this).attr('id','Tbondprice1_price'+contentcnt);
			$(this).attr('disabled','disabled');
			contentcnt++;	
		})
		contentcnt = 0;
		$("#table-data1").find(".yield").each(function(){
			$(this).attr('name','Tbondprice1['+contentcnt+'][yield]');
			$(this).attr('id','Tbondprice1_yield'+contentcnt);
			$(this).attr('disabled','disabled');
			contentcnt++;	
		})
		contentcnt = 0;
		$("#table-data1").find(".bondrate").each(function(){
			$(this).attr('name','Tbondprice1['+contentcnt+'][bond_rate]');
			$(this).attr('id','Tbondprice1_bond_rate'+contentcnt);
			$(this).attr('disabled','disabled');
			contentcnt++;	
		})
		$("#table-data1").find("#checkall").each(function(){
			$(this).attr('id',this.id+1);
			this.checked = false;
			$(this).click(function(){
				if(this.checked) { // check select status
		            $('.bondflag1').each(function() { //loop through each checkbox
		                this.checked = true;  //select all checkboxes
		            });
		        }else{
		            $('.bondflag1').each(function() { //loop through each checkbox
		                this.checked = false; //deselect all checkboxes                      
		            });
		        }
		        checkBond1();
			});
		});
		contentcnt = 0;
		$("#table-data1").find(".bondflag").each(function(){
			$(this).attr('class','bondflag1');
			$(this).attr('id','insbondflag'+contentcnt);
			this.checked = false;
			contentcnt++;
		});
		contentcnt = 0;
		$("#table-data1").find(".bondflag1").each(function(){
			$(this).attr('onclick','checkBond1();');
			contentcnt++;	
		})
		$("#dupbtn").attr('disabled','disabled');
	}
	
	function checkBond(){ //function for checkboxlist
		var h = '';
		$('input[class="bondflag"]').serialize();
		$('input[class="bondflag"]').each(function(){
			$('#Tbondprice0_price_dt'+this.value).attr('disabled','disabled');
			$('#Tbondprice0_bond_cd'+this.value).attr('disabled','disabled');
			$('#Tbondprice0_price'+this.value).attr('disabled','disabled');
			$('#Tbondprice0_yield'+this.value).attr('disabled','disabled');
			$('#Tbondprice0_bond_rate'+this.value).attr('disabled','disabled');
		})
		$('input[class="bondflag"]:checked').serialize();
		$('input[class="bondflag"]:checked').each(function(){
			h = h+this.value+' ';
			$('#Tbondprice0_price_dt'+this.value).attr('disabled',false);
			$('#Tbondprice0_bond_cd'+this.value).attr('disabled',false);
			$('#Tbondprice0_price'+this.value).attr('disabled',false);
			$('#Tbondprice0_yield'+this.value).attr('disabled',false);
			$('#Tbondprice0_bond_rate'+this.value).attr('disabled',false);
			
		})
		h = $.trim(h);
		$("#updateflg").val(h);
		checkSave();
	}
	
	function checkBond1(){ //function for checkboxlist
		var h = '';
		$('input[class="bondflag1"]').serialize();
		$('input[class="bondflag1"]').each(function(){
			h = h+this.value+' ';
			$('#Tbondprice1_price_dt'+this.value).attr('disabled','disabled');
			$('#Tbondprice1_bond_cd'+this.value).attr('disabled','disabled');
			$('#Tbondprice1_price'+this.value).attr('disabled','disabled');
			$('#Tbondprice1_yield'+this.value).attr('disabled','disabled');
			$('#Tbondprice1_bond_rate'+this.value).attr('disabled','disabled');
		})
		$('input[class="bondflag1"]:checked').serialize();
		$('input[class="bondflag1"]:checked').each(function(){
			h = h+this.value+' ';
			$('#Tbondprice1_price_dt'+this.value).attr('disabled',false);
			$('#Tbondprice1_bond_cd'+this.value).attr('disabled',false);
			$('#Tbondprice1_price'+this.value).attr('disabled',false);
			$('#Tbondprice1_yield'+this.value).attr('disabled',false);
			$('#Tbondprice1_bond_rate'+this.value).attr('disabled',false);
		})
		h = $.trim(h);
		$("#insertflg").val(h);
		checkSave();
	}
	
	function checkSave(){
		var a = '';
		$('input[class="bondflag"]:checked').serialize();
		$('input[class="bondflag"]:checked').each(function(){
			a = a+this.value+' ';
		})
		a = $.trim(a);
		
		var b = '';
		$('input[class="bondflag1"]:checked').serialize();
		$('input[class="bondflag1"]:checked').each(function(){
			b = b+this.value+' ';
		})
		b = $.trim(b);
		
		if(((a == "") && (b == "")) || ((a == null) && (b == null))){
			$("#savebtn").attr('disabled','disabled');
		}else{
			$("#savebtn").attr('disabled',false);
		}
		
	}
</script>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
