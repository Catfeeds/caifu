$(function() {
	H.order = {
		init: function(){
			// 选中左侧某个菜单
			selectLeftNode('nav-order');
			// 选中上方某个tab
			$('#pageTab a[href="#order"]').trigger('click');
			this.events();
			// 初始化日期选择插件
			$('.dateTimePicker').datepicker({
				autoclose: true,
        		format: "yyyy-mm-dd",
        		language: "zh-CN"
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
			}).delegate('.orderSaveBtn', 'click', function(event) {
				let id = $(this).attr("data-id");
				$("#tr-" + id + " select").addClass("none");
				$("#tr-" + id + " span").removeClass("none");
				$("#tr-" + id + " .orderEditBtn").removeClass('none');
				$(this).addClass("none");
			});
		},
		getCity: function(type,value,childValue,currentId){
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
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