$(function() {
	H.order = {
		init: function(){
			// 选中左侧某个菜单
			selectLeftNode('nav-order');
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			// 选中上方某个tab
			$('#pageTab a[href="#order"]').trigger('click');
			this.events();
			// 初始化日期选择插件
			$('.dateTimePicker').datetimepicker({
				format: 'yyyy-mm-dd',
		        autoclose: true,
		        startView: 2,
		        minView:2,
		        language:  'zh-CN',
			});
			$('.order-edit-organize .name4').on('change',function(){
				$('.order-edit-organize .name3').val('');
				$('.order-edit-organize .name2').val('');
				$('.order-edit-organize .name1').val('');
				$('.order-edit-organize .name').val('');
				var val = $(this).val();
				var id = $(this).attr('data-id');
				H.order.getCity(1,val,'',id);
			});

			$('.order-edit-organize .name3').on('change',function(){
				$('.order-edit-organize .name2').val('');
				$('.order-edit-organize .name1').val('');
				$('.order-edit-organize .name').val('');
				var val = $(this).val();
				if(name4){
					val = name4;
				}
				var id = $(this).attr('data-id');

				H.order.getCity(2,val,'',id);
			});
			$('.order-edit-organize .name2').on('change',function(){
				$('.order-edit-organize .name1').val('');
				$('.order-edit-organize .name').val('');

				var val = $(this).val();
				if(name4){
					val = name4;
				}
				var id = $(this).attr('data-id');
				H.order.getCity(3,val,'',id);
			});
			$('.order-edit-organize .name1').on('change',function(){
				$('.order-edit-organize .name').val('');
				var val = $(this).val();
				if(name4){
					val = name4;
				}
				var id = $(this).attr('data-id');
				H.order.getCity(4,val,'',id);
			});

		},
		events: function(){
			$("body").delegate("#reStatistics","click",function(){
				//重新统计按钮事件，打开重新统计弹层
				$("#reStatisticsTime").val("");
				$("#reStatisticsPopup").removeClass("none");
			}).delegate("#reStatisticsPopup .close-btn","click",function(){
				//重新统计弹层关闭按钮事件，关闭重新统计弹层
				$("#reStatisticsPopup").addClass("none");
			}).delegate("#reStatisticsPopup #reCommitBtn","click",function(){
				//重新统计弹层提交按钮事件，展示提示信息
				$("#reStatisticsPopup").addClass("none");
				showAlert('数据正在重新统计中...<br>24小时后统计结果才会刷新哦！');
			}).delegate('.orderEditBtn', 'click', function(event) {
				let id = $(this).attr("data-id");
				$("#tr-" + id + " select").removeClass("none");
				$("#tr-" + id + " span").addClass("none");
				$("#tr-" + id + " .orderSaveBtn").removeClass('none');

				$(this).addClass("none");
				var o_group = $("#tr-" + id + " .o_group").text();
				var large_area = $("#tr-" + id + " .large_area").text();
				var department = $("#tr-" + id + " .department").text();
				var area = $("#tr-" + id + " .area").text();
				var project = $("#tr-" + id + " .project").text();

				H.order.getCity(0,'',o_group,id);
				if(o_group){
					H.order.getCity(1,o_group,large_area,id);
				}

				if(large_area){
					H.order.getCity(2,large_area,department,id);
				}
				if(department){
					H.order.getCity(3,department,area,id);
				}
				if(area){
					H.order.getCity(4,area,project,id);
				}
			}).delegate('.orderSaveBtn', 'click', function(event) {
				let id = $(this).attr("data-id");

				var o_group = $("#tr-" + id + " .name4").val();
				var large_area = $("#tr-" + id + " .name3").val();
				var department = $("#tr-" + id + " .name2").val();
				var area = $("#tr-" + id + " .name1").val();
				var project = $("#tr-" + id + " .name").val();
				if(!o_group || !large_area || !department ||!area || !project){
					alertErrorMsg('请选择完组织架构信息');
					return false;
				}
				$.ajax({
				  type: 'POST',
				  url: '/statistic/order/edit-organize',
				  data: {

				  		'o_group' : o_group,
				  		'large_area' : large_area,
				  		'department' : department,
				  		'area' : area,
				  		'project' : project,
				  		'id' : id	


				  },
				  success: function(json){

					  
				  		if(json.errcode == 0){
				  			$("#tr-" + id + " select").addClass("none");
							$("#tr-" + id + " span").removeClass("none");
							$("#tr-" + id + " .orderEditBtn").removeClass('none');
							$("#tr-" + id + " .orderSaveBtn").addClass("none");
							alertErrorMsg('操作成功');
							window.location.reload();
				  		}else{
				  			alertErrorMsg(json.msg);
				  		}
					 	


				  },
				  dataType: 'json'
			});


			});
		},
		getCity: function(type,value,childValue,currentId){

			var parent_field = '';
			var child_field = 'name4';
			if(type == 1){
				parent_field = 'name4';
				child_field = 'name3';
			}
			if(type == 2){
				parent_field = 'name3';
				child_field = 'name2';
			}
			if(type == 3){
				parent_field = 'name2';
				child_field = 'name1';
			}
			if(type == 4){
				parent_field = 'name1';
				child_field = 'name';
			}
			$.ajax({
				  type: 'POST',
				  url: '/statistic/api/get-organize',
				  data: {
					  'parent_field' : parent_field,
					  'parent_value' : value,
					  'child_field' : child_field



				  },
				  success: function(json){

					  var a = '<option value="">请选择</option>';
					  for(var i = 0;i < json.data.length;i++){
						  a += "<option value='"+json.data[i][child_field]+"' ";
						  if(childValue == json.data[i][child_field]){
							  a += " selected";
						  }
						  a += ">";
						  a += json.data[i][child_field];
						  a += '</option>';

					  }
					  console.log(currentId);
					  $(".order-edit-organize ."+child_field+"[data-id="+currentId+"]").html(a);

					 


				  },
				  dataType: 'json'
			});
		}
	};
	H.order.init();
});