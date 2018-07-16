<div class="content-block">
<!-- 	<div class="content-block-title">
		<span>筛选</span>
	</div> -->
	<div class="content-block-content">
		<form action="" method='get' id = 'formId'>
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

			<div class="btn-group">
				<input type='submit' class = 'btn green' value = "搜索">
				<a class="btn blue" id ='exportBtn'>导出Excel</a>
				<a class="btn blue" id="reStatistics">重新统计</a>
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