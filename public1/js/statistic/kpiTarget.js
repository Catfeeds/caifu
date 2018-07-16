$(function() {
	H.kpiTarget = {
		init: function(){
			$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
			});
			// 选中左侧某个菜单
			selectLeftNode('nav-kpiTarget');
			// 选中上方某个tab
			$('#pageTab a[href="#kpiTarget"]').trigger('click');
			this.events();
			// 初始化日期选择插件
			$('.dateTimePicker').datetimepicker({
				format: 'yyyy-mm-dd',
		        autoclose: true,
		        startView: 2,
		        minView:2,
		        language:  'zh-CN',
			});
			// 导入excel 按钮点击事件
			$("#importBtn").click(function(e){
				e.preventDefault();
				$('#importExcelModal').modal('show');
			});
			// 导入excel弹层 提交按钮点击事件
			$("#importExcelSubmitBtn").click(function(e){
				e.preventDefault();
				var form = $("#importFrom");   
				var formdata = new FormData(form);  
				console.log(formdata);	
				if(!formdata){
					alertErrorMsg('请选择导入文件');
					return;
				}  
				$("#importFrom").ajaxSubmit({
		          type:'post',
		          url:'/statistic/kpi-target/import',
		          success:function(json){
		          	console.log(json);
		            if(json.errcode == 0){
						  	 // 关闭弹层
							 $('#importExcelModal').modal('hide');
							  alertErrorMsg('操作成功');
							  window.location.reload();
					}else{
							  alertErrorMsg(json.msg);
					}
		          },
		          error:function(XmlHttpRequest,textStatus,errorThrown){
		            console.log(XmlHttpRequest);
		            console.log(textStatus);
		            console.log(errorThrown);
		          }
		        });

				// $.ajax({
				// 	  type: 'POST',
				// 	  url: '/statistic/kpi-target/import',
				// 	  data:formdata,
				// 	  async: false,  
			 //          cache: false,  
			 //          contentType: false,  
			 //          processData: false,
				// 	  success: function(json){
				
				// 		  if(json.errcode == 0){
				// 		  	 // 关闭弹层
				// 			 $('#importExcelModal').modal('hide');
				// 			  alertErrorMsg('操作成功');
				// 			  window.location.reload();
				// 		  }else{
				// 			  alertErrorMsg(json.msg);
				// 		  }
				// 	  },
				// 	  dataType: 'json'
				// });
			});

			$('#exportBtn').on('click',function(e){
				e.preventDefault();
				window.open('/statistic/kpi-target/export?'+$('#formId').serialize(),'_blank');

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
			}).delegate('.apiTargetEditBtn', 'click', function(event) {
				let id = $(this).attr("data-id");
				$("#tr-" + id + " input").removeClass("none");
				$("#tr-" + id + " span").addClass("none");
				$("#tr-" + id + " .apiTargetSaveBtn").removeClass('none');
				$(this).addClass("none");
			}).delegate('.apiTargetSaveBtn', 'click', function(event) {
				let id = $(this).attr("data-id");
				var month01 = $("#tr-" + id + " input[name='month01']").val();
				var month02 = $("#tr-" + id + " input[name='month02']").val();
				var month03 = $("#tr-" + id + " input[name='month03']").val();
				var month04 = $("#tr-" + id + " input[name='month04']").val();
				var month05 = $("#tr-" + id + " input[name='month05']").val();
				var month06 = $("#tr-" + id + " input[name='month06']").val();
				var month07 = $("#tr-" + id + " input[name='month07']").val();
				var month08 = $("#tr-" + id + " input[name='month08']").val();
				var month09 = $("#tr-" + id + " input[name='month09']").val();
				var month10 = $("#tr-" + id + " input[name='month10']").val();
				var month11 = $("#tr-" + id + " input[name='month11']").val();
				var month12 = $("#tr-" + id + " input[name='month12']").val();
				var annual = $("#tr-" + id + " input[name='annual']").val();
				if(!month01 || !month02 || !month03 || !month04
					|| !month05 || !month06 || !month07 || !month08 || !month09 || !month10 || !month11
					|| !month12 || !annual){
					alertErrorMsg('请填写完整的kpi目标');
					return;
				}
				
				$.ajax({
					  type: 'POST',
					  url: '/statistic/kpi-target/edit',
					  data: {
						  id: id,
						  month01 : month01,
						  month02 : month02,
						  month03 : month03,
						  month04 : month04,
						  month05 : month05,
						  month06 : month06,
						  month07 : month07,
						  month08 : month08,
						  month09 : month09,
						  month10 : month10,
						  month11 : month11,
						  month12 : month12,
						  annual : annual,


					  },
					  success: function(json){
						  $("#tr-" + id + " input").addClass("none");
						  $("#tr-" + id + " span").removeClass("none");
						  $("#tr-" + id + " .apiTargetEditBtn").removeClass('none');
						  $("#tr-" + id + " .apiTargetSaveBtn").addClass("none");
						  if(json.errcode == 0){
							  alertErrorMsg('操作成功');
							  window.location.reload();
						  }else{
							  alertErrorMsg(json.msg);
						  }
					  },
					  dataType: 'json'
				});

			});
		}
	};
	H.kpiTarget.init();
});