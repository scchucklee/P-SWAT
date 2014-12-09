<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>ƽ̨����-SCGG</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script> 
    <script src="<?=base_url()?>js/highcharts/highcharts.js" type="text/javascript"></script>
    <script src="<?=base_url()?>js/highcharts/exporting.js" type="text/javascript"></script>
    <script type="text/javascript">
     $(function () {
       $('#container').highcharts({
        title: {
            text: '�û�����������ͼ',
            x: -20 //center
        },
        subtitle: {
            text: '��Դ���û����',
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
            name: '����û�',
            data: [5, 11, 15, 22, 28, 40, 52, 59, 70, 81, 92, 101]
        }, {
            name: '�����û�',
            data: [2, 4, 5, 9, 12, 19, 28, 36, 45, 50, 59, 71]
        }, {
            name: '��ȷ����û�',
            data: [1, 2, 4, 7, 13, 18, 26, 30, 47, 52, 67, 73]
        }]
    });
  });
    </script>  
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
 <div id="content">
     <h2 class="submitfont" style="margin-top:30px;color:black;">PSWATƽ̨���</h2>
     <p class="greyfont" style="text-align:left;margin:5px 20px 20px 20px;text-indent:2em;">�������ѧ����Supercomputing Geography Grid,���SCGG�������������й���ѧԺ������㻷������P-SWAT��SWATӦ�ý��е�һ��ҵ�ύ�������Լ����ܵ��ε�һ���ۺϹ���ƽ̨����ƽ̨�������й���ѧԺ�������㻷����</p>
     <p class="greyfont" style="text-align:left;margin:5px 20px 20px 20px;text-indent:2em;">�й���ѧԺ�������㻷����China ScGrid�����ScGrid���������������ġ�8�������ġ�18������������ɵ�����ܹ�������㻷����ͬʱ��������Ժ��11�ҵ�λ��GPU���㼯Ⱥ���ۺ�ͨ�ü���������300���ڴΣ�GPU����������3000���ڴΡ���ֹ2013��12�£�ScGrid�ۼƿ����ⲿ�˺�233�����ۼ�ʹ�û�ʱ��6200��CPUСʱ��</p>
     <p class="greyfont" style="text-align:left;margin:5px 20px 20px 20px;text-indent:2em;">SWAT��Soil and Water Assessment Tool����������ũҵ����USDA����ũҵ�о�����Jeff Amonld��ʿ1994�꿪���ġ�ģ�Ϳ��������Ŀ����Ϊ��Ԥ���ڴ������Ӷ����������͡��������÷�ʽ�͹����ʩ�����£����ع����ˮ�֡���ɳ�ͻ�ѧ���ʵĳ���Ӱ�졣SWATģ�Ͳ�����Ϊʱ���������㡣��һ�ֻ���GIS����֮�ϵķֲ�ʽ����ˮ��ģ�ͣ��������õ��˿��ٵķ�չ��Ӧ�ã���Ҫ������ң�к͵�����Ϣϵͳ�ṩ�Ŀռ���Ϣģ����ֲ�ͬ��ˮ������ѧ���̣���ˮ����ˮ�ʡ��Լ�ɱ�����������ת�����̡�</p>
     <p class="greyfont" style="text-align:left;margin:5px 20px 30px 20px;text-indent:2em;">PSWAT����Parallel SWAT��������ԭSWAT�Ļ����ϣ�������������ӣ����벢���㷨�������п�Ժ��������ļ�����Դ�����Ը��졢��׼ȷ�Ĵ���ˮ��Ӧ�á�PSWAT���ڸ�ƽ̨�ϣ�Ҳʡȥ���û�ͨ�������еķ�ʽ������Ӧ�õķ��ա����㣬�������û����顣</p>
     <a href="http://cscgrid.cas.cn/yhfw/zhsq1/" class="linkstyle" target="_blank">�˺�����>></a> <a href="http://cscgrid.cas.cn/yhfw/pxjc/" class="linkstyle" style="margin-left:20px;" target="_blank">��ѵ/�̳�>></a>
     <div id="container" style=""></div>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>