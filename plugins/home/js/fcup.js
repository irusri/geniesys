/**
 * fcup大文件分片上传插件
 * author: lovefc
 * blog：https://lovefc.cn
 * github: https://github.com/lovefc/fcup2
 * gitee: https://gitee.com/lovefc/fcup2
 * time: 2020/04/30 14:21
 */
'use strice';
(function (exports) {
    let fcup = function (config) {
        let that = this;
        if (!new.target) {
            return new fcup();
        };		
        this.datas = [];
        this.id = ''; 
        this.shardsize = '2';
        this.minsize;
        this.maxsize = "200";
		// 检查url
        this.checkurl = '';		
        this.url = '';
        this.headers = {
            "version": "fcup-v2.1"
        }; 
        this.type = '';
        this.apped_data = {};
        this.currentsize = 0;
        this.currenttime = 0;
        this.reStatus = true;
        this.delaytime = 300;
        this.timeout = 10000;
		this.canceStatus = 0;
        this.formdata = new FormData();
        this.xhr = new XMLHttpRequest();
        this.errormsg = {
            1000: "未找到该上传id",
            1001: "不允许上传的文件类型",
            1002: "上传文件过小",
            1003: "上传文件过大",
            1004: "请求超时"
        };
        this.start = function () {};
        this.error = function (err) {
            alert(err)
        };
        this.success = function (res) {
            return true;
        };
        this.checksuccess = function (res) {
            return true;
        };		
        this.progress = function (num) {};
		// 上传检查,可用于分片
		this.upcheck = function (md5) {
			if(!this.checkurl){
				return false;
			}
			this.formdata.append('file_name',that.filename);
			this.formdata.append('file_md5',md5);
			this.formdata.append('file_size',that.size);
			this.formdata.append('file_total',that.shardTotal);
            if (this.apped_data) {
                this.formdata.append("apped_data", JSON.stringify(this.apped_data));
            }
            let xhrs = new XMLHttpRequest();
            let header = this.headers;
            xhrs.open('POST', this.checkurl, false); // 同步
            if (this.headers) {
                if (Object.prototype.toString.call(header) === '[object Object]') {
                    for (let i in header) {
                        xhrs.setRequestHeader(i, header[i]);
                    };
                }
            }
            xhrs.onreadystatechange = function () {
                if (xhrs.status == 404) {
                    return;
                }
                if ((xhrs.readyState == 4) && (xhrs.status == 200)) {
					if (typeof that.checksuccess == 'function') {
                           that.alreadyExists = that.checksuccess(xhrs.responseText);
				    }
                 }
			}
            xhrs.send(this.formdata);
            this.formdata.delete('file_md5');
			this.formdata.delete('file_name');
			this.formdata.delete('file_size');
			this.formdata.delete('file_total');
            if (that.apped_data) {
                this.formdata.delete("apped_data");
            }
			xhrs = null;
		};
		// 设置当前切片
		this.setshard = function (index) {
			index = index < 1 ? 1 : index;
            that.k = index - 1;
            that.shardIndex = index;			
		};
		// 取消上传
		this.cancel = function () {		
		    that.cancelStatus = 1;
		};		
		// 配置参数
        this.exetnd = function (jb) {
            if (Object.prototype.toString.call(jb) === '[object Object]') {
                for (let i in jb) {
                    that[i] = jb[i];
                };
                this.init();
            }
        };
		// 初始化操作
        this.init = function () {
            if (!this.id) {
                return false;
            }
            let id = this.id;
            this.dom = document.querySelector(`#${id}`);
            if (this.dom === null) {
                this.error(this.errormsg['1000']);
                return;
            }
            this.domtext = this.dom.innerHTML;
            this.credom();
            this.dom.onclick = function () {
                that.filedom.click();
            };
            let evt = document.createEvent("HTMLEvents");
            evt.initEvent("change", false, false);
            this.filedom.dispatchEvent(evt);
        };
		// 注销
        this.destroy = function () {
            this.datas = [];
            this.file = null;
        };
		// 创建元素
        this.credom = function () {
            let up_id = 'fcup_' + this.id + '_' + new Date().getTime();
            this.dom.innerHTML = this.domtext + '<input type="file" id="' + up_id + '" style="display:none;">';
            this.filedom = document.getElementById(up_id);
            this.filedom.addEventListener('change', this.onevent, false);
        };
        // 触发事件
        this.onevent = function () {
            that.start();
            let files = that.filedom.files[0];
            that.upload(files);
        };
		// 上传处理
        this.post = function (md5) {
            let shardCount = this.shardTotal;
            let shardIndex = this.shardIndex;
			if(this.cancelStatus == 1){
				return false;
			}
            if (shardIndex >= (shardCount + 1) || (this.reStatus == false)) {
                return false;
            }
            let file = this.datas[this.k];
            this.formdata.append("file_data", file['file_data']);
            this.formdata.append("file_name", file['file_name']);
            this.formdata.append("file_size", file['file_size']);
            this.formdata.append("file_chunksize", file['file_chunksize']);
            this.formdata.append("file_suffix", file['file_suffix']);
            this.formdata.append("file_total", shardCount);
            this.formdata.append("file_md5", md5);
            this.formdata.append("file_index", this.shardIndex);
            this.currentsize += file['file_chunksize'];
            if (this.apped_data) {
                this.formdata.append("apped_data", JSON.stringify(this.apped_data));
            }
            let xhrs = this.xhr;
            let header = this.headers;
            xhrs.open('POST', this.url, true);
            if (this.headers) {
                if (Object.prototype.toString.call(header) === '[object Object]') {
                    for (let i in header) {
                        xhrs.setRequestHeader(i, header[i]);
                    };
                }
            }
            xhrs.timeout = this.timeout;
            xhrs.onloadstart = function () {
                let progress_num = that.getpercent(shardIndex, shardCount);
                that.progress_num = progress_num > 100 ? 100 : progress_num;
                that.startTime = new Date().getTime();
            };
            xhrs.onload = function () {
                that.post(md5);
            };
            xhrs.onreadystatechange = function () {
                that.result(xhrs);
            };
            xhrs.ontimeout = function (e) {
                that.error(that.errormsg['1004']);
            };
            xhrs.send(this.formdata);
            this.formdata.delete('file_data');
            this.formdata.delete('file_name');
            this.formdata.delete('file_size');
            this.formdata.delete("file_chunksize");
            this.formdata.delete("file_suffix");
            this.formdata.delete('file_md5');
            this.formdata.delete('file_total');
            this.formdata.delete('file_index');
            if (that.apped_data) {
                this.formdata.delete("apped_data");
            }
            this.k++;
            this.shardIndex++;
        };
		// 时间计算
        this.computeTime = function (totalTime) {
            if (totalTime < 1000) {
                totalTime = (totalTime / 1000).toFixed(4) + '秒';
            } else {
                if (totalTime >= (1000 * 60)) {
                    totalTime = Math.floor(totalTime / (1000 * 60)) + '分钟';
                } else {
                    totalTime = (totalTime / 1000).toFixed(4) + '秒';
                }
            }
            return totalTime;
        };
		// 结果处理
        this.result = function (xhr) {
            that.reStatus = false;
            if (xhr.status == 404) {
                return;
            }
            if ((xhr.readyState == 4) && (xhr.status == 200)) {
                let pertime = Math.round(new Date().getTime() - that.startTime);
                that.shardTime += pertime;
                if (that.progress_num < 80) {
                    that.cachepertime = pertime;
                }
				let total_time = that.cachepertime * that.shardTotal;
				if(that.shardTotal == 1){
					total_time = that.shardTime;	
			    }
                let use_time = that.shardTime;
                let total_times = that.computeTime(total_time);
                let use_times = that.computeTime(use_time);
                let type = xhr.getResponseHeader("Content-Type");
                let other = {
                    'totaltime': total_times,
                    'usetime': use_times,
                    'current': this.getconver(that.currentsize),
                    "surplus": this.getconver(that.size - that.currentsize),
                    "type": type
                };
                if (typeof that.progress == 'function') {
                    that.progress(that.progress_num, other);
                }
                if (typeof that.success == 'function') {
                    other.progress = that.progress_num;
                    if (that.progress_num == 100) {
                        setTimeout(function () {
                            that.reStatus = that.success(xhr.responseText, other);
                            that.destroy();
                        }, that.delaytime);
                    } else {
                        that.reStatus = that.success(xhr.responseText);
                    }
                }
            } else {
                if (typeof that.beforeSend == 'function') {
                    that.beforeSend();
                }
            }
        };
		// 参数解析
        this.postData = function (i, start, end) {
            this.datas[i] = [];
            let file = this.file.slice(start, end);
            this.datas[i]["file_data"] = file;
            this.datas[i]["file_name"] = this.filename;
            this.datas[i]["file_size"] = this.size;
            this.datas[i]["file_chunksize"] = file.size;
            this.datas[i]["file_suffix"] = this.suffix;
        };
		// 大小格式
        this.limitFileSize = function (limitSize) {
            var arr = ["KB", "MB", "GB"],
                limit = limitSize.toUpperCase(),
                limitNum = 0;
            for (var i = 0; i < arr.length; i++) {
                var leval = limit.indexOf(arr[i]);
                if (leval > -1) {
                    limitNum = parseInt(limit.substr(0, leval)) * Math.pow(1024, (i + 1));
                    break;
                }
            }
            return limitNum;
        };
        this.getpercent = function (num, total) {
            num = parseFloat(num);
            total = parseFloat(total);
            if (isNaN(num) || isNaN(total)) {
                return "-";
            }
            return total <= 0 ? 0 : (Math.round(num / total * 10000) / 100.00);
        };
        this.getconver = function (limit) {
            let size = "";
            if (limit < 0.1 * 1024) {
                size = limit.toFixed(2) + "B";
            } else if (limit < 0.1 * 1024 * 1024) {
                size = (limit / 1024).toFixed(2) + "KB";
            } else {
                size = (limit / (1024 * 1024)).toFixed(2) + "MB";
            }
            let sizestr = size + "";
            let len = sizestr.indexOf("\.");
            let dec = sizestr.substr(len + 1, 2);
            if (dec == "00") {
                return sizestr.substring(0, len) + sizestr.substr(len + 3, 2);
            }
            return sizestr;
        };
		// 上传主函数
        this.upload = function (file) {
            if (!file) {
                return;
            }
            this.credom();
            this.datas = [];
            this.progress_num = 0;
            this.currentsize = 0;
            this.reStatus = true;
            this.shardTime = 0;
            this.file = file;
            this.size = file.size;
            this.filename = file.name;
			this.alreadyExists = true;
            let ext = this.filename.lastIndexOf("."),
                ext_len = this.filename.length;
            this.suffix = this.filename.substring(ext + 1, ext_len).toLowerCase();
            if (this.type) {
                let uptype = this.type.split(",");
                if (uptype.indexOf(this.suffix) == -1) {
                    this.error(this.errormsg['1001']);
                    return;
                }
            }
            if (this.minsize) {
                let limitNum = this.limitFileSize(this.minsize + 'MB');
                if (file.size < limitNum) {
                    this.error(this.errormsg['1002']);
                    return;
                }
            }      
            if (this.maxsize) {
                let limitNum = this.limitFileSize(this.maxsize + 'MB');
                if (file.size > limitNum) {
                    this.error(this.errormsg['1003']);
                    return;
                }
            }
            let i = 0,
                blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice,
                chunkSize = (+this.shardsize) * 1024 * 1024,
                chunks = Math.ceil(file.size / chunkSize),
                currentChunk = 0,
                md5id = 0,
                fileReader = new FileReader(),
                spark = new SparkMD5.ArrayBuffer();

            this.shardTotal = chunks;
            let frOnload = function (e) {
                spark.append(e.target.result); 
                currentChunk++;
                if (currentChunk < chunks) {
                    loadNext();
                } else {
                    md5id = spark.end(); // 获取md5
					that.md5str = md5id;
                    that.k = 0;
                    that.shardIndex = 1;
					that.cachepertime = 0;		
                    that.startUpload();					

                }
            };
            let frOnerror = function () {};
            fileReader.onload = frOnload;
            fileReader.onerror = frOnerror;
            function loadNext() {
                let start = currentChunk * chunkSize,
                    end = ((start + chunkSize) >= file.size) ? file.size : start + chunkSize,
                    filedata = file.slice(start, end);
                that.postData(i, start, end);
                fileReader.readAsArrayBuffer(blobSlice.call(file, start, end));
                i++;
            };
            loadNext();
        };
		// 开始上传
		this.startUpload = function(){
		    that.upcheck(that.md5str); // 检查上传
			if(that.alreadyExists == false){
			    return;
			}else{
				that.cancelStatus = 0;
                that.post(that.md5str);
			}			
		};
        this.exetnd(config);
    };
    exports.fcup = fcup;
})(this);
// spark-md5文件 用于计算文件md5值
(function (factory) { if (typeof exports === "object") { module.exports = factory() } else if (typeof define === "function" && define.amd) { define(factory) } else { var glob; try { glob = window } catch (e) { glob = self } glob.SparkMD5 = factory() } })(function (undefined) { "use strict"; var add32 = function (a, b) { return a + b & 4294967295 }, hex_chr = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"]; function cmn(q, a, b, x, s, t) { a = add32(add32(a, q), add32(x, t)); return add32(a << s | a >>> 32 - s, b) } function md5cycle(x, k) { var a = x[0], b = x[1], c = x[2], d = x[3]; a += (b & c | ~b & d) + k[0] - 680876936 | 0; a = (a << 7 | a >>> 25) + b | 0; d += (a & b | ~a & c) + k[1] - 389564586 | 0; d = (d << 12 | d >>> 20) + a | 0; c += (d & a | ~d & b) + k[2] + 606105819 | 0; c = (c << 17 | c >>> 15) + d | 0; b += (c & d | ~c & a) + k[3] - 1044525330 | 0; b = (b << 22 | b >>> 10) + c | 0; a += (b & c | ~b & d) + k[4] - 176418897 | 0; a = (a << 7 | a >>> 25) + b | 0; d += (a & b | ~a & c) + k[5] + 1200080426 | 0; d = (d << 12 | d >>> 20) + a | 0; c += (d & a | ~d & b) + k[6] - 1473231341 | 0; c = (c << 17 | c >>> 15) + d | 0; b += (c & d | ~c & a) + k[7] - 45705983 | 0; b = (b << 22 | b >>> 10) + c | 0; a += (b & c | ~b & d) + k[8] + 1770035416 | 0; a = (a << 7 | a >>> 25) + b | 0; d += (a & b | ~a & c) + k[9] - 1958414417 | 0; d = (d << 12 | d >>> 20) + a | 0; c += (d & a | ~d & b) + k[10] - 42063 | 0; c = (c << 17 | c >>> 15) + d | 0; b += (c & d | ~c & a) + k[11] - 1990404162 | 0; b = (b << 22 | b >>> 10) + c | 0; a += (b & c | ~b & d) + k[12] + 1804603682 | 0; a = (a << 7 | a >>> 25) + b | 0; d += (a & b | ~a & c) + k[13] - 40341101 | 0; d = (d << 12 | d >>> 20) + a | 0; c += (d & a | ~d & b) + k[14] - 1502002290 | 0; c = (c << 17 | c >>> 15) + d | 0; b += (c & d | ~c & a) + k[15] + 1236535329 | 0; b = (b << 22 | b >>> 10) + c | 0; a += (b & d | c & ~d) + k[1] - 165796510 | 0; a = (a << 5 | a >>> 27) + b | 0; d += (a & c | b & ~c) + k[6] - 1069501632 | 0; d = (d << 9 | d >>> 23) + a | 0; c += (d & b | a & ~b) + k[11] + 643717713 | 0; c = (c << 14 | c >>> 18) + d | 0; b += (c & a | d & ~a) + k[0] - 373897302 | 0; b = (b << 20 | b >>> 12) + c | 0; a += (b & d | c & ~d) + k[5] - 701558691 | 0; a = (a << 5 | a >>> 27) + b | 0; d += (a & c | b & ~c) + k[10] + 38016083 | 0; d = (d << 9 | d >>> 23) + a | 0; c += (d & b | a & ~b) + k[15] - 660478335 | 0; c = (c << 14 | c >>> 18) + d | 0; b += (c & a | d & ~a) + k[4] - 405537848 | 0; b = (b << 20 | b >>> 12) + c | 0; a += (b & d | c & ~d) + k[9] + 568446438 | 0; a = (a << 5 | a >>> 27) + b | 0; d += (a & c | b & ~c) + k[14] - 1019803690 | 0; d = (d << 9 | d >>> 23) + a | 0; c += (d & b | a & ~b) + k[3] - 187363961 | 0; c = (c << 14 | c >>> 18) + d | 0; b += (c & a | d & ~a) + k[8] + 1163531501 | 0; b = (b << 20 | b >>> 12) + c | 0; a += (b & d | c & ~d) + k[13] - 1444681467 | 0; a = (a << 5 | a >>> 27) + b | 0; d += (a & c | b & ~c) + k[2] - 51403784 | 0; d = (d << 9 | d >>> 23) + a | 0; c += (d & b | a & ~b) + k[7] + 1735328473 | 0; c = (c << 14 | c >>> 18) + d | 0; b += (c & a | d & ~a) + k[12] - 1926607734 | 0; b = (b << 20 | b >>> 12) + c | 0; a += (b ^ c ^ d) + k[5] - 378558 | 0; a = (a << 4 | a >>> 28) + b | 0; d += (a ^ b ^ c) + k[8] - 2022574463 | 0; d = (d << 11 | d >>> 21) + a | 0; c += (d ^ a ^ b) + k[11] + 1839030562 | 0; c = (c << 16 | c >>> 16) + d | 0; b += (c ^ d ^ a) + k[14] - 35309556 | 0; b = (b << 23 | b >>> 9) + c | 0; a += (b ^ c ^ d) + k[1] - 1530992060 | 0; a = (a << 4 | a >>> 28) + b | 0; d += (a ^ b ^ c) + k[4] + 1272893353 | 0; d = (d << 11 | d >>> 21) + a | 0; c += (d ^ a ^ b) + k[7] - 155497632 | 0; c = (c << 16 | c >>> 16) + d | 0; b += (c ^ d ^ a) + k[10] - 1094730640 | 0; b = (b << 23 | b >>> 9) + c | 0; a += (b ^ c ^ d) + k[13] + 681279174 | 0; a = (a << 4 | a >>> 28) + b | 0; d += (a ^ b ^ c) + k[0] - 358537222 | 0; d = (d << 11 | d >>> 21) + a | 0; c += (d ^ a ^ b) + k[3] - 722521979 | 0; c = (c << 16 | c >>> 16) + d | 0; b += (c ^ d ^ a) + k[6] + 76029189 | 0; b = (b << 23 | b >>> 9) + c | 0; a += (b ^ c ^ d) + k[9] - 640364487 | 0; a = (a << 4 | a >>> 28) + b | 0; d += (a ^ b ^ c) + k[12] - 421815835 | 0; d = (d << 11 | d >>> 21) + a | 0; c += (d ^ a ^ b) + k[15] + 530742520 | 0; c = (c << 16 | c >>> 16) + d | 0; b += (c ^ d ^ a) + k[2] - 995338651 | 0; b = (b << 23 | b >>> 9) + c | 0; a += (c ^ (b | ~d)) + k[0] - 198630844 | 0; a = (a << 6 | a >>> 26) + b | 0; d += (b ^ (a | ~c)) + k[7] + 1126891415 | 0; d = (d << 10 | d >>> 22) + a | 0; c += (a ^ (d | ~b)) + k[14] - 1416354905 | 0; c = (c << 15 | c >>> 17) + d | 0; b += (d ^ (c | ~a)) + k[5] - 57434055 | 0; b = (b << 21 | b >>> 11) + c | 0; a += (c ^ (b | ~d)) + k[12] + 1700485571 | 0; a = (a << 6 | a >>> 26) + b | 0; d += (b ^ (a | ~c)) + k[3] - 1894986606 | 0; d = (d << 10 | d >>> 22) + a | 0; c += (a ^ (d | ~b)) + k[10] - 1051523 | 0; c = (c << 15 | c >>> 17) + d | 0; b += (d ^ (c | ~a)) + k[1] - 2054922799 | 0; b = (b << 21 | b >>> 11) + c | 0; a += (c ^ (b | ~d)) + k[8] + 1873313359 | 0; a = (a << 6 | a >>> 26) + b | 0; d += (b ^ (a | ~c)) + k[15] - 30611744 | 0; d = (d << 10 | d >>> 22) + a | 0; c += (a ^ (d | ~b)) + k[6] - 1560198380 | 0; c = (c << 15 | c >>> 17) + d | 0; b += (d ^ (c | ~a)) + k[13] + 1309151649 | 0; b = (b << 21 | b >>> 11) + c | 0; a += (c ^ (b | ~d)) + k[4] - 145523070 | 0; a = (a << 6 | a >>> 26) + b | 0; d += (b ^ (a | ~c)) + k[11] - 1120210379 | 0; d = (d << 10 | d >>> 22) + a | 0; c += (a ^ (d | ~b)) + k[2] + 718787259 | 0; c = (c << 15 | c >>> 17) + d | 0; b += (d ^ (c | ~a)) + k[9] - 343485551 | 0; b = (b << 21 | b >>> 11) + c | 0; x[0] = a + x[0] | 0; x[1] = b + x[1] | 0; x[2] = c + x[2] | 0; x[3] = d + x[3] | 0 } function md5blk(s) { var md5blks = [], i; for (i = 0; i < 64; i += 4) { md5blks[i >> 2] = s.charCodeAt(i) + (s.charCodeAt(i + 1) << 8) + (s.charCodeAt(i + 2) << 16) + (s.charCodeAt(i + 3) << 24) } return md5blks } function md5blk_array(a) { var md5blks = [], i; for (i = 0; i < 64; i += 4) { md5blks[i >> 2] = a[i] + (a[i + 1] << 8) + (a[i + 2] << 16) + (a[i + 3] << 24) } return md5blks } function md51(s) { var n = s.length, state = [1732584193, -271733879, -1732584194, 271733878], i, length, tail, tmp, lo, hi; for (i = 64; i <= n; i += 64) { md5cycle(state, md5blk(s.substring(i - 64, i))) } s = s.substring(i - 64); length = s.length; tail = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; for (i = 0; i < length; i += 1) { tail[i >> 2] |= s.charCodeAt(i) << (i % 4 << 3) } tail[i >> 2] |= 128 << (i % 4 << 3); if (i > 55) { md5cycle(state, tail); for (i = 0; i < 16; i += 1) { tail[i] = 0 } } tmp = n * 8; tmp = tmp.toString(16).match(/(.*?)(.{0,8})$/); lo = parseInt(tmp[2], 16); hi = parseInt(tmp[1], 16) || 0; tail[14] = lo; tail[15] = hi; md5cycle(state, tail); return state } function md51_array(a) { var n = a.length, state = [1732584193, -271733879, -1732584194, 271733878], i, length, tail, tmp, lo, hi; for (i = 64; i <= n; i += 64) { md5cycle(state, md5blk_array(a.subarray(i - 64, i))) } a = i - 64 < n ? a.subarray(i - 64) : new Uint8Array(0); length = a.length; tail = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; for (i = 0; i < length; i += 1) { tail[i >> 2] |= a[i] << (i % 4 << 3) } tail[i >> 2] |= 128 << (i % 4 << 3); if (i > 55) { md5cycle(state, tail); for (i = 0; i < 16; i += 1) { tail[i] = 0 } } tmp = n * 8; tmp = tmp.toString(16).match(/(.*?)(.{0,8})$/); lo = parseInt(tmp[2], 16); hi = parseInt(tmp[1], 16) || 0; tail[14] = lo; tail[15] = hi; md5cycle(state, tail); return state } function rhex(n) { var s = "", j; for (j = 0; j < 4; j += 1) { s += hex_chr[n >> j * 8 + 4 & 15] + hex_chr[n >> j * 8 & 15] } return s } function hex(x) { var i; for (i = 0; i < x.length; i += 1) { x[i] = rhex(x[i]) } return x.join("") } if (hex(md51("hello")) !== "5d41402abc4b2a76b9719d911017c592") { add32 = function (x, y) { var lsw = (x & 65535) + (y & 65535), msw = (x >> 16) + (y >> 16) + (lsw >> 16); return msw << 16 | lsw & 65535 } } if (typeof ArrayBuffer !== "undefined" && !ArrayBuffer.prototype.slice) { (function () { function clamp(val, length) { val = val | 0 || 0; if (val < 0) { return Math.max(val + length, 0) } return Math.min(val, length) } ArrayBuffer.prototype.slice = function (from, to) { var length = this.byteLength, begin = clamp(from, length), end = length, num, target, targetArray, sourceArray; if (to !== undefined) { end = clamp(to, length) } if (begin > end) { return new ArrayBuffer(0) } num = end - begin; target = new ArrayBuffer(num); targetArray = new Uint8Array(target); sourceArray = new Uint8Array(this, begin, num); targetArray.set(sourceArray); return target } })() } function toUtf8(str) { if (/[\u0080-\uFFFF]/.test(str)) { str = unescape(encodeURIComponent(str)) } return str } function utf8Str2ArrayBuffer(str, returnUInt8Array) { var length = str.length, buff = new ArrayBuffer(length), arr = new Uint8Array(buff), i; for (i = 0; i < length; i += 1) { arr[i] = str.charCodeAt(i) } return returnUInt8Array ? arr : buff } function arrayBuffer2Utf8Str(buff) { return String.fromCharCode.apply(null, new Uint8Array(buff)) } function concatenateArrayBuffers(first, second, returnUInt8Array) { var result = new Uint8Array(first.byteLength + second.byteLength); result.set(new Uint8Array(first)); result.set(new Uint8Array(second), first.byteLength); return returnUInt8Array ? result : result.buffer } function hexToBinaryString(hex) { var bytes = [], length = hex.length, x; for (x = 0; x < length - 1; x += 2) { bytes.push(parseInt(hex.substr(x, 2), 16)) } return String.fromCharCode.apply(String, bytes) } function SparkMD5() { this.reset() } SparkMD5.prototype.append = function (str) { this.appendBinary(toUtf8(str)); return this }; SparkMD5.prototype.appendBinary = function (contents) { this._buff += contents; this._length += contents.length; var length = this._buff.length, i; for (i = 64; i <= length; i += 64) { md5cycle(this._hash, md5blk(this._buff.substring(i - 64, i))) } this._buff = this._buff.substring(i - 64); return this }; SparkMD5.prototype.end = function (raw) { var buff = this._buff, length = buff.length, i, tail = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], ret; for (i = 0; i < length; i += 1) { tail[i >> 2] |= buff.charCodeAt(i) << (i % 4 << 3) } this._finish(tail, length); ret = hex(this._hash); if (raw) { ret = hexToBinaryString(ret) } this.reset(); return ret }; SparkMD5.prototype.reset = function () { this._buff = ""; this._length = 0; this._hash = [1732584193, -271733879, -1732584194, 271733878]; return this }; SparkMD5.prototype.getState = function () { return { buff: this._buff, length: this._length, hash: this._hash } }; SparkMD5.prototype.setState = function (state) { this._buff = state.buff; this._length = state.length; this._hash = state.hash; return this }; SparkMD5.prototype.destroy = function () { delete this._hash; delete this._buff; delete this._length }; SparkMD5.prototype._finish = function (tail, length) { var i = length, tmp, lo, hi; tail[i >> 2] |= 128 << (i % 4 << 3); if (i > 55) { md5cycle(this._hash, tail); for (i = 0; i < 16; i += 1) { tail[i] = 0 } } tmp = this._length * 8; tmp = tmp.toString(16).match(/(.*?)(.{0,8})$/); lo = parseInt(tmp[2], 16); hi = parseInt(tmp[1], 16) || 0; tail[14] = lo; tail[15] = hi; md5cycle(this._hash, tail) }; SparkMD5.hash = function (str, raw) { return SparkMD5.hashBinary(toUtf8(str), raw) }; SparkMD5.hashBinary = function (content, raw) { var hash = md51(content), ret = hex(hash); return raw ? hexToBinaryString(ret) : ret }; SparkMD5.ArrayBuffer = function () { this.reset() }; SparkMD5.ArrayBuffer.prototype.append = function (arr) { var buff = concatenateArrayBuffers(this._buff.buffer, arr, true), length = buff.length, i; this._length += arr.byteLength; for (i = 64; i <= length; i += 64) { md5cycle(this._hash, md5blk_array(buff.subarray(i - 64, i))) } this._buff = i - 64 < length ? new Uint8Array(buff.buffer.slice(i - 64)) : new Uint8Array(0); return this }; SparkMD5.ArrayBuffer.prototype.end = function (raw) { var buff = this._buff, length = buff.length, tail = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], i, ret; for (i = 0; i < length; i += 1) { tail[i >> 2] |= buff[i] << (i % 4 << 3) } this._finish(tail, length); ret = hex(this._hash); if (raw) { ret = hexToBinaryString(ret) } this.reset(); return ret }; SparkMD5.ArrayBuffer.prototype.reset = function () { this._buff = new Uint8Array(0); this._length = 0; this._hash = [1732584193, -271733879, -1732584194, 271733878]; return this }; SparkMD5.ArrayBuffer.prototype.getState = function () { var state = SparkMD5.prototype.getState.call(this); state.buff = arrayBuffer2Utf8Str(state.buff); return state }; SparkMD5.ArrayBuffer.prototype.setState = function (state) { state.buff = utf8Str2ArrayBuffer(state.buff, true); return SparkMD5.prototype.setState.call(this, state) }; SparkMD5.ArrayBuffer.prototype.destroy = SparkMD5.prototype.destroy; SparkMD5.ArrayBuffer.prototype._finish = SparkMD5.prototype._finish; SparkMD5.ArrayBuffer.hash = function (arr, raw) { var hash = md51_array(new Uint8Array(arr)), ret = hex(hash); return raw ? hexToBinaryString(ret) : ret }; return SparkMD5 });