<?php

/*!
 *  Excel to SQL
 *  Copy Right (c)2016 
 *  author	: Abu Dzunnuraini
 *  email	: almprokdr@gmail.com
*/

namespace jbiru\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Json;

use jbiru\base\excelreader;

class ToolsController extends Controller{

	public function behaviors(){ 
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [['allow'=>true,'roles'=>['@'],],],
			],
		];
	}
	
	public function actionExcelToSql(){
		return $this->render('excelsql');
	}
	
	public function actionExcelSql(){
		if(!isset($_FILES['files'])) return; else $r=$_FILES['files']; 
		if((isset($r['name'][0]))&&(isset($r['tmp_name'][0]))){ 
			$path=$r['tmp_name'][0]; $name=$r['name'][0];
			$out=$this->ExcelSql($path);
			if($out) echo Json::encode(['success'=>true,'out'=>$out,'name'=>basename($name,".xls")]); else echo '{"msg":"Error"}';
		}
	}
	
	private function setIndex($v){
		$k=['{1}','{2}','{3}']; $v[0]=$v[1].'_'.$v[2];
		return str_replace($k,$v,"\nCREATE INDEX {1} ON {2} USING BTREE ({3});\n");
	}
	
	private function setdatatmpl($a, $b){
		$i=1; $k=[]; $v=[];
		foreach($b as $r){
			if($i>1) $v[]=$r;
			$k[]="{".$i."}";
			$i++;
		}
		return str_replace($k,$v,$a);
	}
	
	private function ExcelSql($path){
		$data=excelreader::start($path); 
		$o=$data->sheets[0]; 
		$l=$o['numRows']+1; 
		$k=1024; $sql=''; $tmpl='';
		for($j=1; $j<$l; $j++){
			$d=[]; $i=1;
			for($i=1; $i<$k; $i++){
				$u=(isset($o['cells'][$j][$i]))?$u=$o['cells'][$j][$i]:''; 
				if($u!=''){ 
					$u=$u=="'"?"''":$u; $d[]=$u; 
				}else break;
			}
			if(!empty($d)){ 
				switch(strtolower($d[0])){
					case 'index': if(sizeof($d)>2) $sql.= $this->setIndex($d);
						break;
					case 'data': $tmpl=isset($d[1])?$d[1]:false; $sql.= "\n";
						break;
					case 'value':
						if($tmpl) $sql.= $this->setdatatmpl($tmpl, $d)."\n";
						break;
					case 'end':
						$sql.= "\n);\n\n"; $tmpl=false;
						break;
					case 'database': 
						if(isset($d[1])){ 
							$e=0;
							$z=strtolower($d[1]); $inf=str_replace('_',' ',$d[1]);
							$sql.= "-- -------------------------------------\n";
							$sql.= "-- database $inf\n";
							$sql.= "-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
							$sql.= "-- DROP DATABASE $z;\n";
							$sql.= "-- CREATE DATABASE $z;\n";
							$sql.= "-- USE $z;\n\n\n"; 
						} 
						break;
					case 'table': 
						if(isset($d[1])){ 
							$e=0;
							$tbl=strtolower($d[1]); $inf=str_replace('_',' ',$d[1]);
							$sql.= "-- -------------------------------------\n";
							$sql.= "-- $inf\n";
							$sql.= "-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
							$sql.= "-- DROP TABLE $tbl;\n";
							$sql.= "CREATE TABLE $tbl (\n"; 
						} 
						break;
					case 'unique': 
					case 'primary key': 
						$z=$d[1];
						$sql.= ",\n\t".strtoupper($d[0])."($z)";
						break;
					default:
						if($e>0) $sql.=",\n";
						$sql.="\t"; $i=0;
						foreach($d as $a){
							$sql.="$a "; $i++;
							if((strtolower($a)=='default')&&(!isset($d[$i]))) $sql.="0 ";
						}
						$e++;
				}
			}
		}
		return $sql."\n\n\n";
	}

}
