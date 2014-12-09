<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>平台介绍-SCGG</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script> 
    <script src="<?=base_url()?>js/highcharts/highcharts.js" type="text/javascript"></script>
    <script src="<?=base_url()?>js/highcharts/exporting.js" type="text/javascript"></script>
    <script type="text/javascript">
     $(function () {
       $('#container').highcharts({
        title: {
            text: '用户访问量曲线图',
            x: -20 //center
        },
        subtitle: {
            text: '来源：用户点击',
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Number (greater than 0)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '浏览用户',
            data: [5, 11, 15, 22, 28, 40, 52, 59, 70, 81, 92, 101]
        }, {
            name: '下载用户',
            data: [2, 4, 5, 9, 12, 19, 28, 36, 45, 50, 59, 71]
        }, {
            name: '深度访问用户',
            data: [1, 2, 4, 7, 13, 18, 26, 30, 47, 52, 67, 73]
        }]
    });
  });
    </script>  
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
 <div id="content">
     <h2 class="submitfont" style="margin-top:30px;color:black;">PSWAT平台简介</h2>
     <p class="greyfont" style="text-align:left;margin:5px 20px 20px 20px;text-indent:2em;">超算地理学网格（Supercomputing Geography Grid,简称SCGG），是依托于中国科学院网格计算环境，对P-SWAT或SWAT应用进行单一作业提交、管理以及智能调参的一个综合管理平台。此平台依托于中国科学院超级计算环境。</p>
     <p class="greyfont" style="text-align:left;margin:5px 20px 20px 20px;text-indent:2em;">中国科学院超级计算环境（China ScGrid，简称ScGrid），它是由总中心、8个分中心、18个所级中心组成的三层架构网格计算环境，同时还连接了院内11家单位的GPU计算集群，聚合通用计算能力近300万亿次，GPU计算能力近3000万亿次。截止2013年12月，ScGrid累计开放外部账号233个，累计使用机时近6200万CPU小时。</p>
     <p class="greyfont" style="text-align:left;margin:5px 20px 20px 20px;text-indent:2em;">SWAT（Soil and Water Assessment Tool）是由美国农业部（USDA）的农业研究中心Jeff Amonld博士1994年开发的。模型开发的最初目的是为了预测在大流域复杂多变的土壤类型、土地利用方式和管理措施条件下，土地管理对水分、泥沙和化学物质的长期影响。SWAT模型采用日为时间连续计算。是一种基于GIS基础之上的分布式流域水文模型，近年来得到了快速的发展和应用，主要是利用遥感和地理信息系统提供的空间信息模拟多种不同的水文物理化学过程，如水量、水质、以及杀虫剂的输移与转化过程。</p>
     <p class="greyfont" style="text-align:left;margin:5px 20px 30px 20px;text-indent:2em;">PSWAT（即Parallel SWAT），是在原SWAT的基础上，引入随机数种子，加入并行算法，利用中科院超算网格的计算资源，可以更快、更准确的处理水文应用。PSWAT放在该平台上，也省去了用户通过命令行的方式来运行应用的烦恼、不便，提升了用户体验。</p>
     <a href="http://cscgrid.cas.cn/yhfw/zhsq1/" class="linkstyle" target="_blank">账号申请>></a> <a href="http://cscgrid.cas.cn/yhfw/pxjc/" class="linkstyle" style="margin-left:20px;" target="_blank">培训/教程>></a>
     <div id="container" style=""></div>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>