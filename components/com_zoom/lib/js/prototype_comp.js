var Prototype={Version:"1.5.0_rc1",BrowserFeatures:{XPath:!!document.evaluate},ScriptFragment:"(?:<script.*?>)((\n|\r|.)*?)(?:</script>)",emptyFunction:function(){
},K:function(x){
return x;
}};
var Class={create:function(){
return function(){
this.initialize.apply(this,arguments);
};
}};
var Abstract=new Object();
Object.extend=function(_2,_3){
for(var _4 in _3){
_2[_4]=_3[_4];
}
return _2;
};
Object.extend(Object,{inspect:function(_5){
try{
if(_5==undefined){
return "undefined";
}
if(_5==null){
return "null";
}
return _5.inspect?_5.inspect():_5.toString();
}
catch(e){
if(e instanceof RangeError){
return "...";
}
throw e;
}
},keys:function(_6){
var _7=[];
for(var _8 in _6){
_7.push(_8);
}
return _7;
},values:function(_9){
var _a=[];
for(var _b in _9){
_a.push(_9[_b]);
}
return _a;
},clone:function(_c){
return Object.extend({},_c);
}});
Function.prototype.bind=function(){
var _d=this,args=$A(arguments),object=args.shift();
return function(){
return _d.apply(object,args.concat($A(arguments)));
};
};
Function.prototype.bindAsEventListener=function(_e){
var _f=this,args=$A(arguments),_e=args.shift();
return function(_10){
return _f.apply(_e,[(_10||window.event)].concat(args).concat($A(arguments)));
};
};
Object.extend(Number.prototype,{toColorPart:function(){
var _11=this.toString(16);
if(this<16){
return "0"+_11;
}
return _11;
},succ:function(){
return this+1;
},times:function(_12){
$R(0,this,true).each(_12);
return this;
}});
var Try={these:function(){
var _13;
for(var i=0;i<arguments.length;i++){
var _15=arguments[i];
try{
_13=_15();
break;
}
catch(e){
}
}
return _13;
}};
var PeriodicalExecuter=Class.create();
PeriodicalExecuter.prototype={initialize:function(_16,_17){
this.callback=_16;
this.frequency=_17;
this.currentlyExecuting=false;
this.registerCallback();
},registerCallback:function(){
this.timer=setInterval(this.onTimerEvent.bind(this),this.frequency*1000);
},stop:function(){
if(!this.timer){
return;
}
clearInterval(this.timer);
this.timer=null;
},onTimerEvent:function(){
if(!this.currentlyExecuting){
try{
this.currentlyExecuting=true;
this.callback(this);
}
finally{
this.currentlyExecuting=false;
}
}
}};
Object.extend(String.prototype,{gsub:function(_18,_19){
var _1a="",source=this,match;
_19=arguments.callee.prepareReplacement(_19);
while(source.length>0){
if(match=source.match(_18)){
_1a+=source.slice(0,match.index);
_1a+=(_19(match)||"").toString();
source=source.slice(match.index+match[0].length);
}else{
_1a+=source,source="";
}
}
return _1a;
},sub:function(_1b,_1c,_1d){
_1c=this.gsub.prepareReplacement(_1c);
_1d=_1d===undefined?1:_1d;
return this.gsub(_1b,function(_1e){
if(--_1d<0){
return _1e[0];
}
return _1c(_1e);
});
},scan:function(_1f,_20){
this.gsub(_1f,_20);
return this;
},truncate:function(_21,_22){
_21=_21||30;
_22=_22===undefined?"...":_22;
return this.length>_21?this.slice(0,_21-_22.length)+_22:this;
},strip:function(){
return this.replace(/^\s+/,"").replace(/\s+$/,"");
},stripTags:function(){
return this.replace(/<\/?[^>]+>/gi,"");
},stripScripts:function(){
return this.replace(new RegExp(Prototype.ScriptFragment,"img"),"");
},extractScripts:function(){
var _23=new RegExp(Prototype.ScriptFragment,"img");
var _24=new RegExp(Prototype.ScriptFragment,"im");
return (this.match(_23)||[]).map(function(_25){
return (_25.match(_24)||["",""])[1];
});
},evalScripts:function(){
return this.extractScripts().map(function(_26){
return eval(_26);
});
},escapeHTML:function(){
var div=document.createElement("div");
var _28=document.createTextNode(this);
div.appendChild(_28);
return div.innerHTML;
},unescapeHTML:function(){
var div=document.createElement("div");
div.innerHTML=this.stripTags();
return div.childNodes[0]?div.childNodes[0].nodeValue:"";
},toQueryParams:function(){
var _2a=this.match(/^\??(.*)$/)[1].split("&");
return _2a.inject({},function(_2b,_2c){
var _2d=_2c.split("=");
var _2e=_2d[1]?decodeURIComponent(_2d[1]):undefined;
_2b[decodeURIComponent(_2d[0])]=_2e;
return _2b;
});
},toArray:function(){
return this.split("");
},camelize:function(){
var _2f=this.split("-");
if(_2f.length==1){
return _2f[0];
}
var _30=this.indexOf("-")==0?_2f[0].charAt(0).toUpperCase()+_2f[0].substring(1):_2f[0];
for(var i=1,len=_2f.length;i<len;i++){
var s=_2f[i];
_30+=s.charAt(0).toUpperCase()+s.substring(1);
}
return _30;
},inspect:function(_33){
var _34=this.replace(/\\/g,"\\\\");
if(_33){
return "\""+_34.replace(/"/g,"\\\"")+"\"";
}else{
return "'"+_34.replace(/'/g,"\\'")+"'";
}
}});
String.prototype.gsub.prepareReplacement=function(_35){
if(typeof _35=="function"){
return _35;
}
var _36=new Template(_35);
return function(_37){
return _36.evaluate(_37);
};
};
String.prototype.parseQuery=String.prototype.toQueryParams;
var Template=Class.create();
Template.Pattern=/(^|.|\r|\n)(#\{(.*?)\})/;
Template.prototype={initialize:function(_38,_39){
this.template=_38.toString();
this.pattern=_39||Template.Pattern;
},evaluate:function(_3a){
return this.template.gsub(this.pattern,function(_3b){
var _3c=_3b[1];
if(_3c=="\\"){
return _3b[2];
}
return _3c+(_3a[_3b[3]]||"").toString();
});
}};
var $break=new Object();
var $continue=new Object();
var Enumerable={each:function(_3d){
var _3e=0;
try{
this._each(function(_3f){
try{
_3d(_3f,_3e++);
}
catch(e){
if(e!=$continue){
throw e;
}
}
});
}
catch(e){
if(e!=$break){
throw e;
}
}
},all:function(_40){
var _41=true;
this.each(function(_42,_43){
_41=_41&&!!(_40||Prototype.K)(_42,_43);
if(!_41){
throw $break;
}
});
return _41;
},any:function(_44){
var _45=false;
this.each(function(_46,_47){
if(_45=!!(_44||Prototype.K)(_46,_47)){
throw $break;
}
});
return _45;
},collect:function(_48){
var _49=[];
this.each(function(_4a,_4b){
_49.push(_48(_4a,_4b));
});
return _49;
},detect:function(_4c){
var _4d;
this.each(function(_4e,_4f){
if(_4c(_4e,_4f)){
_4d=_4e;
throw $break;
}
});
return _4d;
},findAll:function(_50){
var _51=[];
this.each(function(_52,_53){
if(_50(_52,_53)){
_51.push(_52);
}
});
return _51;
},grep:function(_54,_55){
var _56=[];
this.each(function(_57,_58){
var _59=_57.toString();
if(_59.match(_54)){
_56.push((_55||Prototype.K)(_57,_58));
}
});
return _56;
},include:function(_5a){
var _5b=false;
this.each(function(_5c){
if(_5c==_5a){
_5b=true;
throw $break;
}
});
return _5b;
},inject:function(_5d,_5e){
this.each(function(_5f,_60){
_5d=_5e(_5d,_5f,_60);
});
return _5d;
},invoke:function(_61){
var _62=$A(arguments).slice(1);
return this.collect(function(_63){
return _63[_61].apply(_63,_62);
});
},max:function(_64){
var _65;
this.each(function(_66,_67){
_66=(_64||Prototype.K)(_66,_67);
if(_65==undefined||_66>=_65){
_65=_66;
}
});
return _65;
},min:function(_68){
var _69;
this.each(function(_6a,_6b){
_6a=(_68||Prototype.K)(_6a,_6b);
if(_69==undefined||_6a<_69){
_69=_6a;
}
});
return _69;
},partition:function(_6c){
var _6d=[],falses=[];
this.each(function(_6e,_6f){
((_6c||Prototype.K)(_6e,_6f)?_6d:falses).push(_6e);
});
return [_6d,falses];
},pluck:function(_70){
var _71=[];
this.each(function(_72,_73){
_71.push(_72[_70]);
});
return _71;
},reject:function(_74){
var _75=[];
this.each(function(_76,_77){
if(!_74(_76,_77)){
_75.push(_76);
}
});
return _75;
},sortBy:function(_78){
return this.collect(function(_79,_7a){
return {value:_79,criteria:_78(_79,_7a)};
}).sort(function(_7b,_7c){
var a=_7b.criteria,b=_7c.criteria;
return a<b?-1:a>b?1:0;
}).pluck("value");
},toArray:function(){
return this.collect(Prototype.K);
},zip:function(){
var _7e=Prototype.K,args=$A(arguments);
if(typeof args.last()=="function"){
_7e=args.pop();
}
var _7f=[this].concat(args).map($A);
return this.map(function(_80,_81){
return _7e(_7f.pluck(_81));
});
},inspect:function(){
return "#<Enumerable:"+this.toArray().inspect()+">";
}};
Object.extend(Enumerable,{map:Enumerable.collect,find:Enumerable.detect,select:Enumerable.findAll,member:Enumerable.include,entries:Enumerable.toArray});
var $A=Array.from=function(_82){
if(!_82){
return [];
}
if(_82.toArray){
return _82.toArray();
}else{
var _83=[];
for(var i=0;i<_82.length;i++){
_83.push(_82[i]);
}
return _83;
}
};
Object.extend(Array.prototype,Enumerable);
if(!Array.prototype._reverse){
Array.prototype._reverse=Array.prototype.reverse;
}
Object.extend(Array.prototype,{_each:function(_85){
for(var i=0;i<this.length;i++){
_85(this[i]);
}
},clear:function(){
this.length=0;
return this;
},first:function(){
return this[0];
},last:function(){
return this[this.length-1];
},compact:function(){
return this.select(function(_87){
return _87!=undefined||_87!=null;
});
},flatten:function(){
return this.inject([],function(_88,_89){
return _88.concat(_89&&_89.constructor==Array?_89.flatten():[_89]);
});
},without:function(){
var _8a=$A(arguments);
return this.select(function(_8b){
return !_8a.include(_8b);
});
},indexOf:function(_8c){
for(var i=0;i<this.length;i++){
if(this[i]==_8c){
return i;
}
}
return -1;
},reverse:function(_8e){
return (_8e!==false?this:this.toArray())._reverse();
},reduce:function(){
return this.length>1?this:this[0];
},uniq:function(){
return this.inject([],function(_8f,_90){
return _8f.include(_90)?_8f:_8f.concat([_90]);
});
},inspect:function(){
return "["+this.map(Object.inspect).join(", ")+"]";
}});
var Hash={_each:function(_91){
for(var key in this){
var _93=this[key];
if(typeof _93=="function"){
continue;
}
var _94=[key,_93];
_94.key=key;
_94.value=_93;
_91(_94);
}
},keys:function(){
return this.pluck("key");
},values:function(){
return this.pluck("value");
},merge:function(_95){
return $H(_95).inject($H(this),function(_96,_97){
_96[_97.key]=_97.value;
return _96;
});
},toQueryString:function(){
return this.map(function(_98){
return _98.map(encodeURIComponent).join("=");
}).join("&");
},inspect:function(){
return "#<Hash:{"+this.map(function(_99){
return _99.map(Object.inspect).join(": ");
}).join(", ")+"}>";
}};
function $H(_9a){
var _9b=Object.extend({},_9a||{});
Object.extend(_9b,Enumerable);
Object.extend(_9b,Hash);
return _9b;
}
ObjectRange=Class.create();
Object.extend(ObjectRange.prototype,Enumerable);
Object.extend(ObjectRange.prototype,{initialize:function(_9c,end,_9e){
this.start=_9c;
this.end=end;
this.exclusive=_9e;
},_each:function(_9f){
var _a0=this.start;
while(this.include(_a0)){
_9f(_a0);
_a0=_a0.succ();
}
},include:function(_a1){
if(_a1<this.start){
return false;
}
if(this.exclusive){
return _a1<this.end;
}
return _a1<=this.end;
}});
var $R=function(_a2,end,_a4){
return new ObjectRange(_a2,end,_a4);
};
var Ajax={getTransport:function(){
return Try.these(function(){
return new XMLHttpRequest();
},function(){
return new ActiveXObject("Msxml2.XMLHTTP");
},function(){
return new ActiveXObject("Microsoft.XMLHTTP");
})||false;
},activeRequestCount:0};
Ajax.Responders={responders:[],_each:function(_a5){
this.responders._each(_a5);
},register:function(_a6){
if(!this.include(_a6)){
this.responders.push(_a6);
}
},unregister:function(_a7){
this.responders=this.responders.without(_a7);
},dispatch:function(_a8,_a9,_aa,_ab){
this.each(function(_ac){
if(_ac[_a8]&&typeof _ac[_a8]=="function"){
try{
_ac[_a8].apply(_ac,[_a9,_aa,_ab]);
}
catch(e){
}
}
});
}};
Object.extend(Ajax.Responders,Enumerable);
Ajax.Responders.register({onCreate:function(){
Ajax.activeRequestCount++;
},onComplete:function(){
Ajax.activeRequestCount--;
}});
Ajax.Base=function(){
};
Ajax.Base.prototype={setOptions:function(_ad){
this.options={method:"post",asynchronous:true,contentType:"application/x-www-form-urlencoded",parameters:""};
Object.extend(this.options,_ad||{});
},responseIsSuccess:function(){
return this.transport.status==undefined||this.transport.status==0||(this.transport.status>=200&&this.transport.status<300);
},responseIsFailure:function(){
return !this.responseIsSuccess();
}};
Ajax.Request=Class.create();
Ajax.Request.Events=["Uninitialized","Loading","Loaded","Interactive","Complete"];
Ajax.Request.prototype=Object.extend(new Ajax.Base(),{initialize:function(url,_af){
this.transport=Ajax.getTransport();
this.setOptions(_af);
this.request(url);
},request:function(url){
var _b1=this.options.parameters||"";
if(_b1.length>0){
_b1+="&_=";
}
if(this.options.method!="get"&&this.options.method!="post"){
_b1+=(_b1.length>0?"&":"")+"_method="+this.options.method;
this.options.method="post";
}
try{
this.url=url;
if(this.options.method=="get"&&_b1.length>0){
this.url+=(this.url.match(/\?/)?"&":"?")+_b1;
}
Ajax.Responders.dispatch("onCreate",this,this.transport);
this.transport.open(this.options.method,this.url,this.options.asynchronous);
if(this.options.asynchronous){
setTimeout(function(){
this.respondToReadyState(1);
}.bind(this),10);
}
this.transport.onreadystatechange=this.onStateChange.bind(this);
this.setRequestHeaders();
var _b2=this.options.postBody?this.options.postBody:_b1;
this.transport.send(this.options.method=="post"?_b2:null);
if(!this.options.asynchronous&&this.transport.overrideMimeType){
this.onStateChange();
}
}
catch(e){
this.dispatchException(e);
}
},setRequestHeaders:function(){
var _b3=["X-Requested-With","XMLHttpRequest","X-Prototype-Version",Prototype.Version,"Accept","text/javascript, text/html, application/xml, text/xml, */*"];
if(this.options.method=="post"){
_b3.push("Content-type",this.options.contentType);
if(this.transport.overrideMimeType){
_b3.push("Connection","close");
}
}
if(this.options.requestHeaders){
_b3.push.apply(_b3,this.options.requestHeaders);
}
for(var i=0;i<_b3.length;i+=2){
this.transport.setRequestHeader(_b3[i],_b3[i+1]);
}
},onStateChange:function(){
var _b5=this.transport.readyState;
if(_b5!=1){
this.respondToReadyState(this.transport.readyState);
}
},header:function(_b6){
try{
return this.transport.getResponseHeader(_b6);
}
catch(e){
}
},evalJSON:function(){
try{
return eval("("+this.header("X-JSON")+")");
}
catch(e){
}
},evalResponse:function(){
try{
return eval(this.transport.responseText);
}
catch(e){
this.dispatchException(e);
}
},respondToReadyState:function(_b7){
var _b8=Ajax.Request.Events[_b7];
var _b9=this.transport,json=this.evalJSON();
if(_b8=="Complete"){
try{
(this.options["on"+this.transport.status]||this.options["on"+(this.responseIsSuccess()?"Success":"Failure")]||Prototype.emptyFunction)(_b9,json);
}
catch(e){
this.dispatchException(e);
}
if((this.header("Content-type")||"").match(/^text\/javascript/i)){
this.evalResponse();
}
}
try{
(this.options["on"+_b8]||Prototype.emptyFunction)(_b9,json);
Ajax.Responders.dispatch("on"+_b8,this,_b9,json);
}
catch(e){
this.dispatchException(e);
}
if(_b8=="Complete"){
this.transport.onreadystatechange=Prototype.emptyFunction;
}
},dispatchException:function(_ba){
(this.options.onException||Prototype.emptyFunction)(this,_ba);
Ajax.Responders.dispatch("onException",this,_ba);
}});
Ajax.Updater=Class.create();
Object.extend(Object.extend(Ajax.Updater.prototype,Ajax.Request.prototype),{initialize:function(_bb,url,_bd){
this.containers={success:_bb.success?$(_bb.success):$(_bb),failure:_bb.failure?$(_bb.failure):(_bb.success?null:$(_bb))};
this.transport=Ajax.getTransport();
this.setOptions(_bd);
var _be=this.options.onComplete||Prototype.emptyFunction;
this.options.onComplete=(function(_bf,_c0){
this.updateContent();
_be(_bf,_c0);
}).bind(this);
this.request(url);
},updateContent:function(){
var _c1=this.responseIsSuccess()?this.containers.success:this.containers.failure;
var _c2=this.transport.responseText;
if(!this.options.evalScripts){
_c2=_c2.stripScripts();
}
if(_c1){
if(this.options.insertion){
new this.options.insertion(_c1,_c2);
}else{
Element.update(_c1,_c2);
}
}
if(this.responseIsSuccess()){
if(this.onComplete){
setTimeout(this.onComplete.bind(this),10);
}
}
}});
Ajax.PeriodicalUpdater=Class.create();
Ajax.PeriodicalUpdater.prototype=Object.extend(new Ajax.Base(),{initialize:function(_c3,url,_c5){
this.setOptions(_c5);
this.onComplete=this.options.onComplete;
this.frequency=(this.options.frequency||2);
this.decay=(this.options.decay||1);
this.updater={};
this.container=_c3;
this.url=url;
this.start();
},start:function(){
this.options.onComplete=this.updateComplete.bind(this);
this.onTimerEvent();
},stop:function(){
this.updater.options.onComplete=undefined;
clearTimeout(this.timer);
(this.onComplete||Prototype.emptyFunction).apply(this,arguments);
},updateComplete:function(_c6){
if(this.options.decay){
this.decay=(_c6.responseText==this.lastText?this.decay*this.options.decay:1);
this.lastText=_c6.responseText;
}
this.timer=setTimeout(this.onTimerEvent.bind(this),this.decay*this.frequency*1000);
},onTimerEvent:function(){
this.updater=new Ajax.Updater(this.container,this.url,this.options);
}});
function $(){
var _c7=[],element;
for(var i=0;i<arguments.length;i++){
element=arguments[i];
if(typeof element=="string"){
element=document.getElementById(element);
}
_c7.push(Element.extend(element));
}
return _c7.reduce();
}
if(Prototype.BrowserFeatures.XPath){
document._getElementsByXPath=function(_c9,_ca){
var _cb=[];
var _cc=document.evaluate(_c9,$(_ca)||document,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null);
for(var i=0,len=_cc.snapshotLength;i<len;i++){
_cb.push(_cc.snapshotItem(i));
}
return _cb;
};
}
document.getElementsByClassName=function(_ce,_cf){
if(Prototype.BrowserFeatures.XPath){
var q=".//*[contains(concat(' ', @class, ' '), ' "+_ce+" ')]";
return document._getElementsByXPath(q,_cf);
}else{
var _d1=($(_cf)||document.body).getElementsByTagName("*");
var _d2=[],child;
for(var i=0,len=_d1.length;i<len;i++){
child=_d1[i];
if(child.className.length==0){
continue;
}
if(child.className==_ce||child.className.match(new RegExp("(^|\\s)"+_ce+"(\\s|$)"))){
_d2.push(Element.extend(child));
}
}
return _d2;
}
};
if(!window.Element){
var Element=new Object();
}
Element.extend=function(_d4){
if(!_d4){
return;
}
if(_nativeExtensions||_d4.nodeType==3){
return _d4;
}
if(!_d4._extended&&_d4.tagName&&_d4!=window){
var _d5=Object.clone(Element.Methods),cache=Element.extend.cache;
if(_d4.tagName=="FORM"){
Object.extend(_d5,Form.Methods);
}
if(["INPUT","TEXTAREA","SELECT"].include(_d4.tagName)){
Object.extend(_d5,Form.Element.Methods);
}
for(var _d6 in _d5){
var _d7=_d5[_d6];
if(typeof _d7=="function"){
_d4[_d6]=cache.findOrStore(_d7);
}
}
}
_d4._extended=true;
return _d4;
};
Element.extend.cache={findOrStore:function(_d8){
return this[_d8]=this[_d8]||function(){
return _d8.apply(null,[this].concat($A(arguments)));
};
}};
Element.Methods={visible:function(_d9){
return $(_d9).style.display!="none";
},toggle:function(_da){
_da=$(_da);
Element[Element.visible(_da)?"hide":"show"](_da);
return _da;
},hide:function(_db){
$(_db).style.display="none";
return _db;
},show:function(_dc){
$(_dc).style.display="";
return _dc;
},remove:function(_dd){
_dd=$(_dd);
_dd.parentNode.removeChild(_dd);
return _dd;
},update:function(_de,_df){
$(_de).innerHTML=_df.stripScripts();
setTimeout(function(){
_df.evalScripts();
},10);
return _de;
},replace:function(_e0,_e1){
_e0=$(_e0);
if(_e0.outerHTML){
_e0.outerHTML=_e1.stripScripts();
}else{
var _e2=_e0.ownerDocument.createRange();
_e2.selectNodeContents(_e0);
_e0.parentNode.replaceChild(_e2.createContextualFragment(_e1.stripScripts()),_e0);
}
setTimeout(function(){
_e1.evalScripts();
},10);
return _e0;
},inspect:function(_e3){
_e3=$(_e3);
var _e4="<"+_e3.tagName.toLowerCase();
$H({"id":"id","className":"class"}).each(function(_e5){
var _e6=_e5.first(),attribute=_e5.last();
var _e7=(_e3[_e6]||"").toString();
if(_e7){
_e4+=" "+attribute+"="+_e7.inspect(true);
}
});
return _e4+">";
},recursivelyCollect:function(_e8,_e9){
_e8=$(_e8);
var _ea=[];
while(_e8=_e8[_e9]){
if(_e8.nodeType==1){
_ea.push(Element.extend(_e8));
}
}
return _ea;
},ancestors:function(_eb){
return $(_eb).recursivelyCollect("parentNode");
},descendants:function(_ec){
_ec=$(_ec);
return $A(_ec.getElementsByTagName("*"));
},previousSiblings:function(_ed){
return $(_ed).recursivelyCollect("previousSibling");
},nextSiblings:function(_ee){
return $(_ee).recursivelyCollect("nextSibling");
},siblings:function(_ef){
_ef=$(_ef);
return _ef.previousSiblings().reverse().concat(_ef.nextSiblings());
},match:function(_f0,_f1){
_f0=$(_f0);
if(typeof _f1=="string"){
_f1=new Selector(_f1);
}
return _f1.match(_f0);
},up:function(_f2,_f3,_f4){
return Selector.findElement($(_f2).ancestors(),_f3,_f4);
},down:function(_f5,_f6,_f7){
return Selector.findElement($(_f5).descendants(),_f6,_f7);
},previous:function(_f8,_f9,_fa){
return Selector.findElement($(_f8).previousSiblings(),_f9,_fa);
},next:function(_fb,_fc,_fd){
return Selector.findElement($(_fb).nextSiblings(),_fc,_fd);
},getElementsBySelector:function(){
var _fe=$A(arguments),element=$(_fe.shift());
return Selector.findChildElements(element,_fe);
},getElementsByClassName:function(_ff,_100){
_ff=$(_ff);
return document.getElementsByClassName(_100,_ff);
},getHeight:function(_101){
_101=$(_101);
return _101.offsetHeight;
},classNames:function(_102){
return new Element.ClassNames(_102);
},hasClassName:function(_103,_104){
if(!(_103=$(_103))){
return;
}
return Element.classNames(_103).include(_104);
},addClassName:function(_105,_106){
if(!(_105=$(_105))){
return;
}
Element.classNames(_105).add(_106);
return _105;
},removeClassName:function(_107,_108){
if(!(_107=$(_107))){
return;
}
Element.classNames(_107).remove(_108);
return _107;
},observe:function(){
Event.observe.apply(Event,arguments);
return $A(arguments).first();
},stopObserving:function(){
Event.stopObserving.apply(Event,arguments);
return $A(arguments).first();
},cleanWhitespace:function(_109){
_109=$(_109);
var node=_109.firstChild;
while(node){
var _10b=node.nextSibling;
if(node.nodeType==3&&!/\S/.test(node.nodeValue)){
_109.removeChild(node);
}
node=_10b;
}
return _109;
},empty:function(_10c){
return $(_10c).innerHTML.match(/^\s*$/);
},childOf:function(_10d,_10e){
_10d=$(_10d),_10e=$(_10e);
while(_10d=_10d.parentNode){
if(_10d==_10e){
return true;
}
}
return false;
},scrollTo:function(_10f){
_10f=$(_10f);
var x=_10f.x?_10f.x:_10f.offsetLeft,y=_10f.y?_10f.y:_10f.offsetTop;
window.scrollTo(x,y);
return _10f;
},getStyle:function(_111,_112){
_111=$(_111);
var _113=_111.style[_112.camelize()];
if(!_113){
if(document.defaultView&&document.defaultView.getComputedStyle){
var css=document.defaultView.getComputedStyle(_111,null);
_113=css?css.getPropertyValue(_112):null;
}else{
if(_111.currentStyle){
_113=_111.currentStyle[_112.camelize()];
}
}
}
if(window.opera&&["left","top","right","bottom"].include(_112)){
if(Element.getStyle(_111,"position")=="static"){
_113="auto";
}
}
return _113=="auto"?null:_113;
},setStyle:function(_115,_116){
_115=$(_115);
for(var name in _116){
_115.style[name.camelize()]=_116[name];
}
return _115;
},getDimensions:function(_118){
_118=$(_118);
if(Element.getStyle(_118,"display")!="none"){
return {width:_118.offsetWidth,height:_118.offsetHeight};
}
var els=_118.style;
var _11a=els.visibility;
var _11b=els.position;
els.visibility="hidden";
els.position="absolute";
els.display="";
var _11c=_118.clientWidth;
var _11d=_118.clientHeight;
els.display="none";
els.position=_11b;
els.visibility=_11a;
return {width:_11c,height:_11d};
},makePositioned:function(_11e){
_11e=$(_11e);
var pos=Element.getStyle(_11e,"position");
if(pos=="static"||!pos){
_11e._madePositioned=true;
_11e.style.position="relative";
if(window.opera){
_11e.style.top=0;
_11e.style.left=0;
}
}
return _11e;
},undoPositioned:function(_120){
_120=$(_120);
if(_120._madePositioned){
_120._madePositioned=undefined;
_120.style.position=_120.style.top=_120.style.left=_120.style.bottom=_120.style.right="";
}
return _120;
},makeClipping:function(_121){
_121=$(_121);
if(_121._overflow){
return;
}
_121._overflow=_121.style.overflow||"auto";
if((Element.getStyle(_121,"overflow")||"visible")!="hidden"){
_121.style.overflow="hidden";
}
return _121;
},undoClipping:function(_122){
_122=$(_122);
if(!_122._overflow){
return;
}
_122.style.overflow=_122._overflow=="auto"?"":_122._overflow;
_122._overflow=null;
return _122;
}};
if(document.all){
Element.Methods.update=function(_123,html){
_123=$(_123);
var _125=_123.tagName.toUpperCase();
if(["THEAD","TBODY","TR","TD"].indexOf(_125)>-1){
var div=document.createElement("div");
switch(_125){
case "THEAD":
case "TBODY":
div.innerHTML="<table><tbody>"+html.stripScripts()+"</tbody></table>";
depth=2;
break;
case "TR":
div.innerHTML="<table><tbody><tr>"+html.stripScripts()+"</tr></tbody></table>";
depth=3;
break;
case "TD":
div.innerHTML="<table><tbody><tr><td>"+html.stripScripts()+"</td></tr></tbody></table>";
depth=4;
}
$A(_123.childNodes).each(function(node){
_123.removeChild(node);
});
depth.times(function(){
div=div.firstChild;
});
$A(div.childNodes).each(function(node){
_123.appendChild(node);
});
}else{
_123.innerHTML=html.stripScripts();
}
setTimeout(function(){
html.evalScripts();
},10);
return _123;
};
}
Object.extend(Element,Element.Methods);
var _nativeExtensions=false;
if(!window.HTMLElement&&/Konqueror|Safari|KHTML/.test(navigator.userAgent)){
["","Form","Input","TextArea","Select"].each(function(tag){
var _12a=window["HTML"+tag+"Element"]={};
_12a.prototype=document.createElement(tag?tag.toLowerCase():"div").__proto__;
});
}
Element.addMethods=function(_12b){
Object.extend(Element.Methods,_12b||{});
function copy(_12c,_12d){
var _12e=Element.extend.cache;
for(var _12f in _12c){
var _130=_12c[_12f];
_12d[_12f]=_12e.findOrStore(_130);
}
}
if(typeof HTMLElement!="undefined"){
copy(Element.Methods,HTMLElement.prototype);
copy(Form.Methods,HTMLFormElement.prototype);
[HTMLInputElement,HTMLTextAreaElement,HTMLSelectElement].each(function(_131){
copy(Form.Element.Methods,_131.prototype);
});
_nativeExtensions=true;
}
};
var Toggle=new Object();
Toggle.display=Element.toggle;
Abstract.Insertion=function(_132){
this.adjacency=_132;
};
Abstract.Insertion.prototype={initialize:function(_133,_134){
this.element=$(_133);
this.content=_134.stripScripts();
if(this.adjacency&&this.element.insertAdjacentHTML){
try{
this.element.insertAdjacentHTML(this.adjacency,this.content);
}
catch(e){
var _135=this.element.tagName.toLowerCase();
if(_135=="tbody"||_135=="tr"){
this.insertContent(this.contentFromAnonymousTable());
}else{
throw e;
}
}
}else{
this.range=this.element.ownerDocument.createRange();
if(this.initializeRange){
this.initializeRange();
}
this.insertContent([this.range.createContextualFragment(this.content)]);
}
setTimeout(function(){
_134.evalScripts();
},10);
},contentFromAnonymousTable:function(){
var div=document.createElement("div");
div.innerHTML="<table><tbody>"+this.content+"</tbody></table>";
return $A(div.childNodes[0].childNodes[0].childNodes);
}};
var Insertion=new Object();
Insertion.Before=Class.create();
Insertion.Before.prototype=Object.extend(new Abstract.Insertion("beforeBegin"),{initializeRange:function(){
this.range.setStartBefore(this.element);
},insertContent:function(_137){
_137.each((function(_138){
this.element.parentNode.insertBefore(_138,this.element);
}).bind(this));
}});
Insertion.Top=Class.create();
Insertion.Top.prototype=Object.extend(new Abstract.Insertion("afterBegin"),{initializeRange:function(){
this.range.selectNodeContents(this.element);
this.range.collapse(true);
},insertContent:function(_139){
_139.reverse(false).each((function(_13a){
this.element.insertBefore(_13a,this.element.firstChild);
}).bind(this));
}});
Insertion.Bottom=Class.create();
Insertion.Bottom.prototype=Object.extend(new Abstract.Insertion("beforeEnd"),{initializeRange:function(){
this.range.selectNodeContents(this.element);
this.range.collapse(this.element);
},insertContent:function(_13b){
_13b.each((function(_13c){
this.element.appendChild(_13c);
}).bind(this));
}});
Insertion.After=Class.create();
Insertion.After.prototype=Object.extend(new Abstract.Insertion("afterEnd"),{initializeRange:function(){
this.range.setStartAfter(this.element);
},insertContent:function(_13d){
_13d.each((function(_13e){
this.element.parentNode.insertBefore(_13e,this.element.nextSibling);
}).bind(this));
}});
Element.ClassNames=Class.create();
Element.ClassNames.prototype={initialize:function(_13f){
this.element=$(_13f);
},_each:function(_140){
this.element.className.split(/\s+/).select(function(name){
return name.length>0;
})._each(_140);
},set:function(_142){
this.element.className=_142;
},add:function(_143){
if(this.include(_143)){
return;
}
this.set(this.toArray().concat(_143).join(" "));
},remove:function(_144){
if(!this.include(_144)){
return;
}
this.set(this.select(function(_145){
return _145!=_144;
}).join(" "));
},toString:function(){
return this.toArray().join(" ");
}};
Object.extend(Element.ClassNames.prototype,Enumerable);
var Selector=Class.create();
Selector.prototype={initialize:function(_146){
this.params={classNames:[]};
this.expression=_146.toString().strip();
this.parseExpression();
this.compileMatcher();
},parseExpression:function(){
function abort(_147){
throw "Parse error in selector: "+_147;
}
if(this.expression==""){
abort("empty expression");
}
var _148=this.params,expr=this.expression,match,modifier,clause,rest;
while(match=expr.match(/^(.*)\[([a-z0-9_:-]+?)(?:([~\|!]?=)(?:"([^"]*)"|([^\]\s]*)))?\]$/i)){
_148.attributes=_148.attributes||[];
_148.attributes.push({name:match[2],operator:match[3],value:match[4]||match[5]||""});
expr=match[1];
}
if(expr=="*"){
return this.params.wildcard=true;
}
while(match=expr.match(/^([^a-z0-9_-])?([a-z0-9_-]+)(.*)/i)){
modifier=match[1],clause=match[2],rest=match[3];
switch(modifier){
case "#":
_148.id=clause;
break;
case ".":
_148.classNames.push(clause);
break;
case "":
case undefined:
_148.tagName=clause.toUpperCase();
break;
default:
abort(expr.inspect());
}
expr=rest;
}
if(expr.length>0){
abort(expr.inspect());
}
},buildMatchExpression:function(){
var _149=this.params,conditions=[],clause;
if(_149.wildcard){
conditions.push("true");
}
if(clause=_149.id){
conditions.push("element.id == "+clause.inspect());
}
if(clause=_149.tagName){
conditions.push("element.tagName.toUpperCase() == "+clause.inspect());
}
if((clause=_149.classNames).length>0){
for(var i=0;i<clause.length;i++){
conditions.push("Element.hasClassName(element, "+clause[i].inspect()+")");
}
}
if(clause=_149.attributes){
clause.each(function(_14b){
var _14c="element.getAttribute("+_14b.name.inspect()+")";
var _14d=function(_14e){
return _14c+" && "+_14c+".split("+_14e.inspect()+")";
};
switch(_14b.operator){
case "=":
conditions.push(_14c+" == "+_14b.value.inspect());
break;
case "~=":
conditions.push(_14d(" ")+".include("+_14b.value.inspect()+")");
break;
case "|=":
conditions.push(_14d("-")+".first().toUpperCase() == "+_14b.value.toUpperCase().inspect());
break;
case "!=":
conditions.push(_14c+" != "+_14b.value.inspect());
break;
case "":
case undefined:
conditions.push(_14c+" != null");
break;
default:
throw "Unknown operator "+_14b.operator+" in selector";
}
});
}
return conditions.join(" && ");
},compileMatcher:function(){
this.match=new Function("element","if (!element.tagName) return false;       return "+this.buildMatchExpression());
},findElements:function(_14f){
var _150;
if(_150=$(this.params.id)){
if(this.match(_150)){
if(!_14f||Element.childOf(_150,_14f)){
return [_150];
}
}
}
_14f=(_14f||document).getElementsByTagName(this.params.tagName||"*");
var _151=[];
for(var i=0;i<_14f.length;i++){
if(this.match(_150=_14f[i])){
_151.push(Element.extend(_150));
}
}
return _151;
},toString:function(){
return this.expression;
}};
Object.extend(Selector,{matchElements:function(_153,_154){
var _155=new Selector(_154);
return _153.select(_155.match.bind(_155));
},findElement:function(_156,_157,_158){
if(typeof _157=="number"){
_158=_157,_157=false;
}
return Selector.matchElements(_156,_157||"*")[_158||0];
},findChildElements:function(_159,_15a){
return _15a.map(function(_15b){
return _15b.strip().split(/\s+/).inject([null],function(_15c,expr){
var _15e=new Selector(expr);
return _15c.inject([],function(_15f,_160){
return _15f.concat(_15e.findElements(_160||_159));
});
});
}).flatten();
}});
function $$(){
return Selector.findChildElements(document,$A(arguments));
}
var Form={reset:function(form){
$(form).reset();
return form;
}};
Form.Methods={serialize:function(form){
return this.serializeElements(Form.getElements($(form)));
},serializeElements:function(_163){
var _164=new Array();
for(var i=0;i<_163.length;i++){
var _166=Form.Element.serialize(_163[i]);
if(_166){
_164.push(_166);
}
}
return _164.join("&");
},getElements:function(form){
return $A($(form).getElementsByTagName("*")).inject([],function(_168,_169){
if(Form.Element.Serializers[_169.tagName.toLowerCase()]){
_168.push(Element.extend(_169));
}
return _168;
});
},getInputs:function(form,_16b,name){
form=$(form);
var _16d=form.getElementsByTagName("input");
if(!_16b&&!name){
return _16d;
}
var _16e=new Array();
for(var i=0;i<_16d.length;i++){
var _170=_16d[i];
if((_16b&&_170.type!=_16b)||(name&&_170.name!=name)){
continue;
}
_16e.push(_170);
}
return _16e;
},disable:function(form){
form=$(form);
var _172=Form.getElements(form);
for(var i=0;i<_172.length;i++){
var _174=_172[i];
_174.blur();
_174.disabled="true";
}
return form;
},enable:function(form){
form=$(form);
var _176=Form.getElements(form);
for(var i=0;i<_176.length;i++){
var _178=_176[i];
_178.disabled="";
}
return form;
},findFirstElement:function(form){
return Form.getElements(form).find(function(_17a){
return _17a.type!="hidden"&&!_17a.disabled&&["input","select","textarea"].include(_17a.tagName.toLowerCase());
});
},focusFirstElement:function(form){
form=$(form);
Field.activate(Form.findFirstElement(form));
return form;
}};
Object.extend(Form,Form.Methods);
Form.Element={focus:function(_17c){
$(_17c).focus();
return _17c;
},select:function(_17d){
$(_17d).select();
return _17d;
}};
Form.Element.Methods={serialize:function(_17e){
_17e=$(_17e);
var _17f=_17e.tagName.toLowerCase();
var _180=Form.Element.Serializers[_17f](_17e);
if(_180){
var key=encodeURIComponent(_180[0]);
if(key.length==0){
return;
}
if(_180[1].constructor!=Array){
_180[1]=[_180[1]];
}
return _180[1].map(function(_182){
return key+"="+encodeURIComponent(_182);
}).join("&");
}
},getValue:function(_183){
_183=$(_183);
var _184=_183.tagName.toLowerCase();
var _185=Form.Element.Serializers[_184](_183);
if(_185){
return _185[1];
}
},clear:function(_186){
$(_186).value="";
return _186;
},present:function(_187){
return $(_187).value!="";
},activate:function(_188){
_188=$(_188);
_188.focus();
if(_188.select){
_188.select();
}
return _188;
},disable:function(_189){
_189=$(_189);
_189.disabled=true;
return _189;
},enable:function(_18a){
_18a=$(_18a);
_18a.blur();
_18a.disabled=false;
return _18a;
}};
Object.extend(Form.Element,Form.Element.Methods);
var Field=Form.Element;
Form.Element.Serializers={input:function(_18b){
switch(_18b.type.toLowerCase()){
case "checkbox":
case "radio":
return Form.Element.Serializers.inputSelector(_18b);
default:
return Form.Element.Serializers.textarea(_18b);
}
return false;
},inputSelector:function(_18c){
if(_18c.checked){
return [_18c.name,_18c.value];
}
},textarea:function(_18d){
return [_18d.name,_18d.value];
},select:function(_18e){
return Form.Element.Serializers[_18e.type=="select-one"?"selectOne":"selectMany"](_18e);
},selectOne:function(_18f){
var _190="",opt,index=_18f.selectedIndex;
if(index>=0){
opt=_18f.options[index];
_190=opt.value||opt.text;
}
return [_18f.name,_190];
},selectMany:function(_191){
var _192=[];
for(var i=0;i<_191.length;i++){
var opt=_191.options[i];
if(opt.selected){
_192.push(opt.value||opt.text);
}
}
return [_191.name,_192];
}};
var $F=Form.Element.getValue;
Abstract.TimedObserver=function(){
};
Abstract.TimedObserver.prototype={initialize:function(_195,_196,_197){
this.frequency=_196;
this.element=$(_195);
this.callback=_197;
this.lastValue=this.getValue();
this.registerCallback();
},registerCallback:function(){
setInterval(this.onTimerEvent.bind(this),this.frequency*1000);
},onTimerEvent:function(){
var _198=this.getValue();
if(this.lastValue!=_198){
this.callback(this.element,_198);
this.lastValue=_198;
}
}};
Form.Element.Observer=Class.create();
Form.Element.Observer.prototype=Object.extend(new Abstract.TimedObserver(),{getValue:function(){
return Form.Element.getValue(this.element);
}});
Form.Observer=Class.create();
Form.Observer.prototype=Object.extend(new Abstract.TimedObserver(),{getValue:function(){
return Form.serialize(this.element);
}});
Abstract.EventObserver=function(){
};
Abstract.EventObserver.prototype={initialize:function(_199,_19a){
this.element=$(_199);
this.callback=_19a;
this.lastValue=this.getValue();
if(this.element.tagName.toLowerCase()=="form"){
this.registerFormCallbacks();
}else{
this.registerCallback(this.element);
}
},onElementEvent:function(){
var _19b=this.getValue();
if(this.lastValue!=_19b){
this.callback(this.element,_19b);
this.lastValue=_19b;
}
},registerFormCallbacks:function(){
var _19c=Form.getElements(this.element);
for(var i=0;i<_19c.length;i++){
this.registerCallback(_19c[i]);
}
},registerCallback:function(_19e){
if(_19e.type){
switch(_19e.type.toLowerCase()){
case "checkbox":
case "radio":
Event.observe(_19e,"click",this.onElementEvent.bind(this));
break;
default:
Event.observe(_19e,"change",this.onElementEvent.bind(this));
break;
}
}
}};
Form.Element.EventObserver=Class.create();
Form.Element.EventObserver.prototype=Object.extend(new Abstract.EventObserver(),{getValue:function(){
return Form.Element.getValue(this.element);
}});
Form.EventObserver=Class.create();
Form.EventObserver.prototype=Object.extend(new Abstract.EventObserver(),{getValue:function(){
return Form.serialize(this.element);
}});
if(!window.Event){
var Event=new Object();
}
Object.extend(Event,{KEY_BACKSPACE:8,KEY_TAB:9,KEY_RETURN:13,KEY_ESC:27,KEY_LEFT:37,KEY_UP:38,KEY_RIGHT:39,KEY_DOWN:40,KEY_DELETE:46,KEY_HOME:36,KEY_END:35,KEY_PAGEUP:33,KEY_PAGEDOWN:34,element:function(_19f){
return _19f.target||_19f.srcElement;
},isLeftClick:function(_1a0){
return (((_1a0.which)&&(_1a0.which==1))||((_1a0.button)&&(_1a0.button==1)));
},pointerX:function(_1a1){
return _1a1.pageX||(_1a1.clientX+(document.documentElement.scrollLeft||document.body.scrollLeft));
},pointerY:function(_1a2){
return _1a2.pageY||(_1a2.clientY+(document.documentElement.scrollTop||document.body.scrollTop));
},stop:function(_1a3){
if(_1a3.preventDefault){
_1a3.preventDefault();
_1a3.stopPropagation();
}else{
_1a3.returnValue=false;
_1a3.cancelBubble=true;
}
},findElement:function(_1a4,_1a5){
var _1a6=Event.element(_1a4);
while(_1a6.parentNode&&(!_1a6.tagName||(_1a6.tagName.toUpperCase()!=_1a5.toUpperCase()))){
_1a6=_1a6.parentNode;
}
return _1a6;
},observers:false,_observeAndCache:function(_1a7,name,_1a9,_1aa){
if(!this.observers){
this.observers=[];
}
if(_1a7.addEventListener){
this.observers.push([_1a7,name,_1a9,_1aa]);
_1a7.addEventListener(name,_1a9,_1aa);
}else{
if(_1a7.attachEvent){
this.observers.push([_1a7,name,_1a9,_1aa]);
_1a7.attachEvent("on"+name,_1a9);
}
}
},unloadCache:function(){
if(!Event.observers){
return;
}
for(var i=0;i<Event.observers.length;i++){
Event.stopObserving.apply(this,Event.observers[i]);
Event.observers[i][0]=null;
}
Event.observers=false;
},observe:function(_1ac,name,_1ae,_1af){
_1ac=$(_1ac);
_1af=_1af||false;
if(name=="keypress"&&(navigator.appVersion.match(/Konqueror|Safari|KHTML/)||_1ac.attachEvent)){
name="keydown";
}
Event._observeAndCache(_1ac,name,_1ae,_1af);
},stopObserving:function(_1b0,name,_1b2,_1b3){
_1b0=$(_1b0);
_1b3=_1b3||false;
if(name=="keypress"&&(navigator.appVersion.match(/Konqueror|Safari|KHTML/)||_1b0.detachEvent)){
name="keydown";
}
if(_1b0.removeEventListener){
_1b0.removeEventListener(name,_1b2,_1b3);
}else{
if(_1b0.detachEvent){
try{
_1b0.detachEvent("on"+name,_1b2);
}
catch(e){
}
}
}
}});
if(navigator.appVersion.match(/\bMSIE\b/)){
Event.observe(window,"unload",Event.unloadCache,false);
}
var Position={includeScrollOffsets:false,prepare:function(){
this.deltaX=window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft||0;
this.deltaY=window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop||0;
},realOffset:function(_1b4){
var _1b5=0,valueL=0;
do{
_1b5+=_1b4.scrollTop||0;
valueL+=_1b4.scrollLeft||0;
_1b4=_1b4.parentNode;
}while(_1b4);
return [valueL,_1b5];
},cumulativeOffset:function(_1b6){
var _1b7=0,valueL=0;
do{
_1b7+=_1b6.offsetTop||0;
valueL+=_1b6.offsetLeft||0;
_1b6=_1b6.offsetParent;
}while(_1b6);
return [valueL,_1b7];
},positionedOffset:function(_1b8){
var _1b9=0,valueL=0;
do{
_1b9+=_1b8.offsetTop||0;
valueL+=_1b8.offsetLeft||0;
_1b8=_1b8.offsetParent;
if(_1b8){
if(_1b8.tagName=="BODY"){
break;
}
var p=Element.getStyle(_1b8,"position");
if(p=="relative"||p=="absolute"){
break;
}
}
}while(_1b8);
return [valueL,_1b9];
},offsetParent:function(_1bb){
if(_1bb.offsetParent){
return _1bb.offsetParent;
}
if(_1bb==document.body){
return _1bb;
}
while((_1bb=_1bb.parentNode)&&_1bb!=document.body){
if(Element.getStyle(_1bb,"position")!="static"){
return _1bb;
}
}
return document.body;
},within:function(_1bc,x,y){
if(this.includeScrollOffsets){
return this.withinIncludingScrolloffsets(_1bc,x,y);
}
this.xcomp=x;
this.ycomp=y;
this.offset=this.cumulativeOffset(_1bc);
return (y>=this.offset[1]&&y<this.offset[1]+_1bc.offsetHeight&&x>=this.offset[0]&&x<this.offset[0]+_1bc.offsetWidth);
},withinIncludingScrolloffsets:function(_1bf,x,y){
var _1c2=this.realOffset(_1bf);
this.xcomp=x+_1c2[0]-this.deltaX;
this.ycomp=y+_1c2[1]-this.deltaY;
this.offset=this.cumulativeOffset(_1bf);
return (this.ycomp>=this.offset[1]&&this.ycomp<this.offset[1]+_1bf.offsetHeight&&this.xcomp>=this.offset[0]&&this.xcomp<this.offset[0]+_1bf.offsetWidth);
},overlap:function(mode,_1c4){
if(!mode){
return 0;
}
if(mode=="vertical"){
return ((this.offset[1]+_1c4.offsetHeight)-this.ycomp)/_1c4.offsetHeight;
}
if(mode=="horizontal"){
return ((this.offset[0]+_1c4.offsetWidth)-this.xcomp)/_1c4.offsetWidth;
}
},page:function(_1c5){
var _1c6=0,valueL=0;
var _1c7=_1c5;
do{
_1c6+=_1c7.offsetTop||0;
valueL+=_1c7.offsetLeft||0;
if(_1c7.offsetParent==document.body){
if(Element.getStyle(_1c7,"position")=="absolute"){
break;
}
}
}while(_1c7=_1c7.offsetParent);
_1c7=_1c5;
do{
if(!window.opera||_1c7.tagName=="BODY"){
_1c6-=_1c7.scrollTop||0;
valueL-=_1c7.scrollLeft||0;
}
}while(_1c7=_1c7.parentNode);
return [valueL,_1c6];
},clone:function(_1c8,_1c9){
var _1ca=Object.extend({setLeft:true,setTop:true,setWidth:true,setHeight:true,offsetTop:0,offsetLeft:0},arguments[2]||{});
_1c8=$(_1c8);
var p=Position.page(_1c8);
_1c9=$(_1c9);
var _1cc=[0,0];
var _1cd=null;
if(Element.getStyle(_1c9,"position")=="absolute"){
_1cd=Position.offsetParent(_1c9);
_1cc=Position.page(_1cd);
}
if(_1cd==document.body){
_1cc[0]-=document.body.offsetLeft;
_1cc[1]-=document.body.offsetTop;
}
if(_1ca.setLeft){
_1c9.style.left=(p[0]-_1cc[0]+_1ca.offsetLeft)+"px";
}
if(_1ca.setTop){
_1c9.style.top=(p[1]-_1cc[1]+_1ca.offsetTop)+"px";
}
if(_1ca.setWidth){
_1c9.style.width=_1c8.offsetWidth+"px";
}
if(_1ca.setHeight){
_1c9.style.height=_1c8.offsetHeight+"px";
}
},absolutize:function(_1ce){
_1ce=$(_1ce);
if(_1ce.style.position=="absolute"){
return;
}
Position.prepare();
var _1cf=Position.positionedOffset(_1ce);
var top=_1cf[1];
var left=_1cf[0];
var _1d2=_1ce.clientWidth;
var _1d3=_1ce.clientHeight;
_1ce._originalLeft=left-parseFloat(_1ce.style.left||0);
_1ce._originalTop=top-parseFloat(_1ce.style.top||0);
_1ce._originalWidth=_1ce.style.width;
_1ce._originalHeight=_1ce.style.height;
_1ce.style.position="absolute";
_1ce.style.top=top+"px";
_1ce.style.left=left+"px";
_1ce.style.width=_1d2+"px";
_1ce.style.height=_1d3+"px";
},relativize:function(_1d4){
_1d4=$(_1d4);
if(_1d4.style.position=="relative"){
return;
}
Position.prepare();
_1d4.style.position="relative";
var top=parseFloat(_1d4.style.top||0)-(_1d4._originalTop||0);
var left=parseFloat(_1d4.style.left||0)-(_1d4._originalLeft||0);
_1d4.style.top=top+"px";
_1d4.style.left=left+"px";
_1d4.style.height=_1d4._originalHeight;
_1d4.style.width=_1d4._originalWidth;
}};
if(/Konqueror|Safari|KHTML/.test(navigator.userAgent)){
Position.cumulativeOffset=function(_1d7){
var _1d8=0,valueL=0;
do{
_1d8+=_1d7.offsetTop||0;
valueL+=_1d7.offsetLeft||0;
if(_1d7.offsetParent==document.body){
if(Element.getStyle(_1d7,"position")=="absolute"){
break;
}
}
_1d7=_1d7.offsetParent;
}while(_1d7);
return [valueL,_1d8];
};
}
Element.addMethods();

