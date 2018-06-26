$(function() {
	H.citySearch = {
		init: function(){
			this.events(0,'',name4);
			if(name4){
				this.events(1,name4,name3);
			}

			if(name3){
				this.events(2,name3,name2);
			}
			if(name2){
				this.events(3,name2,name1);
			}
			if(name1){
				this.events(4,name1,name);
			}
			$('.search-right .name4').on('change',function(){
				$('.search-right .name3').val('');
				$('.search-right .name2').val('');
				$('.search-right .name1').val('');
				$('.search-right .name').val('');
				var val = $(this).val();

				H.citySearch.events(1,val,'');
			});

			$('.search-right .name3').on('change',function(){
				$('.search-right .name2').val('');
				$('.search-right .name1').val('');
				$('.search-right .name').val('');
				var val = $(this).val();
				if(name4){
					val = name4;
				}
				H.citySearch.events(2,val,'');
			});
			$('.search-right .name2').on('change',function(){
				$('.search-right .name1').val('');
				$('.search-right .name').val('');

				var val = $(this).val();
				if(name4){
					val = name4;
				}
				H.citySearch.events(3,val,'');
			});
			$('.search-right .name1').on('change',function(){
				$('.search-right .name').val('');
				var val = $(this).val();
				if(name4){
					val = name4;
				}
				H.citySearch.events(4,val,'');
			});
		},
		events: function(type,value,childValue){
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

					  $('.search-right .'+child_field).html(a);



				  },
				  dataType: 'json'
			});
		}
	};
	H.citySearch.init();
});