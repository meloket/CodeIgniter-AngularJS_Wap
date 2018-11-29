<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sylot extends WebBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public final function js_ssc(){
        $lastNo=$this->getGameLastNo(73);
        $opencode = isset($zddata) ? $zddata : $this->js_ssc_randKeys();

        header('Content-type: application/xml');
        echo'<?xml version="1.0" encoding="utf-8"?>';

        echo '<xml><row expect="'.$lastNo['actionNo'].'" opencode="'.$opencode.'" opentime="'.$lastNo['actionTime'].'"/></xml>';
    }
    public final function js_pk10(){
    	$lastNo=$this->getGameLastNo(72);
        $opencode = isset($zddata) ? $zddata : $this->js_pk10_randKeys(10);

        header('Content-type: application/xml');
        echo'<?xml version="1.0" encoding="utf-8"?>';
        echo '<xml><row expect="'.$lastNo['actionNo'].'" opencode="'.$opencode.'" opentime="'.$lastNo['actionTime'].'"/></xml>';
    }
    public final function js_lhc(){
        $lastNo=$this->getGameLastNo(74);
        $nowdate=date("Ymd");
        $lasNo=$lastNo['actionNo'];
        //echo $lasNo;
        //$lasNo=strlen($lasNo)==3?$lasNo:"0".$lasNo;
        header('Content-type: application/xml');
        echo'<?xml version="1.0" encoding="utf-8"?>';
        echo '<xml><row expect="'.$lasNo.'" opencode="'.$this->js_lhc_randKeys(7).'" opentime="'.$lastNo['actionTime'].'"/></xml>';
    }
    public final function js_k3(){
        $lastNo=$this->getGameLastNo(75);
        $opencode =isset($zddata)?$zddata:$this->js_k3_randKeys();

        header('Content-type: application/xml');
        echo'<?xml version="1.0" encoding="utf-8"?>';

        echo '<xml><row expect="'.$lastNo['actionNo'].'" opencode="'.$opencode.'" opentime="'.$lastNo['actionTime'].'"/></xml>';
    }
    public final function lhc(){
        $lastNo=$this->getGameLastNo(70);
        //$nowdate=date("Ymd");
        $lasNo=$lastNo['actionNo'];
        $code=lhc_randKeys();
        $issue='';
        $opentime='';
        //echo $lasNo;
        //$lasNo=strlen($lasNo)==3?$lasNo:"0".$lasNo;

        header('Content-type: application/xml');
        echo'<?xml version="1.0" encoding="utf-8"?>';
        echo '<xml><row expect="'.$GLOBALS['issue'].'" opencode="'.randKeys().'" opentime="'. $GLOBALS['opentime'].'"/></xml>';
    }

    /* 生成随机数 */
    function js_ssc_randKeys($len=5){
        $rand='';
        for($x=0;$x<$len;$x++){
            srand((double)microtime()*1000000);
            $rand.=($rand!=''?',':'').mt_rand(0,9);
        }
        return $rand;
    }

    /* 生成随机数 */
    function js_lhc_randKeys($len)
    {
        $array    = array(
            "01",
            "02",
            "03",
            "04",
            "05",
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17",
            "18",
            "19",
            "20",
            "21",
            "22",
            "23",
            "24",
            "25",
            "26",
            "27",
            "28",
            "29",
            "30",
            "31",
            "32",
            "33",
            "34",
            "35",
            "36",
            "37",
            "38",
            "39",
            "40",
            "41",
            "42",
            "43",
            "44",
            "45",
            "46",
            "47",
            "48",
            "49"
        );
        $charsLen = count($array) - 1;
        shuffle($array);
        $output = "";
        for ($i=0; $i<$len; $i++){
            $output .= $array[$i].",";
        }  
        return rtrim($output, ',');
    }

    
    /* 生成随机数 */
    function js_k3_randKeys($len=3){
        $rand='';
        for($x=0;$x<$len;$x++){
            srand((double)microtime()*1000000);
            $rand.=($rand!=''?',':'').mt_rand(1,6);
        }
        return $rand;
    }
    
    function js_pk10_randKeys($len){
        $array=array("1","2","3","4","5","6","7","8","9","10");
        $charsLen = count($array) - 1;
        shuffle($array);
        $output = "";
        //  for ($i=0; $i<$len; $i++){
    
        $a= $array[mt_rand(0, $charsLen)];
        $b= $array[mt_rand(0, $charsLen)];
        while($a==$b)
        {
            $b= $array[mt_rand(0, $charsLen)];
        }
        $c=$array[mt_rand(0, $charsLen)];
        while($c==$a||$c==$b)
        {
            $c= $array[mt_rand(0, $charsLen)];
        }
    
        $d= $array[mt_rand(0, $charsLen)];
        while($d==$a||$d==$b||$d==$c)
        {
            $d= $array[mt_rand(0, $charsLen)];
        }
        $e= $array[mt_rand(0, $charsLen)];
        while($e==$a||$e==$b||$e==$c||$e==$d)
        {
            $e= $array[mt_rand(0, $charsLen)];
        }
        $f= $array[mt_rand(0, $charsLen)];
        while($f==$a||$f==$b||$f==$c||$f==$d||$f==$e)
        {
            $f= $array[mt_rand(0, $charsLen)];
        }
        $g= $array[mt_rand(0, $charsLen)];
        while($g==$a||$g==$b||$g==$c||$g==$d||$g==$e||$g==$f)
        {
            $g= $array[mt_rand(0, $charsLen)];
        }
        $h= $array[mt_rand(0, $charsLen)];
        while($h==$a||$h==$b||$h==$c||$h==$d||$h==$e||$h==$f||$h==$g)
        {
            $h= $array[mt_rand(0, $charsLen)];
        }
        $i= $array[mt_rand(0, $charsLen)];
        while($i==$a||$i==$b||$i==$c||$i==$d||$i==$e||$i==$f||$i==$g||$i==$h)
        {
            $i= $array[mt_rand(0, $charsLen)];
        }
        $j= $array[mt_rand(0, $charsLen)];
        while($j==$a||$j==$b||$j==$c||$j==$d||$j==$e||$j==$f||$j==$g||$j==$h||$j==$i)
        {
            $j= $array[mt_rand(0, $charsLen)];
        }
        //$output .= $array[mt_rand(0, $charsLen)].",";
        //  }
        return $outpuet=$a.','.$b.','.$c.','.$d.','.$e.','.$f.','.$g.','.$h.','.$i.','.$j;
        // return rtrim($output, ',');
    }

    function lhc_randKeys(){
        header("application/json, text/javascript, */*; q=0.01");
        $output = "";
        $url='http://129kai.net/index.php?c=api2&a=getLastData&cp=hk6&_=0.9007102444220094';
        $html = file_get_contents($url);
        $json=json_decode($html,true);
        $GLOBALS['issue']=$json['c_t'];
        $GLOBALS['opentime']=$json['c_d'];
        //echo  $GLOBALS['issue'];
        $arr=$json['c_r'];
        //var_dump($arr) ;
        $output .= $arr[0]['no'].",";
        $output .= $arr[1]['no'].",";
        $output .= $arr[2]['no'].",";
        $output .= $arr[3]['no'].",";
        $output .= $arr[4]['no'].",";
        $output .= $arr[5]['no'].",";
        $output .= $arr[6]['no'].",";
    
        return rtrim($output, ',');
    }
}

?>
