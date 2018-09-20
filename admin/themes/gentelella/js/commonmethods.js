$(document).ready(function(){
	/*#### Pagination limit layout ####*/
	if($('ul').hasClass('pagination')) { $(".page_limit_layout").css("margin-top","-50px"); }
	$('.x_title').on('click', '#resetFilter', function(){
		$('.filters').find('input').val('');
		$("#grid-container").yiiGridView("applyFilter");
	});

	$('.x_title').on('click', '#btnfilterApply', function(){
		$("#grid-container").yiiGridView("applyFilter");
	});
	/*#### send messages ####*/
	$("#send-message").click(function(){
		var cnt = 0;
		var checkedVals = $('.msgChk:checkbox:checked').map(function() {
			cnt = 1;
			return this.value;
		}).get();
		if(cnt == 1) {
			$("#sendchkbox").val(checkedVals);	
			$("#form-sendmessage").submit();
		}
	});
});
/*#### common method to update status ####*/
function updateStatus(dis, userid) {
	var post = {'update': {'status': dis.value}};
	if (dis.value && dis.value != '') {
		$.ajax({
			url: homeURL+CtrlName+'/status/' + userid,
			type: 'post',
			data: post,
			success: function (response) {
				window.location.reload();
			}
		});
	}
}
/*#### update partner status ####*/
function partnerUpdateStatus(dis,recordid) {
	var post = {'update':{'status':dis.value,'recordid':recordid}};	
	if(dis.value && dis.value != '') {
		$.ajax({
				url: homeURL+CtrlName+'/status',
				type:'post',
				data:post,
				success:function(response){
						window.location.reload();
					}
				
			});	
	}
}
/*#### update payment status ####*/
function updatePaymentStatus(dis, paymentId) {
	var post = {'UpdatePayment': {'status': dis.value}};
	if (dis.value && dis.value != '') {
		$.ajax({
			url: homeURL+CtrlName+'/updatestatus/' + paymentId,
			type: 'post',
			data: post,
			success: function (response) {
				window.location.reload();
			}
		});
	}
}
/*#### update properties status ####*/
function updatePropertiesStatus(dis,userid,uid) {
	if(dis.value == 3) {
		if(uid != 0 || uid != '') {
			$("#sendchkbox").val(uid);
			$("#form-sendmessage").submit();
			return false;
		}
	} else {
		var post = {'update':{'status':dis.value}};	
		if(dis.value && dis.value != '') {
			$.ajax({
					url: homeURL+CtrlName+'/status/'+userid,
					type:'post',
					data:post,
					success:function(response){
							window.location.reload();
						}
					
				});	
		}
	}
}
/*#### update advertisement ####*/
function updateAdvertisementStatus(dis,recordid,uid) {
	if(dis.value == 3) {
		if(uid != 0 || uid != '') {
			$("#sendchkbox").val(uid);
			$("#form-sendmessage").submit();
			return false;
		}
	} else {		
		var post = {'update':{'status':dis.value}};	
		if(dis.value && dis.value != '') {
			$.ajax({
					url: homeURL+CtrlName+'/status/'+recordid,
					type:'post',
					data:post,
					success:function(response){
							window.location.reload();
						}
					
				});	
		}
	}
}

/*#### pagination limit ####*/
function changePageLimit() {
	var val = $("#propertiessearch-pagesize").val();
	location.href = homeURL+CtrlName+"?p="+val;	
}
