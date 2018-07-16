

<div class="content-block">
	<!-- <div class="content-block-title">
                                    <span>筛选</span>
                                </div> -->
	<div class="content-block-content">
		<form action="" method='get' id = 'formId'>

			<div class="search-content">
				<div class="search-content-left">
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
						<label class="control-label">合作社成立时间</label>
						<div class="search-right">
							<div class="search-inline">
								<input type="text" name = 'begin_time' class="form-control dateTimePicker" value="{{old('begin_time')}}"
									data-date-format="yyyy-mm-dd" placeholder="请选择日期" autocomplete="off"> <i
									class="fas fa-calendar-alt"></i>
							</div>
							-
							<div class="search-inline">
								<input type="text" name ='end_time' class="form-control dateTimePicker" value="{{old('end_time')}}"
									data-date-format="yyyy-mm-dd" placeholder="请选择日期" autocomplete="off"> <i
									class="fas fa-calendar-alt"></i>
							</div>
						</div>
					</div>
					<div class="search-item">
						<label class="control-label">社员人数</label>
						<div class="search-right">
							<div class="search-inline">
								<input type="text" value="{{old('member_begin')}}" name = 'member_begin' class="form-control" placeholder="请输入人数">
							</div>
							-
							<div class="search-inline">
								<input type="text" value = "{{old('member_end')}}" name = 'member_end' class="form-control" placeholder="请输入人数">
							</div>
						</div>
					</div>
					<div class="search-item">
						<label class="control-label">在投金额（元）</label>
						<div class="search-right">
							<div class="search-inline">
								<input type="text" value = "{{old('investment_fee_begin')}}" name = 'investment_fee_begin' class="form-control" placeholder="请输入金额">
							</div>
							-
							<div class="search-inline">
								<input type="text" value = "{{old('investment_fee_end')}}" name = 'investment_fee_end' class="form-control" placeholder="请输入金额">
							</div>
						</div>
					</div>
				</div>
				<div class="search-content-right">
					<div class="search-item">
						<label class="control-label">社长姓名</label>
						<div class="search-right">
							<input type="text" name = 'username' class="form-control" value = "{{old('username')}}" placeholder="">
						</div>
					</div>
					<div class="search-item">
						<label class="control-label">社长手机号</label>
						<div class="search-right">
							<input type="text" name = 'mobile' class="form-control" value="{{old('mobile')}}" placeholder="">
						</div>
					</div>
					<div class="search-item">
						<label class="control-label">社名</label>
						<div class="search-right">
							<input type="text" name = 'club_name' class="form-control" value="{{old('club_name')}}" placeholder="">
						</div>
					</div>
					<div class="search-item">
						<label class="control-label">合作社ID</label>
						<div class="search-right">
							<input type="text" name = 'club_id' class="form-control" value="{{old('club_id')}}" placeholder="">
						</div>
					</div>
				</div>
				<div class="btn-group">
						<input type='submit' class='btn green' value="搜索">
						<a class="btn blue" id ='exportBtn'>导出Excel</a>
						<a class="btn blue">导入Excel</a>


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