<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>History Jobs</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
    <script src="<?=base_url()?>js/layer/layer.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>js/highcharts/highcharts.js" type="text/javascript"></script>
    <script src="<?=base_url()?>js/highcharts/exporting.js" type="text/javascript"></script>
    <script type="text/javascript">
       function seeOutputfile(dom){
         var gid =dom.getAttribute("name");
         //alert(gid); 
   	     $.ajax({  
          type:"GET" 
         ,url:"<?=base_url()?>index.php/inquiryqueue/inquiry_eachjob/"+gid  
         ,data:{id:gid}                                
         ,contentType:'text/html;charset=utf-8'//编码格式  
         ,beforeSend:function(data){  
            //$('.contentline').after('<p>loading...</p>');  
          }//发送请求前  
         ,success:function(data){  
           //$('.contentline').after(data); 
           $('.centerstyle').empty();//每次加载前，先清空之前添加的
           $(dom).parent().parent().after(data);   
          }//请求成功后  
         ,error:function(data){  
           $('.contentline').html('failed to show output file.')  
         }//请求错误  
        });  	
        		
       }
    </script>
     <script type="text/javascript">
     $(function () {
       var options = {
        chart: {
            renderTo: 'container'
        },
        title: {
            text: '能量值变化曲线图',
            x: -20 //center
        },
        subtitle: {
            text: '来源：PSWAT作业输出',
            x: -20
        },
        xAxis: {
            categories: ['1', '2', '3', '4', '5', '6',
                '7', '8', '9', '10', '11', '12','13', '14', '15', '16', '17', '18']
        },
        yAxis: {
            title: {
                text: 'NSE (less than 1)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        
        series: [{}]
       };	
       
       $('#seeGraph').live('click',function() { //动态添加的元素的事件，用live绑定
	       $.ajax({  
           type:"GET" 
          ,url:"<?=base_url()?>index.php/inquiryqueue/getNSEValue/1/xin"
          ,data:{id:1}                                
          ,contentType:'text/html;charset=utf-8'//编码格式  
          ,beforeSend:function(data){  
            
          }//发送请求前  
          ,success:function(data){  
            //var str = data.substring(0,data.length-1) //去掉最后一个字符'_'
            //var arr = str.split('_');
            //alert(data);
            var ujid = $('#seeGraph').parent().parent().parent().prev().attr('name'); //获得作业号
            var ujidname ='作业'+ujid;
            options.series[0].name = ujidname;
            options.series[0].data = data;
            var chart = new Highcharts.Chart(options);
            $('#jobidname').html(ujidname);
          }//请求成功后  
         ,error:function(data){  
            alert('failed!'); 
          }//请求错误  
        });  	
        
	       $('.curvecontainer').css("display",'block');
       });
       $('.closeclick').click(function() { 
	       $('.curvecontainer').css("display",'none');
       });
       
       $('.curvecontainer').mousedown(  //拖到div
              function (event) {  
                       var isMove = true;  
                       var abs_x = event.pageX - $('.curvecontainer').offset().left;  
                       var abs_y = event.pageY - $('.curvecontainer').offset().top;  
                       $(document).mousemove(function (event) {  
                              if (isMove) {  
                                    var obj = $('.curvecontainer');  
                                    obj.css({'left':event.pageX - abs_x, 'top':event.pageY - abs_y});  
                                  }  
                              }  
                       ).mouseup(  
                             function () {  
                                isMove = false;  
                             }  
                      );  
              }  
        );  
                
  });
    </script>  
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
<div id="content">
 <h2 class="submitfont" style="margin-top:40px;">所有已提交的任务</h2> <!-- <a href="<?=site_url('inquiryqueue/getNSEValue/1/xin')?>">test</a> -->
  <div class="curvecontainer">
  <div class="shutdowndiv"><h3 style="line-height:40px;"><span id="jobidname">作业99</span><span class="closeclick"><img src="<?=base_url()?>img/close.png" style="width:40px;height:40px;" /></span></h3></div>
  <div id="container"></div>
  </div>
 <div style="width:970px;height:auto;margin:10px 15px 10px 15px;">
  <div class="headline">
    <div class="jobheadstyle" style="width:50px;">序号</div><div class="jobheadstyle" style="width:130px;">作业名称</div><div class="jobheadstyle">队列名称</div><div class="jobheadstyle" style="width:80px;">规模</div><div class="jobheadstyle">应用程序</div><div class="jobheadstyle" style="width:180px;">提交时间</div><div class="jobheadstyle">计算时间</div><div class="jobheadstyle" style="width:70px;">状态</div><div class="jobheadstyle" style="width:130px;">操作</div> 
  </div>
  <?php foreach($jobs_list_arr as $_job): ?>
  <div class="contentline" name="<?php echo $_job['ujid']; ?>">
    <div class="jobheadstyle" style="width:50px;"><?php echo $_job['ujid']; ?></div><div class="jobheadstyle" style="width:130px;"><?php echo tran_job_name($_job['job_name']); ?></div><div class="jobheadstyle"><?php echo $_job['queue_name']; ?></div><div class="jobheadstyle" style="width:80px;"><?php echo $_job['corenum']; ?></div><div class="jobheadstyle"><?php echo $_job['applicationname']; ?></div><div class="jobheadstyle" style="width:180px;"><?php echo date("Y-m-d H:i:s",$_job['submit_time']+28800); ?></div><div class="jobheadstyle"><?php echo $_job['walltime']; ?></div><div class="jobheadstyle" style="width:70px;"><?php echo tran_status_code($_job['status']); ?></div><div class="jobheadstyle" style="width:130px;"><a name="<?php echo $_job['gid']; ?>" style="cursor:pointer;color:blue;" onclick="seeOutputfile(this)" class="linkstyle">查看输出文件</a>&nbsp; <a href="<?=site_url('inquiryqueue/terminate_eachjob/'.$_job['gid'])?>" class="linkstyle" style="display:<?php echo $_job['status']<20?'':'none'; ?>">终止</a></div> 
  </div>
  <?php endforeach; ?>
 </div>
 <div class='paging'><?php echo $this->pagination->create_links();?></div>
</div>
<?php $this->load->view('footer') ?>
</body>
</html>