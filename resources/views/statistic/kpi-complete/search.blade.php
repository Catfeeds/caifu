
<div class="content-block">
	<div class="content-block-title">
		<span>筛选</span>
	</div>
	<div class="content-block-content">
		<form action="" method='get' id = 'queryForm'>
			<div class="search-content">
				<div class="search-item">
					<label class="control-label">地区</label>
					<div class="search-right">
						<select class="form-control name4" name='name4'>
							<option value="">请选择集团</option>
						</select> <select class="form-control name3" name='name3'>
							<option value="">请选择大区</option>
						</select> <select class="form-control name2" name='name2'>
							<option value="">请选择事业部</option>
						</select> <select class="form-control name1" name='name1'>
							<option value="">请选择片区</option>
						</select> <select class="form-control name" name='name'>
							<option value="">请选择项目</option>
						</select>
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">时间</label>
					<div class="search-right">
						<div class="search-inline">
							<input type="text" class="form-control dateTimePicker" id ='kpiCompletion-dateTime1' name = 'begin_time' value="{{old('begin_time',date('Y-m',$beginTime))}}"
								data-date-format="yyyy-mm-dd" placeholder="请选择开始日期"
								id="kpiCompletion-dateTime1"> <i class="fas fa-calendar-alt"></i>
						</div>
						-
						<div class="search-inline">
							<input type="text" class="form-control dateTimePicker" id ='kpiCompletion-dateTime2' name = 'end_time' value="{{old('end_time',date('Y-m',$endTime) )}}"
								data-date-format="yyyy-mm-dd" placeholder="请选择结束日期"
								id="kpiCompletion-dateTime2"> <i class="fas fa-calendar-alt"></i>
						</div>
						<span>单位：</span>
						<select class="form-control dateTypeSelect" id ='dateType' name = "unit" value = "{{old('unit')}}"  data-target="kpiCompletion-dateTime1,kpiCompletion-dateTime2">

							<option value="day" @if(old('unit') == 'day') {{"selected"}} @endif>日</option>
							<option value="month" @if(!old('unit') || old('unit') == 'month') {{"selected"}} @endif>月</option>
							<option value="year" @if(old('unit') == 'year') {{"selected"}} @endif>年</option>
						</select>
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">完成率(%)</label>
					<div class="search-right">
						<div class="search-inline">
							<input type="text" class="form-control" name = 'complete_begin' value="{{old('complete_begin')}}"
								placeholder="请输入完成率">
						</div>
						-
						<div class="search-inline">
							<input type="text" class="form-control" name = 'complete_end' value="{{old('complete_end')}}"
								placeholder="请输入完成率">
						</div>
					</div>
				</div>
				<div class="search-item">
					<label class="control-label">GMV(万元)</label>
					<div class="search-right">
						<div class="search-inline">
							<input type="text" class="form-control" name = 'kpi_begin' value="{{old('kpi_begin')}}"
								placeholder="请输入金额">
						</div>
						-
						<div class="search-inline">
							<input type="text" class="form-control" name = 'kpi_end' value="{{old('kpi_end')}}"
								placeholder="请输入金额">
						</div>
					</div>
				</div>
				<input type="hidden" id="pageNum" name="page" value="{{$currentPage}}">
				<input type="hidden" id="total" value="{{$total}}">

				<div class="btn-group">
<!-- 					<input type='submit' class='btn blue' value="搜索"> -->
					<a class="btn blue" id="submitForm">搜索</a>
					<a class="btn default">导出Excel</a> <a class="btn default">导入Excel</a>
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