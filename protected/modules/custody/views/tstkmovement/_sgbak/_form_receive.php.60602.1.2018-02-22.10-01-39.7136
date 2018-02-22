<div class="detail" id="detailReceive">
	<table id='tableReceive' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="13%">Client Code</th>
				<th width="25%">Name</th>
				<th width="12%">Stock Code</th>
				<th width="15%">Quantity</th>
				<th width="15%">Price</th>
				<th width="15%"></th>
				<th width="5%">
					<a title="add" onclick="addRow()" style="cursor:pointer"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelReceive as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td class="client">
					<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Tstkreceive['.$x.'][client_cd]','readonly'=>$model->client_cd?'readonly':'','onChange'=>'checkRDI(this)')); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Tstkreceive['.$x.'][client_name]','readonly'=>'readonly')); ?>
				</td>
				<td class="stock">
					<?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Tstkreceive['.$x.'][stk_cd]','readonly'=>$model->stk_cd?'readonly':'')); ?>
				</td>
				<td class="qty">
					<?php echo $form->textField($row,'qty',array('class'=>'span tnumber qtyDetail','name'=>'Tstkreceive['.$x.'][qty]','onChange'=>'countTotal()')); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'price',array('class'=>'span tnumber','name'=>'Tstkreceive['.$x.'][price]')); ?>
				</td>
				<td class="rdi">
					<?php echo $form->textField($row,'rdi_flg',array('class'=>'span','name'=>'Tstkreceive['.$x.'][rdi_flg]','readonly'=>'readonly')); ?>
				</td>
				<td>
					<a title="delete" onclick="deleteRow(this)">
						<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
					</a>
				</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	<input type="hidden" id="receiveCount" name="receiveCount"/>
</div>

