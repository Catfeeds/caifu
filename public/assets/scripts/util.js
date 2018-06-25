var __ns = function( fullNs ) {
    var nsArray = fullNs.split( '.' );
    var evalStr = '';
    var ns = '';
    for ( var i = 0, l = nsArray.length; i < l; i++ ) {
        i !== 0 && ( ns += '.' );
        ns += nsArray[i];
        evalStr += '( typeof ' + ns + ' === "undefined" && (' + ns + ' = {}) );';
    }
    evalStr !== '' && eval( evalStr );
};
var W = W || window;
__ns('H');

/**
 * 获取连接参数的值
 * @param name 参数名
 * @returns {*}
 */
var getQueryString = function( name ) {
    var currentSearch = decodeURIComponent( location.search.slice( 1 ) );
    if ( currentSearch != '' ) {
        var paras = currentSearch.split( '&' );
        for ( var i = 0, l = paras.length, items; i < l; i++ ) {
            items = paras[i].split( '=' );
            if ( items[0] === name) {
                return items[1];
            }
        }
        return '';
    }
    return '';
};

function copyToClipboard(elem) {
    var Url2=document.getElementById(elem);
    Url2.select(); // 选择对象
    try{
        if(document.execCommand('copy', false, null)){
            document.execCommand("Copy");
            console.log("已复制好，可贴粘。");
        }else{
            console.log("复制失败，请手动复制");
        }
    } catch(err){
        console.log("复制失败，请手动复制");
    }
}

/**
 * 给链接后增加参数
 * @param sourceUrl 链接地址
 * @param parameterName 参数名
 * @param parameterValue 参数值
 * @param replaceDuplicates 是否替换原值
 * @returns {string}
 */
var add_param = function(sourceUrl, parameterName, parameterValue, replaceDuplicates) {
    if ((sourceUrl == null) || (sourceUrl.length == 0)) {
        sourceUrl = document.location.href;
    }
    var urlParts = sourceUrl.split("?");
    var newQueryString = "";
    if (urlParts.length > 1) {
        var parameters = urlParts[1].split("&");
        for ( var i = 0; (i < parameters.length); i++) {
            var parameterParts = parameters[i].split("=");
            if (!(replaceDuplicates && parameterParts[0] == parameterName)) {
                if (newQueryString == "") {
                    newQueryString = "?";
                } else {
                    newQueryString += "&";
                }
                newQueryString += parameterParts[0] + "=" + parameterParts[1];
            }
        }
    }

    if (parameterValue !== null) {
        if (newQueryString == "") {
            newQueryString = "?";
        } else {
            newQueryString += "&";
        }
        newQueryString += parameterName + "=" + parameterValue;
    }
    return urlParts[0] + newQueryString;
};

/**
 * 删除链接参数
 * @param url 链接地址
 * @param ref 参数名
 * @returns {*}
 */
var delQueStr = function(url, ref){
    var str = "";

    if (url.indexOf('?') != -1)
        str = url.substr(url.indexOf('?') + 1);
    else
        return url;
    var arr = "";
    var returnurl = "";
    var setparam = "";
    if (str.indexOf('&') != -1) {
        arr = str.split('&');
        for (i in arr) {
            if (arr[i].split('=')[0] != ref) {
                returnurl = returnurl + arr[i].split('=')[0] + "=" + arr[i].split('=')[1] + "&";
            }
        }
        return url.substr(0, url.indexOf('?')) + "?" + returnurl.substr(0, returnurl.length - 1);
    }
    else {
        arr = str.split('=');
        if (arr[0] == ref)
            return url.substr(0, url.indexOf('?'));
        else
            return url;
    }
};

/**
 * 替换链接参数的值
 * @param href 链接地址
 * @param paramName 参数名
 * @param replaceWith 替换后的参数值
 * @returns {XML|void|string}
 */
var replaceParamVal = function(href,paramName,replaceWith) {
    var re=eval('/('+ paramName+'=)([^&]*)/gi');
    var nUrl = href.replace(re,paramName+'='+replaceWith);
    return nUrl;
};

