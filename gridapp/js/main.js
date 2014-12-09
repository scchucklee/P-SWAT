jQuery(document).ready(function () {

 jQuery('#addNewApp').click(function() { //添加新应用
	 
	var addedName = jQuery('#appName').val();
	var output = "<input type='checkbox' id='app[]' name='app' value='"+addedName+"' class='label_check'/>&nbsp;" +
			     "<label style='margin-right:15px;'>"+addedName+"</label>";
	jQuery('.chooseAppRegion').append(output);
 });

 jQuery('#chooseall').click(function() { //全选
	 jQuery("[name='app']").attr("checked",'true');
 });
 
 jQuery('#cancelchooseall').click(function() {  //反选
	 jQuery("[name='app']").each(function(){  
		 if(jQuery(this).attr("checked")){  
			 jQuery(this).removeAttr("checked");  
		 }  
		 else{  
			 jQuery(this).attr("checked",'true');  
		 }  
	 }); 
 });
 
 jQuery('#appName').mousedown(function(){  //应用输入框的mousedown事件
	 jQuery('.selectappli').css("display","block"); //使应用列表可见
 });

 jQuery('.selectappli li').click(function(){
	 jQuery('#appName').val(jQuery(this).text()); //给输入框赋值
	 //jQuery('#appName,.selectappli').blur(function(){  //应用输入框的失去焦点事件   focus：为得到焦点事件
	 jQuery('.selectappli').css("display","none"); //使应用列表不可见
 });

 document.onclick=function(e){  //点击其他地方，隐藏应用列表
     var e=e?e:window.event;  
     var tar = e.srcElement||e.target;  
     if(jQuery(tar).attr("class")=="selectappli" || jQuery(tar).attr("id")=="appName"){  
    	 jQuery('.selectappli').css("display","block")  
     }else{  
    	 jQuery('.selectappli').css("display","none");  
     }
     /*if(jQuery(tar).attr("class")=="dropdown-menu"){  
    	 jQuery('.dropdown-menu').css("display","block")  
     }else{  
    	 jQuery('.dropdown-menu').css("display","none");  
    	 jQuery('.ty-link').css("background-color","rgb(57, 203, 189)");
    	 jQuery('.ty-link').css("color","white");
     }*/
 } 
 
 jQuery('.ty-link' +', ' + '.dropdown-menu').hover(function(r){  //header导航条用户名的hover事件
	 jQuery('.dropdown-menu').css("display","block"); //使用户下拉列表可见
	 jQuery('.dropdown-menu').show('slow');
	 jQuery('.ty-link').css("background-color","#fff");
	 jQuery('.ty-link').css("color","rgb(57, 203, 189)");
 }, function(r) {
	 jQuery('.dropdown-menu').css("display","none");  
	 jQuery('.ty-link').css("background-color","rgb(57, 203, 189)");
	 jQuery('.ty-link').css("color","white");
 });
 
  jQuery('#aboutplatform' +', ' + '.newdropdown-menu').hover(function(r){ //关于平台的hover事件
	  jQuery('.newdropdown-menu').css('display', 'block');
	  jQuery('#aboutplatform').css("background-color","#06755f");
  }, function(r) {
	  jQuery('.newdropdown-menu').css('display', 'none');
	  jQuery('#aboutplatform').css("background-color","rgb(57, 203, 189)");
  });
 
 jQuery('#new-password,#current-password,#confirm-password').keyup(function(){  //密码框的keyup事件
	 
	 if(jQuery('#current-password').attr("value")!="" && jQuery('#new-password').attr("value").length >5 && jQuery('#confirm-password').attr("value").length >5){
		 jQuery('#submit-password').attr("disabled",false);
	 }else{
		 jQuery('#submit-password').attr("disabled",true);
	 }
 });
 
 jQuery('#new-password').keyup(function(){
	jQuery('.count').removeClass("hide"); //使提示可见
	jQuery('.current-count').addClass("font-error");
	jQuery(this).parent().css("margin-left","-414px"); //让上一层div 输入框对齐
	jQuery('.current-count').html(jQuery('#new-password').attr("value").length);
 });
 
 jQuery('#editval').click(function() { //点击编辑按钮，让输入框和另两个按钮可用
	 jQuery('.allparsdiv input').attr("disabled",false);
	 jQuery('#canceledit').removeClass("adisabledstyle");
	 jQuery('#canceledit').addClass("linkstyle");
	 jQuery('#saveedit').removeClass("adisabledstyle");
	 jQuery('#saveedit').addClass("linkstyle");
 });
 
 var isRight =true;
 jQuery('.allparsdiv input').blur(function(){  //失去焦点事件，判断参数值输入是否合法
	 var scope = jQuery(this).siblings('h4').attr("title");
	 var scopeArr = new Array();
	 scopeArr = scope.split("~");
	 var parValue =jQuery(this).attr("value");
	 if(parValue==""){
		 layer.tips("The value can't be null,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:155,
		        time: 2
		 });  //提示信息，代替alert
		 jQuery(this).addClass("back-error");
		 isRight =false;
	 }else if(parseFloat(parValue) < parseFloat(scopeArr[0]) || parseFloat(parValue) > parseFloat(scopeArr[1])){
		 layer.tips("The value is beyond the scope,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:155,
		        time: 2
		 }); 
		 jQuery(this).addClass("back-error");
		 isRight =false;
	 }else if(isNaN(parValue)){
		 layer.tips("Please input numbers only!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:155,
		        time: 2
		 });
		 jQuery(this).addClass("back-error");
		 isRight =false;
	 }else{
		 jQuery(this).removeClass("back-error");
		 isRight =true;
	 }
 });
 
 jQuery('#saveedit').click(function() { //保存编辑后的值到文件中
	 //var parsValArray = new Array();
	 if(isRight){
	  var parsVarStr ="";
	  jQuery('.allparsdiv input').each(function(){
		 //parsValArray.push(jQuery(this).attr("value"));
		 parsVarStr += jQuery(this).attr("value")+" ";
	  });
	  //var parsValJson = JSON.stringify(parsValArray);
	  $.ajax({  
         type:"GET" 
        ,url:"http://localhost/gridapp/index.php/home/save_edits"  
        ,data:{parsStr:parsVarStr}                                
        ,contentType:'text/html; charset=utf-8'//编码格式  
        ,beforeSend:function(data){  
            
         }//发送请求前  
        ,success:function(data){         	
        	layer.msg(data, 2, -1);
         }//请求成功后  
        ,error:function(data){  
        	layer.tips("Failed to Save Edits!", this, {
    		    style: ['background-color:#c00; color:#fff', '#c00'],
    	        maxWidth:155,
    	        time: 2
    	    });
        }//请求错误  
       ,complete:function(data){  
          
        }//请求完成  
     });  
   }else{
	   layer.tips("Please modify your input first!", this, {
		    style: ['background-color:#c00; color:#fff', '#c00'],
	        maxWidth:155,
	        time: 2
	   });
   }
	 
 });
 
 jQuery('#outputfilename').blur(function(){ 
	 var parValue =jQuery(this).attr("value");
	 if(parValue==""){
		 layer.tips("The value can't be null,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 }); 
		 jQuery(this).addClass("back-error");
     }else{
		 jQuery(this).removeClass("back-error");
		 
	 }
 });
 jQuery('#RunTime,#CPUNum,#SeedNum').blur(function(){ 
	 var parValue =jQuery(this).attr("value");
	 var re = /^[1-9]+[0-9]*]*$/;
	 if(parValue==""){
		 layer.tips("The value can't be null,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 }); 
		 jQuery(this).addClass("back-error");
     }else if(!re.test(parValue)){
    	 layer.tips("The value should be a positive integer,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 });
		 jQuery(this).addClass("back-error");
     }else{
		 jQuery(this).removeClass("back-error");
		 
	 }
 });
 jQuery('#Percent').blur(function(){ 
	 var parValue =jQuery(this).attr("value");
	 if(parValue==""){
		 layer.tips("The value can't be null,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 }); 
		 jQuery(this).addClass("back-error");
     }else if(parseFloat(parValue) < 0 || parseFloat(parValue) > 1){
		 layer.tips("The value is beyond the scope,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 }); 
		 jQuery(this).addClass("back-error");
		 
	 }else if(isNaN(parValue)){
		 layer.tips("Please input numbers only!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 });
		 jQuery(this).addClass("back-error");
		 
	 }else{
		 jQuery(this).removeClass("back-error");
		 
	 }
 });
 jQuery('#SeedNum').blur(function(){ 
	 var parValue =jQuery(this).attr("value");
	 if(parValue != jQuery('#CPUNum').attr("value") && parseInt(parValue) != 0.5*parseInt(jQuery('#CPUNum').attr("value"))){
		 layer.tips("The value should be 1 or 1/2 times of CPU number,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 });
		 jQuery(this).addClass("back-error");
     }else{
		 jQuery(this).removeClass("back-error");
		 
	 }
 });
 jQuery('#realname,#department').blur(function(){ 
	 var parValue =jQuery(this).attr("value");
	 if(parValue==""){
		 layer.tips("The value can't be null,please input again!", this, {
			    style: ['background-color:#c00; color:#fff', '#c00'],
		        maxWidth:200,
		        guide: 1,
		        time: 2
		 }); 
		 jQuery(this).addClass("back-error");
     }else{
		 jQuery(this).removeClass("back-error");	 
	 }
 });
 
 
});

function check()
{
	var valid = true;
	if(jQuery('#outputfilename').attr("value") ==""){
		alert("The outputfilename value can't be null,please input again!");
	    jQuery('#outputfilename').addClass("back-error");
	    valid = false;
	}
	var parValuePercent =jQuery('#Percent').attr("value");
	if(parValuePercent=="" || parseFloat(parValuePercent) < 0 || parseFloat(parValuePercent) > 1 ||isNaN(parValuePercent)){
		alert("Please input the correct Percent value!"); 
	    jQuery('#Percent').addClass("back-error");
	    valid = false;
	}
	var parValueSeed =jQuery('#SeedNum').attr("value");
	if(parValueSeed=="" || parValueSeed != jQuery('#CPUNum').attr("value") && parseInt(parValueSeed) != 0.5*parseInt(jQuery('#CPUNum').attr("value"))){
		alert("Please input the correct SeedNum value!"); 
	    jQuery('#SeedNum').addClass("back-error");
	    valid = false;
	}
	//if(valid) jQuery('#submit_form').submit();
	 var parsVarStr ="";
	 jQuery('.allparsdiv input').each(function(){
		 parsVarStr += jQuery(this).attr("value")+" ";
	 });
	 $.ajax({  
        type:"GET" 
       ,url:"http://localhost/gridapp/index.php/submitpswat/getParsVarStr/"+parsVarStr  
       ,data:{id:1}                            
       ,contentType:'text/html; charset=utf-8'//编码格式  
       ,beforeSend:function(data){  
           
        }//发送请求前  
       ,success:function(data){         	
       	   alert(data);
        }//请求成功后  
    });  
	return valid;
}
function viewoutputfile(gid ,fname)
{
	$.layer({
        type: 2,
        title:fname, //标题栏
        maxmin: true,
        shadeClose: true,
        shade: [0.1,'#fff'],
        offset: ['75px',''],
        area: ['970px', ($(window).height() - 150) +'px'],
        iframe: {src: 'http://localhost/gridapp/index.php/inquiryqueue/viewORDownload_eachjob/view/'+gid+'/'+fname}
    });
}
function checkdownloadinfo()
{
	var valid = true;
	if(jQuery('#realname').attr("value") ==""){
		alert("Your real name value can't be null,please input again!");
	    jQuery('#realname').addClass("back-error");
	    valid = false;
	}
	if(jQuery('#department').attr("value") ==""){
		alert("Your department value can't be null,please input again!");
	    jQuery('#department').addClass("back-error");
	    valid = false;
	}
	return valid;
}