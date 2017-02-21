function isMobileOut() {
    if (navigator.userAgent.toLowerCase().indexOf("android") > -1 || navigator.userAgent.toLowerCase().indexOf("blackberry9500") > -1 || navigator.userAgent.toLowerCase().indexOf("blackberry9530") > -1 || navigator.userAgent.toLowerCase().indexOf("cupcake") > -1 || navigator.userAgent.toLowerCase().indexOf("dream") > -1 || navigator.userAgent.toLowerCase().indexOf("incognito") > -1 || navigator.userAgent.toLowerCase().indexOf("iphone") > -1 || navigator.userAgent.toLowerCase().indexOf("ipod") > -1 || navigator.userAgent.toLowerCase().indexOf("ipad") > -1 || navigator.userAgent.toLowerCase().indexOf("mini") > -1 || navigator.userAgent.toLowerCase().indexOf("webos") > -1 || navigator.userAgent.toLowerCase().indexOf("webmate") > -1 || navigator.userAgent.toLowerCase().indexOf("2.0 mmp") > -1 || navigator.userAgent.toLowerCase().indexOf("240×320") > -1 || navigator.userAgent.toLowerCase().indexOf("asus") > -1 || navigator.userAgent.toLowerCase().indexOf("au-mic") > -1 || navigator.userAgent.toLowerCase().indexOf("alcatel") > -1 || navigator.userAgent.toLowerCase().indexOf("amoi") > -1 || navigator.userAgent.toLowerCase().indexOf("audiovox") > -1 || navigator.userAgent.toLowerCase().indexOf("avantgo") > -1 || navigator.userAgent.toLowerCase().indexOf("benq") > -1 || navigator.userAgent.toLowerCase().indexOf("bird") > -1 || navigator.userAgent.toLowerCase().indexOf("blackberry") > -1 || navigator.userAgent.toLowerCase().indexOf("blazer") > -1 || navigator.userAgent.toLowerCase().indexOf("cdm") > -1 || navigator.userAgent.toLowerCase().indexOf("cellphone") > -1 || navigator.userAgent.toLowerCase().indexOf("ddipocket") > -1 || navigator.userAgent.toLowerCase().indexOf("danger") > -1 || navigator.userAgent.toLowerCase().indexOf("docomo") > -1 || navigator.userAgent.toLowerCase().indexOf("elaine/3.0") > -1 || navigator.userAgent.toLowerCase().indexOf("ericsson") > -1 || navigator.userAgent.toLowerCase().indexOf("eudoraweb") > -1 || navigator.userAgent.toLowerCase().indexOf("fly") > -1 || navigator.userAgent.toLowerCase().indexOf("hp.ipaq") > -1 || navigator.userAgent.toLowerCase().indexOf("haier") > -1 || navigator.userAgent.toLowerCase().indexOf("huawei") > -1 || navigator.userAgent.toLowerCase().indexOf("iemobile") > -1 || navigator.userAgent.toLowerCase().indexOf("j-phone") > -1 || navigator.userAgent.toLowerCase().indexOf("kddi") > -1 || navigator.userAgent.toLowerCase().indexOf("konka") > -1 || navigator.userAgent.toLowerCase().indexOf("kwc") > -1 || navigator.userAgent.toLowerCase().indexOf("kyocera/wx310k") > -1 || navigator.userAgent.toLowerCase().indexOf("lg") > -1 || navigator.userAgent.toLowerCase().indexOf("lg/u990") > -1 || navigator.userAgent.toLowerCase().indexOf("lenovo") > -1 || navigator.userAgent.toLowerCase().indexOf("midp-2.0") > -1 || navigator.userAgent.toLowerCase().indexOf("mmef20") > -1 || navigator.userAgent.toLowerCase().indexOf("mot-v") > -1 || navigator.userAgent.toLowerCase().indexOf("mobilephone") > -1 || navigator.userAgent.toLowerCase().indexOf("motorola") > -1 || navigator.userAgent.toLowerCase().indexOf("newgen") > -1 || navigator.userAgent.toLowerCase().indexOf("netfront") > -1 || navigator.userAgent.toLowerCase().indexOf("newt") > -1 || navigator.userAgent.toLowerCase().indexOf("nintendo wii") > -1 || navigator.userAgent.toLowerCase().indexOf("nitro") > -1 || navigator.userAgent.toLowerCase().indexOf("nokia") > -1 || navigator.userAgent.toLowerCase().indexOf("novarra") > -1 || navigator.userAgent.toLowerCase().indexOf("o2") > -1 || navigator.userAgent.toLowerCase().indexOf("opera mini") > -1 || navigator.userAgent.toLowerCase().indexOf("opera.mobi") > -1 || navigator.userAgent.toLowerCase().indexOf("pantech") > -1 || navigator.userAgent.toLowerCase().indexOf("pdxgw") > -1 || navigator.userAgent.toLowerCase().indexOf("pg") > -1 || navigator.userAgent.toLowerCase().indexOf("ppc") > -1 || navigator.userAgent.toLowerCase().indexOf("pt") > -1 || navigator.userAgent.toLowerCase().indexOf("palm") > -1 || navigator.userAgent.toLowerCase().indexOf("panasonic") > -1 || navigator.userAgent.toLowerCase().indexOf("philips") > -1 || navigator.userAgent.toLowerCase().indexOf("playstation portable") > -1 || navigator.userAgent.toLowerCase().indexOf("proxinet") > -1 || navigator.userAgent.toLowerCase().indexOf("proxinet") > -1 || navigator.userAgent.toLowerCase().indexOf("qtek") > -1 || navigator.userAgent.toLowerCase().indexOf("sch") > -1 || navigator.userAgent.toLowerCase().indexOf("sec") > -1 || navigator.userAgent.toLowerCase().indexOf("sgh") > -1 || navigator.userAgent.toLowerCase().indexOf("sharp-tq-gx10") > -1 || navigator.userAgent.toLowerCase().indexOf("sie") > -1 || navigator.userAgent.toLowerCase().indexOf("sph") > -1 || navigator.userAgent.toLowerCase().indexOf("sagem") > -1 || navigator.userAgent.toLowerCase().indexOf("samsung") > -1 || navigator.userAgent.toLowerCase().indexOf("sanyo") > -1 || navigator.userAgent.toLowerCase().indexOf("sendo") > -1 || navigator.userAgent.toLowerCase().indexOf("sharp") > -1 || navigator.userAgent.toLowerCase().indexOf("small") > -1 || navigator.userAgent.toLowerCase().indexOf("smartphone") > -1 || navigator.userAgent.toLowerCase().indexOf("softbank") > -1 || navigator.userAgent.toLowerCase().indexOf("sonyericsson") > -1 || navigator.userAgent.toLowerCase().indexOf("symbian") > -1 || navigator.userAgent.toLowerCase().indexOf("symbian os") > -1 || navigator.userAgent.toLowerCase().indexOf("symbianos") > -1 || navigator.userAgent.toLowerCase().indexOf("ts21i-10") > -1 || navigator.userAgent.toLowerCase().indexOf("toshiba") > -1 || navigator.userAgent.toLowerCase().indexOf("treo") > -1 || navigator.userAgent.toLowerCase().indexOf("up.browser") > -1 || navigator.userAgent.toLowerCase().indexOf("up.link") > -1 || navigator.userAgent.toLowerCase().indexOf("uts") > -1 || navigator.userAgent.toLowerCase().indexOf("vertu") > -1 || navigator.userAgent.toLowerCase().indexOf("willcome") > -1 || navigator.userAgent.toLowerCase().indexOf("winwap") > -1 || navigator.userAgent.toLowerCase().indexOf("windows ce") > -1 || navigator.userAgent.toLowerCase().indexOf("windows.ce") > -1 || navigator.userAgent.toLowerCase().indexOf("xda") > -1 || navigator.userAgent.toLowerCase().indexOf("zte") > -1 || navigator.userAgent.toLowerCase().indexOf("dopod") > -1 || navigator.userAgent.toLowerCase().indexOf("hiptop") > -1 || navigator.userAgent.toLowerCase().indexOf("htc") > -1 || navigator.userAgent.toLowerCase().indexOf("i-mobile") > -1 || navigator.userAgent.toLowerCase().indexOf("nokia") > -1 || navigator.userAgent.toLowerCase().indexOf("portalmmm") > -1) {
        if (navigator.platform.toLowerCase().indexOf("win32") == -1 && navigator.platform.toLowerCase().indexOf("win64") == -1) {
            return true
        } else {
            return false
        }
    } else {
        return false
    }
}
if (isMobileOut()) {
    $("head").append('<meta name="viewport" id="vpgenieMenu" content="width=device-width, minimum-scale = 1.0, maximum-scale = 1.0, initial-scale=1.0, user-scalable=no"/>')
}(function(e) {
    var t = {
        genieMenuCreate: function(t) {
            function C(e, t, n) {
                if (t.addEventListener) t.addEventListener(e, n, false);
                else if (t.attachEvent) {
                    t.attachEvent("on" + e, n)

                } else {
                    t[e] = n
                }
            }

            function k(e) {
                s[e] = false
            }

            function L(t) {
                if (t.which == 1 || t.type == "touchstart") {
                    t.preventDefault();
                    if (!e("#" + E).hasClass("open")) {
                        a = true;
                        if (i.drag) {
                            D("menudragstart")
                        }
                        if (!p) {
                            t.preventDefault();
                            try {
                                f = t.clientX;
                                l = t.clientX;
                                c = t.clientY;
                                h = t.clientY
                            } catch (n) {}
                        } else {
                            try {
                                f = t.touches[0].pageX;
                                l = t.touches[0].pageX;
                                c = t.touches[0].pageY;
                                h = t.touches[0].pageY
                            } catch (n) {}
                        }
                    }
                }
            }

            function A(t) {
                if (a && i.drag) {
                    if (!p) {
                        t.preventDefault();
                        try {
                            v = t.clientX - f;
                            m = t.clientY - c
                        } catch (n) {}
                    } else {
                        try {
                            v = t.touches[0].pageX - f;
                            m = t.touches[0].pageY - c
                        } catch (n) {}
                    }
                    e("#" + E).get(0).style.webkitTransform = "translate(" + v + "px," + m + "px)";
                    e("#" + E).get(0).style.MozTransform = "translate(" + v + "px," + m + "px)";
                    e("#" + E).get(0).style.msTransform = "translate(" + v + "px," + m + "px)";
                    e("#" + E).get(0).style.OTransform = "translate(" + v + "px," + m + "px)";
                    e("#" + E).get(0).style.transform = "translate(" + v + "px," + m + "px)";
                    d = true;
                    D("menudrag")
                }
            }

            function O(t) {
                if (t.which == 1 || t.type == "touchend") {
                    t.preventDefault();
                    a = false;
                    if (!d || !i.drag) {
                        var n = e(t.target).parents(".geniemenu-controller").data("geniemenuitem");
                        e.fn.genieMenu.toggleMenu(n);
                        f = 0;
                        l = 0;
                        c = 0;
                        h = 0
                    } else {
                        d = false;
                        var r = e("#" + E).offset().left;
                        var s = e("#" + E).offset().top;
                        var u = "left";
                        var p = "top";
                        var v = {};
                        if (r >= e(window).width() / 3 && r < 2 * e(window).width() / 3) {
                            var u = "center";
                            v.x = e(window).width() / 2 - e("#" + E).width() / 2
                        } else if (r >= 2 * e(window).width() / 3) {
                            var u = "right";
                            v.x = e(window).width() - e("#" + E).outerWidth() - i.margin
                        } else {
                            var u = "left";
                            v.x = i.margin+20
                        }
                        if (s >= e(window).height() / 3 && s < 2 * e(window).height() / 3) {
                            var p = "center";
                            v.y = e(window).height() / 2 - e("#" + E).outerHeight() / 2
                        } else if (s >= e(window).height() / 3) {
                            var p = "bottom";
                            v.y = e(window).height() - e("#" + E).outerWidth() - i.margin
                        } else {
                            var p = "top";
                            v.y = i.margin+40
                        }





                        o = u + "-" + p;
                        e("#" + E).get(0).style.webkitTransition = "all 0.2s";
                        e("#" + E).get(0).style.MozTransition = "all 0.2s";
                        e("#" + E).get(0).style.msTransition = "all 0.2s";
                        e("#" + E).get(0).style.OTransition = "all 0.2s";
                        e("#" + E).get(0).style.transition = "all 0.2s";
                        var m = v.x - e("#" + E).data("startingPosition").x;
                        var g = v.y - e("#" + E).data("startingPosition").y;
                        e("#" + E).get(0).style.webkitTransform = "translate(" + m + "px," + g + "px)";
                        e("#" + E).get(0).style.MozTransform = "translate(" + m + "px," + g + "px)";
                        e("#" + E).get(0).style.msTransform = "translate(" + m + "px," + g + "px)";
                        e("#" + E).get(0).style.OTransform = "translate(" + m + "px," + g + "px)";
                        e("#" + E).get(0).style.transform = "translate(" + m + "px," + g + "px)";
                        setTimeout(function() {
                            _()
                        }, 210);
                        if (i.drag) {
                            D("menudragend")
                        }
                    }
                }
            }

            function M() {
                e(r + " > li").each(function(t) {
                    s[t] = true;
                    var n = e(this).data("end").left;
                    var r = e(this).data("end").top;
                    this.style.opacity = 1;
                    this.style.webkitTransform = "translate(" + n + "px," + r + "px)";
                    this.style.MozTransform = "translate(" + n + "px," + r + "px)";
                    this.style.msTransform = "translate(" + n + "px," + r + "px)";
                    this.style.OTransform = "translate(" + n + "px," + r + "px)";
                    this.style.transform = "translate(" + n + "px," + r + "px)";
                    k(t)
                })
            }

            function _() {
                e(r + " > li").each(function(t) {
                    e(this).css({
                        display: "inline-block",
                        position: "fixed",
                        zIndex: 999
                    });
                    s[t] = false;
                    e("#" + E).removeAttr("style");
                    e("#" + E).removeClass("left-bottom center-bottom right-bottom left-top center-top right-top left-center right-center center-center");
                    e("#" + E).addClass(o);
                    e(this).addClass(g);
                    switch (o) {
                        case "left-bottom":
                            e("#" + E).css({
                                bottom: 0,
                                left: 0,
                                marginLeft: i.margin,
                                marginBottom: i.margin,
                                zIndex: 1e3
                            });
                            var n = -Math.PI / 2 + t * (Math.PI / 2 / b);
                            var u = i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "center-bottom":
                            e("#" + E).css({
                                bottom: 0,
                                left: "50%",
                                marginLeft: -(e("#" + E).width() / 2),
                                marginBottom: i.margin,
                                zIndex: 1e3
                            });
                            // var n = Math.PI + t * (Math.PI / b);
                            // var u = i.radius * Math.sin(n);
                            // var a = i.radius * Math.cos(n);
                            var n = -Math.PI / 2 + t * (Math.PI / 2 / b);
                            var u = i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "right-bottom":
                            e("#" + E).css({
                                bottom: 0,
                                right: 0,
                                marginRight: i.margin,
                                marginBottom: i.margin,
                                zIndex: 1e3
                            });
                            var n = Math.PI + t * (Math.PI / 2 / b);
                            var u = i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "left-top":
                            e("#" + E).css({
                                top: 0,
                                left: 0,
                                marginLeft: i.margin,
                                marginTop: i.margin,
                                zIndex: 1e3
                            });
                            var n = -Math.PI / 2 + t * (Math.PI / 2 / b);
                            var u = -i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "center-top":
                            e("#" + E).css({
                                top: 0,
                                left: "40%",
                                marginLeft: -(e("#" + E).width() / 2),
                                marginTop: i.margin,
                                zIndex: 1e3
                            });
                            // var n = Math.PI + t * (Math.PI / b);
                            // var u = -i.radius * Math.sin(n);
                            // var a = i.radius * Math.cos(n);
                            var n = -Math.PI / 2 + t * (Math.PI / 2 / b);
                            var u = -i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "right-top":
                            e("#" + E).css({
                                top: 0,
                                right: 0,
                                marginRight: i.margin,
                                marginTop: i.margin,
                                zIndex: 1e3
                            });
                            var n = Math.PI + t * (Math.PI / 2 / b);
                            var u = -i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "left-center":
                            e("#" + E).css({
                                top: "40%",
                                left: 0,
                                marginTop: -(e("#" + E).height() / 2),
                                marginLeft: i.margin,
                                zIndex: 1e3
                            });
                            // var n = -Math.PI / 2 + t * (Math.PI / b);
                            // var u = i.radius * Math.sin(n);
                            // var a = i.radius * Math.cos(n);
                            // console.log(-Math.PI,t,b)
                            var n = -Math.PI / 2 + t * (Math.PI / 2 / b);
                            var u = -i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "right-center":
                            e("#" + E).css({
                                top: "50%",
                                right: 0,
                                marginTop: -(e("#" + E).height() / 2),
                                marginRight: i.margin,
                                zIndex: 1e3
                            });
                            // var n = -Math.PI / 2 + t * (Math.PI / b);
                            // var u = i.radius * Math.sin(n);
                            // var a = -i.radius * Math.cos(n);
                            var n = Math.PI + t * (Math.PI / 2 / b);
                            var u = -i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break;
                        case "center-center":
                            e("#" + E).css({
                                top: "50%",
                                left: "50%",
                                marginTop: -(e("#" + E).height() / 2),
                                marginLeft: -(e("#" + E).width() / 2),
                                zIndex: 1e3
                            });
                            // var n = -Math.PI / 2 + t * (Math.PI * 2 / e(r).find("li").length);
                            // var u = i.radius * Math.sin(n);
                            // var a = i.radius * Math.cos(n);
                            var n = -Math.PI / 2 + t * (Math.PI / 2 / b);
                            var u = -i.radius * Math.sin(n);
                            var a = i.radius * Math.cos(n);
                            break
                    }
                    e("#" + E).data("startingPosition", {
                        x: e("#" + E).offset().left,
                        y: e("#" + E).offset().top
                    });
                    e(this).css({
                        top: e("#" + E).offset().top + e("#" + E).outerHeight() / 2 - e(this).height() / 2,
                        left: e("#" + E).offset().left + e("#" + E).outerWidth() / 2 - e(this).width() / 2
                    });
                    if (u <= .1 && u >= -.1) {
                        u = 0
                    }
                    if (a <= .1 && a >= -.1) {
                        a = 0
                    }
                    e(this).data({
                        end: {
                            top: u,
                            left: a
                        }
                    })
                })
				
					
		       /*START - ADDITION FOR EDITPANEL*/
            var res = o.split("-");// e("#" + E).className.split(" ")[2].split("-");
            var uu=res[0];
            var pp=res[1];
            // if((pp =="bottom" && uu !="right") || (uu=="right") && pp!="bottom"){
            //   	$("#editpanel").css({borderRadius:"0px 30px 0px 30px"});
            // }else{
            //   	$("#editpanel").css({borderRadius:"30px 0px 30px 0px"});
            // }

        if((uu =="left" && pp =="top") || (uu =="left" && pp =="center")  || (uu =="center" && pp !="center") || (uu =="center" && pp !="top")){
           	$("#editpanel").css({borderRadius:"30px 0px 0px 0px"});
        }
        if((uu =="right" && pp =="top") || (uu =="right" && pp =="center") ){
           	$("#editpanel").css({borderRadius:"0px 30px 0px 0px"});
        }

        if((uu =="left" && pp =="bottom") || (uu =="center" && pp =="bottom") ){
          	$("#editpanel").css({borderRadius:"0px 0px 0px 30px"});
        }

        if((uu =="right" && pp =="bottom") ){
          	$("#editpanel").css({borderRadius:"0px 0px 30px 0px"});
        }

            var tmp_x=e("#" + E).offset().left;//$(this).data().startingPosition.x;
            var tmp_y=e("#" + E).offset().top;//$(this).data().startingPosition.y;
            var panel_width=$("#editpanel").width();
            var panel_height=$("#editpanel").height();
            var tmp_x_new;
            var tmp_y_new;

            if (tmp_x + panel_width < $(window).width()) {
              tmp_x_new=tmp_x;
              $("#editpanel").css({paddingRight:"10px",paddingLeft:"120px"});
            }else{
              tmp_x_new=tmp_x-panel_width-30;
               $("#editpanel").css({paddingRight:"120px",paddingLeft:"10px"});
            }

            if (tmp_y + panel_height < $(window).height()) {
              tmp_y_new=tmp_y;
            }else{
              tmp_y_new=tmp_y-panel_height+ 57;
            }

             if(uu=="right"){
             	$("#editpanel").css({left:"",right:8,top:tmp_y_new});
             }else{
              $("#editpanel").css({left:tmp_x_new,top:tmp_y_new});

            }
            /*END - ADDITION FOR EDITPANEL*/

            }

            function D(t) {
                var n = {
                    menuElement: r,
                    position: o,
                    opened: u
                };
                e.event.trigger({
                    type: t,
                    menustatus: n
                })
                setCookie("sidebarclass",o);
            }

            function p() {
                if (navigator.userAgent.toLowerCase().indexOf("android") > -1 || navigator.userAgent.toLowerCase().indexOf("blackberry9500") > -1 || navigator.userAgent.toLowerCase().indexOf("blackberry9530") > -1 || navigator.userAgent.toLowerCase().indexOf("cupcake") > -1 || navigator.userAgent.toLowerCase().indexOf("dream") > -1 || navigator.userAgent.toLowerCase().indexOf("incognito") > -1 || navigator.userAgent.toLowerCase().indexOf("iphone") > -1 || navigator.userAgent.toLowerCase().indexOf("ipod") > -1 || navigator.userAgent.toLowerCase().indexOf("ipad") > -1 || navigator.userAgent.toLowerCase().indexOf("mini") > -1 || navigator.userAgent.toLowerCase().indexOf("webos") > -1 || navigator.userAgent.toLowerCase().indexOf("webmate") > -1 || navigator.userAgent.toLowerCase().indexOf("2.0 mmp") > -1 || navigator.userAgent.toLowerCase().indexOf("240×320") > -1 || navigator.userAgent.toLowerCase().indexOf("asus") > -1 || navigator.userAgent.toLowerCase().indexOf("au-mic") > -1 || navigator.userAgent.toLowerCase().indexOf("alcatel") > -1 || navigator.userAgent.toLowerCase().indexOf("amoi") > -1 || navigator.userAgent.toLowerCase().indexOf("audiovox") > -1 || navigator.userAgent.toLowerCase().indexOf("avantgo") > -1 || navigator.userAgent.toLowerCase().indexOf("benq") > -1 || navigator.userAgent.toLowerCase().indexOf("bird") > -1 || navigator.userAgent.toLowerCase().indexOf("blackberry") > -1 || navigator.userAgent.toLowerCase().indexOf("blazer") > -1 || navigator.userAgent.toLowerCase().indexOf("cdm") > -1 || navigator.userAgent.toLowerCase().indexOf("cellphone") > -1 || navigator.userAgent.toLowerCase().indexOf("ddipocket") > -1 || navigator.userAgent.toLowerCase().indexOf("danger") > -1 || navigator.userAgent.toLowerCase().indexOf("docomo") > -1 || navigator.userAgent.toLowerCase().indexOf("elaine/3.0") > -1 || navigator.userAgent.toLowerCase().indexOf("ericsson") > -1 || navigator.userAgent.toLowerCase().indexOf("eudoraweb") > -1 || navigator.userAgent.toLowerCase().indexOf("fly") > -1 || navigator.userAgent.toLowerCase().indexOf("hp.ipaq") > -1 || navigator.userAgent.toLowerCase().indexOf("haier") > -1 || navigator.userAgent.toLowerCase().indexOf("huawei") > -1 || navigator.userAgent.toLowerCase().indexOf("iemobile") > -1 || navigator.userAgent.toLowerCase().indexOf("j-phone") > -1 || navigator.userAgent.toLowerCase().indexOf("kddi") > -1 || navigator.userAgent.toLowerCase().indexOf("konka") > -1 || navigator.userAgent.toLowerCase().indexOf("kwc") > -1 || navigator.userAgent.toLowerCase().indexOf("kyocera/wx310k") > -1 || navigator.userAgent.toLowerCase().indexOf("lg") > -1 || navigator.userAgent.toLowerCase().indexOf("lg/u990") > -1 || navigator.userAgent.toLowerCase().indexOf("lenovo") > -1 || navigator.userAgent.toLowerCase().indexOf("midp-2.0") > -1 || navigator.userAgent.toLowerCase().indexOf("mmef20") > -1 || navigator.userAgent.toLowerCase().indexOf("mot-v") > -1 || navigator.userAgent.toLowerCase().indexOf("mobilephone") > -1 || navigator.userAgent.toLowerCase().indexOf("motorola") > -1 || navigator.userAgent.toLowerCase().indexOf("newgen") > -1 || navigator.userAgent.toLowerCase().indexOf("netfront") > -1 || navigator.userAgent.toLowerCase().indexOf("newt") > -1 || navigator.userAgent.toLowerCase().indexOf("nintendo wii") > -1 || navigator.userAgent.toLowerCase().indexOf("nitro") > -1 || navigator.userAgent.toLowerCase().indexOf("nokia") > -1 || navigator.userAgent.toLowerCase().indexOf("novarra") > -1 || navigator.userAgent.toLowerCase().indexOf("o2") > -1 || navigator.userAgent.toLowerCase().indexOf("opera mini") > -1 || navigator.userAgent.toLowerCase().indexOf("opera.mobi") > -1 || navigator.userAgent.toLowerCase().indexOf("pantech") > -1 || navigator.userAgent.toLowerCase().indexOf("pdxgw") > -1 || navigator.userAgent.toLowerCase().indexOf("pg") > -1 || navigator.userAgent.toLowerCase().indexOf("ppc") > -1 || navigator.userAgent.toLowerCase().indexOf("pt") > -1 || navigator.userAgent.toLowerCase().indexOf("palm") > -1 || navigator.userAgent.toLowerCase().indexOf("panasonic") > -1 || navigator.userAgent.toLowerCase().indexOf("philips") > -1 || navigator.userAgent.toLowerCase().indexOf("playstation portable") > -1 || navigator.userAgent.toLowerCase().indexOf("proxinet") > -1 || navigator.userAgent.toLowerCase().indexOf("proxinet") > -1 || navigator.userAgent.toLowerCase().indexOf("qtek") > -1 || navigator.userAgent.toLowerCase().indexOf("sch") > -1 || navigator.userAgent.toLowerCase().indexOf("sec") > -1 || navigator.userAgent.toLowerCase().indexOf("sgh") > -1 || navigator.userAgent.toLowerCase().indexOf("sharp-tq-gx10") > -1 || navigator.userAgent.toLowerCase().indexOf("sie") > -1 || navigator.userAgent.toLowerCase().indexOf("sph") > -1 || navigator.userAgent.toLowerCase().indexOf("sagem") > -1 || navigator.userAgent.toLowerCase().indexOf("samsung") > -1 || navigator.userAgent.toLowerCase().indexOf("sanyo") > -1 || navigator.userAgent.toLowerCase().indexOf("sendo") > -1 || navigator.userAgent.toLowerCase().indexOf("sharp") > -1 || navigator.userAgent.toLowerCase().indexOf("small") > -1 || navigator.userAgent.toLowerCase().indexOf("smartphone") > -1 || navigator.userAgent.toLowerCase().indexOf("softbank") > -1 || navigator.userAgent.toLowerCase().indexOf("sonyericsson") > -1 || navigator.userAgent.toLowerCase().indexOf("symbian") > -1 || navigator.userAgent.toLowerCase().indexOf("symbian os") > -1 || navigator.userAgent.toLowerCase().indexOf("symbianos") > -1 || navigator.userAgent.toLowerCase().indexOf("ts21i-10") > -1 || navigator.userAgent.toLowerCase().indexOf("toshiba") > -1 || navigator.userAgent.toLowerCase().indexOf("treo") > -1 || navigator.userAgent.toLowerCase().indexOf("up.browser") > -1 || navigator.userAgent.toLowerCase().indexOf("up.link") > -1 || navigator.userAgent.toLowerCase().indexOf("uts") > -1 || navigator.userAgent.toLowerCase().indexOf("vertu") > -1 || navigator.userAgent.toLowerCase().indexOf("willcome") > -1 || navigator.userAgent.toLowerCase().indexOf("winwap") > -1 || navigator.userAgent.toLowerCase().indexOf("windows ce") > -1 || navigator.userAgent.toLowerCase().indexOf("windows.ce") > -1 || navigator.userAgent.toLowerCase().indexOf("xda") > -1 || navigator.userAgent.toLowerCase().indexOf("zte") > -1 || navigator.userAgent.toLowerCase().indexOf("dopod") > -1 || navigator.userAgent.toLowerCase().indexOf("hiptop") > -1 || navigator.userAgent.toLowerCase().indexOf("htc") > -1 || navigator.userAgent.toLowerCase().indexOf("i-mobile") > -1 || navigator.userAgent.toLowerCase().indexOf("nokia") > -1 || navigator.userAgent.toLowerCase().indexOf("portalmmm") > -1) {
                    if (navigator.platform.toLowerCase().indexOf("win32") == -1 && navigator.platform.toLowerCase().indexOf("win64") == -1) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return false
                }
            }
            var n = {
                closeTime: 500,
                delay: 40,
                drag: true,
                easing: "cubic-bezier(0.680, -0.550, 0.265, 1.550)",
                margin: 8,
                position: "left-bottom",
                radius: 60,
                rotation: 0,
                opened: false,
                openTime: 500
            };
            var r = this.selector;
            var i = e.extend({}, n, t);
            var s = new Array;
            var o = i.position;
            var u = i.opened;
            var a = false;
            var f = 0;
            var l = 0;
            var c = 0;
            var h = 0;
            var p = p();
            var d = false;
            var v = 0;
            var m = 0;
            var g = p ? "mobile" : "desktop";
            var y = u ? "open" : "";
            var b = e(r).find("li").length - 1;
            var w = 0;
            e(".geniemenu-controller").each(function() {
                var t = e(this).attr("id").split("-");
                w = parseInt(t[t.length - 1]) + 1
            });
            var E = "geniemenu-controller-" + w;
          //  e("body").append("<span id='s" + E + " " + r + "' class='geniemenu-controller " + g + " " +
          //   y + "' href='javascript:void(0);'><div class='label'><span id='numberofgenesSpan' class='notification-count' style='position:fixed;'></span></div></a>");
            //e("body").append("<a id='" + E + "' data-geniemenuitem='" + r + "' class='geniemenu-controller " + g + " " +
             //y + "' href='javascript:void(0);'><div class='label'>+</div></a>");
             e("body").append("<span id='" + E + "' data-geniemenuitem='" + r + "' class='geniemenu-controller " + g + " " +
              y + "' '><div class='label'><span></span></div></span>"); 
            e(r + " > li").css({
                opacity: 0
            });
            _();
            if (i.opened) {
                M()
            }
            C("resize", window, _);
            C("orientationchange", window, function() {
                var e = setTimeout(function() {
                    _()
                }, 200)
            });
            var S = "ontouchstart" in window;
            var x = S ? "touchstart" : "mousedown";
            var T = S ? "touchmove" : "mousemove";
            var N = S ? "touchend" : "mouseup";
            C(x, e("#" + E).get(0), L);
            C(T, window, A);
            C(N, e("#" + E).get(0), O);
            D("menuready");
            e.fn.genieMenu.refreshMenu = function() {
                _()
            };
            e.fn.genieMenu.toggleMenu = function(t) {
                var n = true;
                for (var o = 0; o < s.length; o++) {
                    if (s[o]) {
                        n = false
                    }
                }
                if (n) {
                    var u = null;
                    e(".geniemenu-controller").each(function() {
                        if (e(this).data("geniemenuitem") == t) {
                            u = e(this);
                            u.toggleClass("open")

                        }
            /*START - ADDITION FOR EDITPANEL
            var res =  e(this)[0].className.split(" ")[2].split("-");
            var uu=res[0];
            var pp=res[1];
            // if((pp =="bottom" && uu !="right") || (uu=="right") && pp!="bottom"){
            //   	$("#editpanel").css({borderRadius:"0px 30px 0px 30px"});
            // }else{
            //   	$("#editpanel").css({borderRadius:"30px 0px 30px 0px"});
            // }

        if((uu =="left" && pp =="top") || (uu =="left" && pp =="center")  || (uu =="center" && pp !="center") || (uu =="center" && pp !="top")){
           	$("#editpanel").css({borderRadius:"30px 0px 0px 0px"});
        }
        if((uu =="right" && pp =="top") || (uu =="right" && pp =="center") ){
           	$("#editpanel").css({borderRadius:"0px 30px 0px 0px"});
        }

        if((uu =="left" && pp =="bottom") || (uu =="center" && pp =="bottom") ){
          	$("#editpanel").css({borderRadius:"0px 0px 0px 30px"});
        }

        if((uu =="right" && pp =="bottom") ){
          	$("#editpanel").css({borderRadius:"0px 0px 30px 0px"});
        }

            var tmp_x=e(this)[0].offsetLeft;//$(this).data().startingPosition.x;
            var tmp_y=e(this)[0].offsetTop;//$(this).data().startingPosition.y;
            var panel_width=$("#editpanel").width();
            var panel_height=$("#editpanel").height();
            var tmp_x_new;
            var tmp_y_new;

            if (tmp_x + panel_width < $(window).width()) {
              tmp_x_new=tmp_x;
              $("#editpanel").css({paddingRight:"10px",paddingLeft:"120px"});
            }else{
              tmp_x_new=tmp_x-panel_width-30;
               $("#editpanel").css({paddingRight:"120px",paddingLeft:"10px"});
            }

            if (tmp_y + panel_height < $(window).height()) {
              tmp_y_new=tmp_y;
            }else{
              tmp_y_new=tmp_y-panel_height+ 57;
            }

             if(uu=="right"){
             	$("#editpanel").css({left:"",right:8,top:tmp_y_new});
             }else{
              $("#editpanel").css({left:tmp_x_new,top:tmp_y_new});

            }
           ND - ADDITION FOR EDITPANEL*/


                    });
                    if (u != null) {
                        if (u.hasClass("open")) {
                        //  e("#" + E).get(0).style.opacity=0.6;
                            e(t + " > li").each(function(t) {
                                s[t] = true;
                                var n = e(this).data("end").left;
                                var r = e(this).data("end").top;
                                this.style.webkitTransition = "all " + i.openTime / 1e3 + "s " + i.easing + " " + t * i.delay / 1e3 + "s";
                                this.style.MozTransition = "all " + i.openTime / 1e3 + "s " + i.easing + " " + t * i.delay / 1e3 + "s";
                                this.style.msTransition = "all " + i.openTime / 1e3 + "s " + i.easing + " " + t * i.delay / 1e3 + "s";
                                this.style.OTransition = "all " + i.openTime / 1e3 + "s " + i.easing + " " + t * i.delay / 1e3 + "s";
                                this.style.transition = "all " + i.openTime / 1e3 + "s " + i.easing + " " + t * i.delay / 1e3 + "s";
                                this.style.opacity = 1;
                                this.style.webkitTransform = "translate(" + n + "px," + r + "px) rotate(" + i.rotation + "deg)";
                                this.style.MozTransform = "translate(" + n + "px," + r + "px) rotate(" + i.rotation + "deg)";
                                this.style.msTransform = "translate(" + n + "px," + r + "px) rotate(" + i.rotation + "deg)";
                                this.style.OTransform = "translate(" + n + "px," + r + "px) rotate(" + i.rotation + "deg)";
                                this.style.transform = "translate(" + n + "px," + r + "px) rotate(" + i.rotation + "deg)";
                                setTimeout(function() {
                                    k(t)
                                }, i.openTime / 1e3)
                            });
                            D("menuopened")
                        } else {
                        //  e("#" + E).get(0).style.opacity=1;
                            e(t + " > li").each(function(t) {
                                s[t] = true;
                                this.style.webkitTransition = "all " + i.closeTime / 1e3 + "s " + i.easing + " " + (e(r + " > li").length - t) * i.delay / 1e3 + "s";
                                this.style.MozTransition = "all " + i.closeTime / 1e3 + "s " + i.easing + " " + (e(r + " > li").length - t) * i.delay / 1e3 + "s";
                                this.style.msTransition = "all " + i.closeTime / 1e3 + "s " + i.easing + " " + (e(r + " > li").length - t) * i.delay / 1e3 + "s";
                                this.style.OTransition = "all " + i.closeTime / 1e3 + "s " + i.easing + " " + (e(r + " > li").length - t) * i.delay / 1e3 + "s";
                                this.style.transition = "all " + i.closeTime / 1e3 + "s " + i.easing + " " + (e(r + " > li").length - t) * i.delay / 1e3 + "s";
                                this.style.opacity = 0;
                                this.style.webkitTransform = "translate(0px,0px) rotate(-" + i.rotation + "deg)";
                                this.style.MozTransform = "translate(0px,0px) rotate(-" + i.rotation + "deg)";
                                this.style.msTransform = "translate(0px,0px) rotate(-" + i.rotation + "deg)";
                                this.style.OTransform = "translate(0px,0px) rotate(-" + i.rotation + "deg)";
                                this.style.transform = "translate(0px,0px) rotate(-" + i.rotation + "deg)";
                                setTimeout(function() {
                                    k(t)
                                }, i.closeTime / 1e3)
                            });
                            D("menuclosed")
                        }

                    }

                }
            }
        }
    };
    e.fn.genieMenu = function(e) {
        return t.genieMenuCreate.call(this, e)
    }
})(jQuery)


//$(window).on("scroll",function(){

//});	