/**
 * showLoading
 * @param $container 父元素
 * @param tips 提示信息
 */
var shownewLoading = function($container, tips) {
    var t = simpleTpl(),
        width = $(window).width(),
        height = $(window).height(),
        $container = $container || $('body'),
        $loading = $container ? $container.find('#qy_loading') : $('body').children('#qy_loading'),
        tips = tips || '努力加载中...';

    if ($loading.length > 0) {
        $loading.remove();
    };
    t._('<section id="qy_loading" class="qy-loading">')
        ._('<section class="qy-loading-logo">')
        ._('<section class="qy-logo-1"></section>')
        ._('<section class="qy-logo-2"></section>')
        ._('</section>')
        ._('<section class="qy-loading-tips">' + tips+ '</section>')
        ._('</section>')
    $container.append(t.toString());
};

/**
 * 隐藏loadding
 * @param $container 父元素
 */
var hidenewLoading = function($container) {
    if ($container) {
        $container.find('#qy_loading').remove();
    } else {
        $('body').children('#qy_loading').remove();
    };
};

/**
 * 获取当天的多少天之前的日期字符串
 * @param n 天数
 * @returns {string|*} yyyy-mm-dd
 */
var getBeforeDate = function(n){
    var n = n;
    var d = new Date();
    var year = d.getFullYear();
    var mon=d.getMonth()+1;
    var day=d.getDate();
    if(day <= n){
        if(mon>1) {
            mon=mon-1;
        }
        else {
            year = year-1;
            mon = 12;
        }
    }
    d.setDate(d.getDate()-n);
    year = d.getFullYear();
    mon=d.getMonth()+1;
    day=d.getDate();
    s = year+"-"+(mon<10?('0'+mon):mon)+"-"+(day<10?('0'+day):day);
    return s;
};

/**
 * 將毫秒轉化為yyyy-MM-dd HH:mm:ss格式的日期
 * @param TimeMillis 时间戳
 * @returns {string}
 */
var  timeTransform = function(TimeMillis){
    var data = new Date(TimeMillis);
    var year = data.getFullYear();  //获取年
    var month = data.getMonth()>=9?(data.getMonth()+1).toString():'0' + (data.getMonth()+1);//获取月
    var day = data.getDate()>9?data.getDate().toString():'0' + data.getDate(); //获取日
    var hours = data.getHours()>9?data.getHours().toString():'0' + data.getHours();
    var minutes = data.getMinutes()>9?data.getMinutes().toString():'0' + data.getMinutes();
    var ss = data.getSeconds()>9?data.getSeconds().toString():'0' + data.getSeconds();
    var time = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":"+ ss;
    return time;
};

/**
 * 时间戳时间格式化
 * @param stamp 时间戳
 * @param format 格式
 * @param zero 是否用0补齐
 * @returns {string|*}
 */
var normalDate = function(stamp, format, zero) {
    var stamp = Number(stamp),
        date = new Date(stamp), formatDate,
        format = format ? format : "yyyy-mm-dd hh:ii:ss",
        zero = (zero === undefined) ? true : zero,
        dateNum = function(num) { return num < 10 ? '0' + num : num; },
        _d = zero ? dateNum : function(s){return s;};

    var year = _d(date.getFullYear()),
        month = _d(date.getMonth() + 1),
        day = _d(date.getDate()),
        hour = _d(date.getHours()),
        minute = _d(date.getMinutes()),
        second = _d(date.getSeconds());

    formatDate = format.replace(/yyyy/i, year).replace(/mm/i, month).replace(/dd/i, day)
        .replace(/hh/i, hour).replace(/ii/i, minute).replace(/ss/i, second);
    return formatDate;
};

/**
 * 把字符串转换成Date对象
 * @param str
 * @returns {Date}
 */
var str2date = function(str) {
    str = str.replace(/-/g, '/');
    return new Date(str);
};

/**
 * 获取字符串格式之间的时间戳
 * @param str
 * @returns {number}
 */
var timestamp = function(str) {
    var timestamp = Date.parse(str2date(str));
    return timestamp;
};

/**
 * 日期对象格式化
 * @param date
 * @param format
 * @returns {XML|string}
 */
