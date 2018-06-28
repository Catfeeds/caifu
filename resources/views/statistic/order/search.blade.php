<div class="content-block">
	<div class="content-block-title">
		<span>筛选</span>
	</div>
	<div class="content-block-content">
		<form action="" method='get'>

		<div class="search-content">
			<div class="search-content-left">
				<div class="search-item">
					<label class="control-label">地区</label>
					<div class="search-right">
						<select class="form-control name4" name = 'name4'>
						<option value="">集团</option>
    					</select> <select class="form-control name3" name = 'name3'>
    						<option value="">大区</option>
    					</select> <select class="form-control name2" name = 'name2'>
    						<option value="">事业部</option>
    					</select> <select class="form-control name1" name = 'name1'>
    						<option value="">片区</option>
    					</select> <select class="form-control name" name = 'name'>
    						<option value="">项目</option>
    					</select>
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">订单状态</label>
					<div class="search-right">
						<select class="form-control" name = 'status' value = "">
							<option value="">请选择</option>
							@foreach($orderStatus as $k => $v)
							<option value="{{$k}}"
							@if(old('status') == $k)
							selected
							@endif
							>{{$v}}</option>

							@endforeach
						</select>
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">产品类型</label>
					<div class="search-right">
						<select class="form-control" name = 'model_name' value = "{{old('model_name')}}">
							<option value="">全部</option>
							@foreach($productType as $k => $v)
							<option value="{{$k}}"

							@if(old('model_name') == $k)
							selected
							@endif

							>{{$v}}</option>

							@endforeach
						</select>
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">生效时间</label>
					<div class="search-right">
						<div class="search-inline">
							<input type="text" name = "order_begin_time" class="form-control dateTimePicker" value="{{old('order_begin_time')}}"
								data-date-format="yyyy-mm-dd" placeholder="请选择日期"> <i
								class="fas fa-calendar-alt"></i>
						</div>
						-
						<div class="search-inline">
							<input type="text" name = 'order_end_time' class="form-control dateTimePicker" value="{{old('order_end_time')}}"
								data-date-format="yyyy-mm-dd" placeholder="请选择日期"> <i
								class="fas fa-calendar-alt"></i>
						</div>
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">到期时间</label>
					<div class="search-right">
						<div class="search-inline">
							<input type="text" name = "stop_begin_time" class="form-control dateTimePicker" value="{{old('stop_begin_time')}}"
								data-date-format="yyyy-mm-dd" placeholder="请选择日期"> <i
								class="fas fa-calendar-alt"></i>
						</div>
						-
						<div class="search-inline">
							<input type="text" name = "stop_end_time" class="form-control dateTimePicker" value="{{old('stop_end_time')}}"
								data-date-format="yyyy-mm-dd" placeholder="请选择日期"> <i
								class="fas fa-calendar-alt"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="search-content-right">
				<div class="search-item">
					<label class="control-label">订单号</label>
					<div class="search-right">
						<input type="text" class="form-control" name = 'sn' value="{{old('sn')}}" placeholder="">
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">用户姓名</label>
					<div class="search-right">
						<input type="text" class="form-control" name = "username" value="{{old('username')}}" placeholder="">
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">用户手机号</label>
					<div class="search-right">
						<input type="text" class="form-control" name = "mobile" value="{{old('mobile')}}" placeholder="">
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">推荐人姓名</label>
					<div class="search-right">
						<input type="text" class="form-control" name = "recommend_name" value="{{old('recommend_name')}}" placeholder="">
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">推荐人电话</label>
					<div class="search-right">
						<input type="text" class="form-control" name = "recommend_mobile" value="{{old('recommend_mobile')}}" placeholder="">
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">合作社ID</label>
					<div class="search-right">
						<input type="text" class="form-control" name = "club_id" value="{{old('club_id')}}" placeholder="">
					</div>
				</div>
			</div>
			<div class="btn-group">
				<input type='submit' class = 'btn blue' value = "搜索">
				<a class="btn default">导出Excel</a> <a
					class="btn default">导入Excel</a> <a class="btn default"
					id="reStatistics">重新统计</a>
			</div>
		</div>
		</form>
	</div>
</div>
<script>
    var name4 = "{{old('name4')}}";
    var name3 = "{{old('name3')}}";
    var name2 = "{{old('name2')}}";
    var name1 = "{{old('name1')}}";
    var name = "{{old('name')}}";
</script>