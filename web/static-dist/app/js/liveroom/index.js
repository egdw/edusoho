webpackJsonp(["app/js/liveroom/index"],{acdf198fed0b30ccedb6:function(e,r,t){"use strict";function n(e,r){if(!(e instanceof r))throw new TypeError("Cannot call a class as a function")}var a=function(){function e(e,r){for(var t=0;t<r.length;t++){var n=r[t];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(r,t,n){return t&&e(r.prototype,t),n&&e(r,n),r}}();new(function(){function e(){n(this,e),this.init()}return a(e,[{key:"init",value:function(){var e=this;this.isLiveRoomOpened=!1;var r=0,t=1;r=setInterval(function(){if(t>10)return clearInterval(r),void $("#entry").html(Translator.trans("course_set.live_room.entry_error_hint"));$.ajax({url:$("#entry").data("url"),success:function(n){if(n.error)return clearInterval(r),void $("#entry").html(Translator.trans("course_set.live_room.entry_error_with_message",{message:n.error}));if(n.roomUrl){clearInterval(r),e.isLiveRoomOpened=!0;var a='<iframe name="classroom" src="'+n.roomUrl+'" style="position:absolute; left:0; top:0; height:100%; width:100%; border:0px;" scrolling="no"></iframe>';$("body").html(a)}t++},error:function(){$("#entry").html(Translator.trans("course_set.live_room.entry_error_hint"))}})},3e3),this.triggerLiveEvent()}},{key:"triggerLiveEvent",value:function(){var e=this,r=null,t=setInterval(function(){if(e.isLiveRoomOpened&&0!=$('meta[name="trigger_url"]').length){r=r?"doing":"start";var n=Date.parse(new Date).toString();n=n.substr(0,10),$.ajax({url:$('meta[name="trigger_url"]').attr("content"),type:"GET",data:{eventName:r,data:{lastTime:n,events:{watching:{watchTime:60}}}},success:function(e){e.live_end&&clearInterval(t)}})}},6e4)}}]),e}())}},["acdf198fed0b30ccedb6"]);