var DIALOG_SHOW_SECONDS = 10;
//错误信息提示
function alertErrorMsg(msg) {
	alertMsg("错误", msg);
}
//普通信息提示
function alertTipMsg(msg) {
	alertMsg("提示", msg);
}
//普通信息提示，可替换提示框标题
function alertTipMsg2(title, msg) {
	alertMsg(title, msg);
}

//显示自动关闭 loadding 
function showLoadingAutoClose(time) {
	closeAll();
	var d = dialog({
		cancel : false,
		content : '<img src="resources/plugins/artDialog/loading.gif" />',
		onshow : function() {
			var that = this, i = time;
			var fn = function() {
				that.title(i + '秒后自动关闭');
				!i && that.close();
				i--;
			};
			tip_timer = setInterval(fn, 1000);
			fn();
		},
		onclose : function() {
			clearInterval(tip_timer);
		}
	});
	d.showModal();
}

//显示 loadding 
function showLoading() {
	closeAll();
	var d = dialog({
		cancel : false,
		content : '<img src="assets/plugins/artDialog/loading.gif" />',
		fixed : true
	});
	d.title('正在拼命处理中...');
	d.showModal();
}
//隐藏 loadding 
function hideLoading() {
	closeAll();
}
//显示可跳转提示框
function alertMsgAndJump(message, redirectUrl) {
	closeAll();
	var d = dialog({
		title : "提示",
		content : message,
		// quickClose : true,// 点击空白处快速关闭
		ok : true,
		okValue : '确定',
		onshow : function() {
			var that = this, i = DIALOG_SHOW_SECONDS;
			var fn = function() {
				that.title(i + '秒后自动关闭');
				!i && that.close();
				i--;
			};
			tip_timer = setInterval(fn, 1000);
			fn();
		},
		onclose : function() {
			clearInterval(tip_timer);
			window.location.href = redirectUrl;
		}
	});
	d.showModal();
}

//显示重新加载页面提示框
function alertMsgAndReload(message) {
	closeAll();
	var d = dialog({
		title : "提示",
		content : message,
		// quickClose : true,// 点击空白处快速关闭
		ok : true,
		okValue : '确定',
		onshow : function() {
			var that = this, i = DIALOG_SHOW_SECONDS;
			var fn = function() {
				that.title(i + '秒后自动关闭');
				!i && that.close();
				i--;
			};
			tip_timer = setInterval(fn, 1000);
			fn();
		},
		onclose : function() {
			clearInterval(tip_timer);
			location.reload();
		}
	});
	d.showModal();
}

//信息提示
function alertMsg(title, message) {
	closeAll();
	var d = dialog({
		title : title,
		content : message,
		// quickClose : true,// 点击空白处快速关闭
		ok : true,
		okValue : '确定',
		onshow : function() {
			// var that = this, i = DIALOG_SHOW_SECONDS;
			// var fn = function() {
			// 	that.title(i + '秒后自动关闭');
			// 	!i && that.close();
			// 	i--;
			// };
			// tip_timer = setInterval(fn, 1000);
			// fn();
		},
		onclose : function() {
			// clearInterval(tip_timer);
		}
	});
	d.showModal();
}

function alertMsgForeve(title, message) {
	closeAll();
	var d = dialog({
		title : title,
		content : message
	});
	d.showModal();
}

function alertMsgNoOk(title, message) {
	closeAll();
	var d = dialog({
		title : title,
		content : message,
		onshow : function() {
			var that = this, i = DIALOG_SHOW_SECONDS;
			var fn = function() {
				that.title(i + '秒后自动关闭');
				!i && that.close();
				i--;
			};
			tip_timer = setInterval(fn, 1000);
			fn();
		},
		onclose : function() {
			clearInterval(tip_timer);
		}
	});
	d.showModal();
}

function alertMsgCallBack(title, message, fn) {
	closeAll();
	var d = dialog({
		title : title,
		content : message,
		ok : function() {
			fn();
		},
		okValue : '确定',
		onclose : function() {
		}
	});
	d.showModal();
}

function closeAll() {
	var list = dialog.list;
	for ( var i in list)
		list[i].close().remove();
}