var dateformat = function(date, format) {
    var z = {
        M : date.getMonth() + 1,
        d : date.getDate(),
        h : date.getHours(),
        m : date.getMinutes(),
        s : date.getSeconds()
    };
    format = format.replace(/(M+|d+|h+|m+|s+)/g, function(v) {
        return ((v.length > 1 ? "0" : "") + eval('z.' + v.slice(-1))).slice(-2);
    });
    return format.replace(/(y+)/g, function(v) {
        return date.getFullYear().toString().slice(-v.length)
    });
};

var dateNum = function(num) {
    return num < 10 ? '0' + num : num;
};

/**
 * 共用接口调用
 * @param url 接口路径 不包含 domain_url
 * @param data 传递参数
 * @param callback callback函数名
 * @param showloading 是否显示loadding
 * @param isAsync false同步 true异步
 */
var getResult = function(url, data, callback, showloading, isAsync) {
    if (showloading) {
        shownewLoading();
    }
    $.ajax({
        type : 'GET',
        async : typeof isAsync === 'undefined' ? false : isAsync,
        url : domain_url + url,
        data: data,
        dataType : "jsonp",
        jsonp : callback,
        complete: function() {
            if (showloading) {
                hidenewLoading();
            }
        },
        success : function(data) {}
    });
};

var loadData = function(param) {
    var p = $.extend({ url: "", type: "get", async: true, dataType: "jsonp", callbackName: '', callback: null}, param);
    if (p.showload) {
        showLoading();
    }
    var cbName = "";
    var cbFn = null;
    if(!p.callbackName){
        var connt = 0;
        for (var i in param) {
            connt++;
            if (connt == 2) {
                cbName = i;
                cbFn = param[i];
                break;
            }
        }
    }else{
        cbName = p.callbackName;
        cbFn = p.callback;
    }
    if (/test/.test(domain_url)) {
        if (!param.data) {
            param.data = {};
        }
    }
    param.data.enterId = window.enterId;
    return $.ajax({
        type: p.type,
        data: param.data,
        async: p.async,
        url: p.url,
        dataType: p.dataType,
        jsonpCallback: cbName,
        success: function(data) {
            cbFn(data);
        },
        error: function(e,m) {
            if(m=="error"){
                m = "net exception";
            }
            if (p.showError) {
                alert("抱歉请稍后再试");
            }
            if (param.error) { param.error() };
        }
    });
};

/**
 * 字符串拼接
 * @param tpl
 * @returns {{store: *, _: _, toString: toString}}
 */
var simpleTpl = function( tpl ) {
    tpl = $.isArray( tpl ) ? tpl.join( '' ) : (tpl || '');

    return {
        store: tpl,
        _: function() {
            var me = this;
            $.each( arguments, function( index, value ) {
                me.store += value;
            } );
            return this;
        },
        toString: function() {
            return this.store;
        }
    };
};

/**
 * showTips
 * @param word 提示信息
 * @param pos 位置
 * @param timer 停留时间
 */
var aniTrue = true;
var showTips = function(word, pos, timer) {
    if (aniTrue) {
        aniTrue = false;
        var pos = pos || '3.8', timer = timer || 1200;
        $('body').append('<div class="tips none"></div>');
        $('.tips').css({
            'position': 'fixed' ,
            'max-width': '80%' ,
            'top': '60%' ,
            'left': '50%' ,
            'z-index': '999999999999' ,
            'color': 'rgb(255, 255, 255)' ,
            'padding': '12px 15px' ,
            'font-size': '16px',
            'border-radius': '3px' ,
            'margin-left': '-120px' ,
            'background': 'rgba(0, 0, 0, 0.7)' ,
            'text-align': 'center'
        });
        $('.tips').html(word);
        var winW = $(window).width(), winH = $(window).height();
        $('.tips').removeClass('none').css('opacity', '0');
        var tipsW = $('.tips').width(), tipsH = $('.tips').height();
        $('.tips').css({'margin-left': -tipsW/2, '-webkit-transform': "translateY(" + (tipsH - winH)/(pos - 0.8) + "px)"}).removeClass('none');
        $('.tips').animate({'opacity': '1', '-webkit-transform': "translateY(" + (tipsH - winH)/pos + "px)"}, 300, function() {
            setTimeout(function() {
                $('.tips').animate({'opacity':'0'}, 200, function() {
                    $('.tips').addClass('none').css('-webkit-transform', "translateY(" + (tipsH - winH)/(pos - 0.8) + "px)");
                });
            }, timer);
            setTimeout(function() {
                $('.tips').remove();
                aniTrue = true;
            }, timer + 400);
        });
    };
};