<script>
	var receiveCount = <?php echo count($modelReceive) ?>;

	function addRow()
	{
		var client = $("#client_cd_hid").val();
		var clientName = $("#client_name_hid").val();
		var stock = $("#stk_cd_hid").val();
		var price = $("#price_hid").val();
		
		var result = [];
		
		var clientReadonly = false;
		var stockReadonly = false;
		
		if(client)clientReadonly = true;
		if(stock)stockReadonly = true;
		
		if(client && stock && receiveCount > 0)alert("Cannot insert more than 1 row if both client code and stock code are specified");
		else
		{
			$("#tableReceive").find('tbody')
	    		.prepend($('<tr>')
	    			.attr('id','row1')
	    			.append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Tstkreceive[1][client_cd]')
	               		 	.attr('type','text')
	               		 	.val(clientReadonly?client:'')
	               		 	.prop('readonly',clientReadonly?true:false)
	               		 	.change(function()
	               		 	{
	               		 		checkRDI(this);
	               		 	})
	               		 	.autocomplete(
		         			{
		         				source: function (request, response) 
		         				{
							        $.ajax({
							        	'type'		: 'POST',
							        	'url'		: '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
							        	'dataType' 	: 'json',
							        	'data'		:	{'term': request.term},
							        	'success'	: 	function (data) 
							        					{
									           				 response(data);
									           				 result = data;
									    				}
									});
							    },
							    change: function(event,ui)
						        {
						        	$(this).val($(this).val().toUpperCase());
						        	if (ui.item==null)
						            {
							            // Only accept value that matches the items in the autocomplete list	            	
						            	var inputVal = $(this).val();
						            	var match = false;
						            	
						            	$.each(result,function()
						            	{
						            		if(this.value.toUpperCase() == inputVal)
						            		{
						            			match = true;
						            			return false;
						            		}
						            	});
						            	
							            if(!match)
							            {
							            	alert("Client code not found");
							            	$(this).val('');
							            }
							            
							            //$(this).focus();
						            }
						        },
						        open: function() { 
			        				$(this).autocomplete("widget").width(400);
			        				$(this).autocomplete("widget").css('overflow-y','scroll');
                                    $(this).autocomplete("widget").css('max-height','250px');
                                    $(this).autocomplete("widget").css('font-family','courier'); 
			    				}, 
							    minLength: 0
		         			}).focus(function(){     
                                $(this).data("autocomplete").search($(this).val());
                            })
	               		)
	               	).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Tstkreceive[1][client_name]')
	               		 	.attr('type','text')
	               		 	.val(clientReadonly?clientName:'')
	               		 	.prop('readonly',true)
	               		)
	               ).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Tstkreceive[1][stk_cd]')
	               		 	.attr('type','text')
	               		 	.val(stockReadonly?stock:'')
	               		 	.prop('readonly',stockReadonly?true:false)
	               		 	.autocomplete(
		         			{
		         				source: function (request, response) 
		         				{
							        $.ajax({
							        	'type'		: 'POST',
							        	'url'		: '<?php echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
							        	'dataType' 	: 'json',
							        	'data'		:	{'term': request.term},
							        	'success'	: 	function (data) 
							        					{
									           				 response(data);
									           				 result = data;
									    				}
									});
							    },
							    change: function(event,ui)
						        {
						        	$(this).val($(this).val().toUpperCase());
						        	if (ui.item==null)
						            {
							            // Only accept value that matches the items in the autocomplete list	            	
						            	var inputVal = $(this).val();
						            	var match = false;
						            	
						            	$.each(result,function()
						            	{
						            		if(this.value.toUpperCase() == inputVal)
						            		{
						            			match = true;
						            			return false;
						            		}
						            	});
						            	
							            if(!match)
							            {
							            	alert("Stock code not found");
							            	$(this).val('');
							            }
							            
							            //$(this).focus();
						            }
						        },
							    minLength: 0,
							   open: function() { 
                                    $(this).autocomplete("widget").width(500);
                                     $(this).autocomplete("widget").css('overflow-y','scroll');
                                     $(this).autocomplete("widget").css('max-height','250px');
                                     $(this).autocomplete("widget").css('font-family','courier');
                                } 
		         			}).focus(function(){     
                                $(this).data("autocomplete").search($(this).val());
                            })
	               		)
	               	).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span tnumber qtyDetail')
	               		 	.attr('name','Tstkreceive[1][qty]')
	               		 	.attr('type','text')
	               		 	.change(
	               		 		function()
	               		 		{
	               		 			countTotal();
	               		 		}
	               		 	)
	               		 	.focus(
	               		 		function()
	               		 		{
	               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
	               		 		}
	               		 	)
	               		 	.blur(
	               		 		function()
	               		 		{
	               		 			$(this).val(setting.func.number.addCommas($(this).val()));
	               		 		}
	               		 	)
	               		)
	               	).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span tnumber')
	               		 	.attr('name','Tstkreceive[1][price]')
	               		 	.attr('type','text')
	               		 	.focus(
	               		 		function()
	               		 		{
	               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
	               		 		}
	               		 	)
	               		 	.blur(
	               		 		function()
	               		 		{
	               		 			$(this).val(setting.func.number.addCommas($(this).val()));
	               		 		}
	               		 	)
	               		 	.val(price)
	               		)
	               	).append($('<td>')
	               		 .attr('class','rdi')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Tstkreceive[1][rdi_flg]')
	               		 	.attr('type','text')
	               		 	.prop('readonly',true)
	               		)
	               	).append($('<td>')
	               		 .append($('<a>')
	               		 	.attr('onClick','deleteRow(this)')
	               		 	.attr('title','delete')
	               		 	.css('cursor','pointer')
	               		 	.append($('<img>')
	               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
	               		 	)
	               		)
	               	)  	
	    		);
	    		
	    	$("#tableReceive").find('tbody tr:first td:first input').trigger('change');
	    	
	    	receiveCount++;
	    	reassignId();
	    	countTotal();
	    	//$(window).trigger('resize');
	    }
	}
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		receiveCount--;
		reassignId();
		countTotal();
		//$(window).trigger('resize');
	}
	
	function reassignId()
	{
		var x = 1;
		$("#tableReceive").children("tbody").children("tr").each(function()
		{
			$(this).children("td:eq(0)").children("input").attr("name","Tstkreceive["+x+"][client_cd]");
			$(this).children("td:eq(1)").children("input").attr("name","Tstkreceive["+x+"][client_name]");
			$(this).children("td:eq(2)").children("input").attr("name","Tstkreceive["+x+"][stk_cd]");
			$(this).children("td:eq(3)").children("input").attr("name","Tstkreceive["+x+"][qty]");
			$(this).children("td:eq(4)").children("input").attr("name","Tstkreceive["+x+"][price]");
			$(this).children("td:eq(5)").children("input").attr("name","Tstkreceive["+x+"][rdi_flg]");
			x++;
		});
	}
</script>
