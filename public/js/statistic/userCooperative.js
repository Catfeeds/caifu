$(function() {
	H.userCooperative = {
		init: function(){
			// 选中左侧某个菜单
			selectLeftNode('nav-userCooperative');
			// 选中上方某个tab
			$('#pageTab a[href="#userCooperative"]').trigger('click');
			this.events();
			// 初始化日期选择插件
			$('.dateTimePicker').datetimepicker({
				format: 'yyyy-mm-dd',
		        autoclose: true,
		        startView: 2,
		        minView:2,
		        language:  'zh-CN',
			});
			$('#reStatisticsTime').datetimepicker({
				format: 'yyyy-mm-dd',
		        autoclose: true,
		        startView: 2,
		        minView:2,
		        language:  'zh-CN',
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
				var beginTime = $('#reStatisticsTime').val();
				if(!beginTime){
					alertErrorMsg('请选择时间段');
					return false;
				}
				//重新统计弹层提交按钮事件，展示提示信息
				$("#reStatisticsPopup").addClass("none");
				showAlert('数据正在重新统计中...！');
				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});
				$.ajax({
					  type: 'POST',
					  url: '/statistic/user-cooperative/reset',
					  data: {
						  'time' : beginTime



					  },
					  success: function(json){

							showAlert('统计成功');
							window.location.reload();

					  },
					  dataType: 'json'
				});
			});
		}
	};
	H.userCooperative.init();
});