/**
 * 根据经纬度计算两点之间的距离
 * @param longitude1，latitude1 第一个点经纬度
 * @param longitude2，latitude2 第二个点经纬度
 * @returns {Number}
 */
var algorithmLonAndLat = function(longitude1, latitude1, longitude2, latitude2) {
    var Lat1 = rad(latitude1); // 纬度
    var Lat2 = rad(latitude2);
    var a = Lat1 - Lat2;//两点纬度之差
    var b = rad(longitude1) - rad(longitude2); //经度之差
    var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a / 2), 2) + Math.cos(Lat1) * Math.cos(Lat2) * Math.pow(Math.sin(b / 2), 2)));//计算两点距离的公式
    s = s * 6378137.0;//弧长乘地球半径（半径为米）
    s = Math.round(s * 10000) / 10000;//精确距离的数值
    return s;
}
function rad(d) {
    return d * Math.PI / 180.00; //角度转换成弧度
}

/**
 * 返回给定范围内的随机数
 * @param min 范围下限（包含）
 * @param max 范围上限（不包含）
 * @returns {Number}
 */
var getRandomArbitrary = function(min, max) {
    return parseInt(Math.random()*(max - min)+min);
};

/**
 * 客户端是否andriod系统
 * @returns {boolean}
 */
var is_android = function() {
    var ua = navigator.userAgent.toLowerCase();
    return ua.indexOf("android") > -1;
};

function formatTime(time) {
    if (typeof time !== "number" || time < 0) {
        return time;
    }
    var hour = parseInt(time / 3600);
    time = time % 3600;
    var minute = parseInt(time / 60);
    time = time % 60;
    var second = time;
    return [ hour, minute, second ].map(function(n) {
        n = n.toString();
        return n[1] ? n : "0" + n;
    }).join(":");
}

function formatLocation(longitude, latitude) {
    if (typeof longitude === "string" && typeof latitude === "string") {
        longitude = parseFloat(longitude);
        latitude = parseFloat(latitude);
    }
    longitude = longitude.toFixed(2);
    latitude = latitude.toFixed(2);
    return {
        longitude: longitude.toString().split("."),
        latitude: latitude.toString().split(".")
    };
}
/**
 *  END OF 数据请求
 */

/**
 *  例：241.10000000000002V 转为  241.10
 */
var formatOverviewData = function(data) {
    if(data && typeof data == "string") return parseFloat(data.replace(/[^\d.]/g,'')).toFixed(2)
    else if(data && typeof data == "number") return data.toFixed(2)
}

var compareObject = function(property){
    return function(a,b){
        var value1 = a[property];
        var value2 = b[property];
        return value2 - value1;
    }
};

var showAlert = function(textHtml){
    $("body .alertPopup").remove();
    $("body").append('<div class="popup alertPopup"><div class="popup-main"><a class="close-btn"><i class="fa fa-times"></i></a>'+
                '<div class="icon-alert"><i class="fa fa-exclamation-triangle"></i></div><p class="popup-tips">'+ textHtml +'</p></div></div>');
    $(".alertPopup .close-btn").click(function(){
        $("body .alertPopup").remove();
    });
};
var hideAlert = function(){
    $("body .alertPopup").remove();
};
var selectLeftNode = function(domId){
    $(".page-sidebar-menu .active").removeClass("active");
    $(".page-sidebar-menu .open").removeClass("open");
    var cm = $("#" + domId);
    cm.addClass("active");
    cm.parent().parent().addClass('active').find("span.arrow").addClass("open")
};