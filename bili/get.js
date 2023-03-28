function bilibid(bvid){$.ajax({type:'get',dataType:'jsonp',cache:false,url:'https://api.bilibili.com/x/web-interface/view?jsonp=jsonp&bvid='+bvid,success:function(res){console.log(res);var data=res;console.log(data.code)
var video=data.code;var result=$('#bilipic .info');var strhtml='获取失败,请重新检查av/bv号';if(video==0){var obj=data.data.pic;console.log(obj)
strhtml='<a href="'+obj+'" rel="noreferrer" target="_blank" >'+obj+'</br>';}
result.html('<div class="alert"><button type="button" class="close" data-dismiss="alert">x</button>'+strhtml+'</div>');},error:function(res){}});}
function biliaid(aid){$.ajax({type:'get',dataType:'jsonp',cache:false,url:'https://api.bilibili.com/x/web-interface/view?jsonp=jsonp&aid='+aid,success:function(res){console.log(res);var data=res;console.log(data.code)
var video=data.code;var result=$('#bilipic .info');var strhtml='获取失败,请重新检查av/bv号';if(video==0){var obj=data.data.pic;console.log(obj)
strhtml='<a href="'+obj+'" rel="noreferrer" target="_blank" >'+obj+'</br>';}
result.html('<div class="alert"><button type="button" class="close" data-dismiss="alert">x</button>'+strhtml+'</div>');},error:function(res){}});}