// 初始化分页组件
function initPagination(domId, num_entries, eachPageSize, prePage) {
	if(prePage == null) {
		prePage = $("#query_page").val();
		if(prePage == null)
			prePage = "1";
		console.log(prePage);
	}
	var current_page_val = 0;
	if($.trim($("#listPage").val()) != ''){
		current_page_val = parseInt($("#listPage").val()) - 1;
	}
	if (prePage > 1) {
		current_page_val = Number(prePage) - 1;
	}
	var totalPageVal = parseInt(num_entries / eachPageSize);
	if ((num_entries % eachPageSize) > 0) {
		totalPageVal = totalPageVal + 1;
	}
	if (current_page_val >= totalPageVal) {
		current_page_val = totalPageVal - 1;
	}
	if (num_entries > 0 && num_entries > eachPageSize) {
		$(domId).pagination(num_entries, {
					num_edge_entries : 1,
					num_display_entries : 6,
					callback : pageselectCallback,
					items_per_page : eachPageSize,
					current_page : current_page_val,
					prev_text : "上一页",
					next_text : "下一页"
				});
	}else{
		pageselectCallback(0, "Pagination");
	}
}

// 分页回调函数
function pageselectCallback(page_index, jq) {
	var pageNum = $("#pageNum").val();
	var nextNum = (page_index+1);
	if(pageNum == ''){		
		return;
	}
	if(nextNum != pageNum){
		$("#pageNum").val(nextNum);
		$("#queryForm").submit();
	}
}
