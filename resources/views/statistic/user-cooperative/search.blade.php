<div class="content-block">
<!-- 	<div class="content-block-title">
		<span>筛选</span>
	</div> -->
	<div class="content-block-content">
		<form action="" method='get'>
		<div class="search-content">
			<div class="search-item">
				<label class="control-label">地区</label>
				<div class="search-right">
					<select class="form-control name4" name = 'name4'>
						<option value="">请选择集团</option>
					</select> <select class="form-control name3" name = 'name3'>
						<option value="">请选择大区</option>
					</select> <select class="form-control name2" name = 'name2'>
						<option value="">请选择事业部</option>
					</select> <select class="form-control name1" name = 'name1'>
						<option value="">请选择片区</option>
					</select> <select class="form-control name" name = 'name'>
						<option value="">请选择项目</option>
					</select>
				</div>
			</div>
			<div class="search-item">
				<label class="control-label">注册时间</label>
				<div class="search-right">
					<div class="search-inline">
						<input type="text" name = 'user_create_time' class="form-control dateTimePicker" value="{{old('user_create_time')}}"
							data-date-format="yyyy-mm-dd" placeholder="请选择日期" autocomplete="off"> <i
							class="fas fa-calendar-alt"></i>
					</div>
					-
					<div class="search-inline">
						<input type="text" name = 'user_end_time' class="form-control dateTimePicker" value="{{old('user_end_time')}}"
							data-date-format="yyyy-mm-dd" placeholder="请选择日期" autocomplete="off"> <i
							class="fas fa-calendar-alt"></i>
					</div>
				</div>
			</div>
			<div class="search-item">
				<label class="control-label">入社时间</label>
				<div class="search-right">
					<div class="search-inline">
						<input type="text" name = 'club_create_time' class="form-control dateTimePicker" value="{{old('club_create_time')}}"
							data-date-format="yyyy-mm-dd" placeholder="请选择日期" autocomplete="off"> <i
							class="fas fa-calendar-alt"></i>
					</div>
					-
					<div class="search-inline">
						<input type="text" name = 'club_end_time' class="form-control dateTimePicker" value="{{old('club_end_time')}}"
							data-date-format="yyyy-mm-dd" placeholder="请选择日期" autocomplete="off"> <i
							class="fas fa-calendar-alt"></i>
					</div>
				</div>
			</div>
			<div class="search-item">
				<label class="control-label">用户ID</label>
				<div class="search-right">
					<input type="text" class="form-control" value="{{old('user_id')}}" placeholder="" name = 'user_id'>
				</div>
			</div>
			<div class="search-item">
				<label class="control-label">用户姓名</label>
				<div class="search-right">
					<input type="text" class="form-control" value="{{old('username')}}" placeholder="" name = 'username'>
				</div>
			</div>
			<div class="search-item">
				<label class="control-label">用户手机号</label>
				<div class="search-right">
					<input type="text" class="form-control" value="{{old('mobile')}}" placeholder="" name = 'mobile'>
				</div>
			</div>
			<div class="search-item">
				<label class="control-label">合作社名称</label>
				<div class="search-right">
					<input type="text" class="form-control" value="{{old('club_name')}}" placeholder="" name = 'club_name'>
				</div>
			</div>
			<div class="search-item">
				<label class="control-label">合作社ID</label>
				<div class="search-right">
					<input type="text" class="form-control" value="{{old('club_id')}}" placeholder="" name = 'club_id'>
				</div>
			</div>
			<div class="btn-group">
				<input type='submit' class = 'btn green' value = "搜索">
				<a class="btn blue">导出Excel</a>
				<a class="btn default"  id="reStatistics">重新统计</a>
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