<?php

/*!
 *  Excel to SQL
 *  Copy Right (c)2016 
 *  author	: Abu Dzunnuraini
 *  email	: almprokdr@gmail.com
*/

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Excel to SQL';
$this->params['breadcrumbs'][] = $this->title;

$upldUrl=Url::to(['excel-sql']);
$this->registerJs("var upldUrl='$upldUrl', zname='base', libs={};
var app=(function (){
	'use strict';
	var pub={};	
	pub.clearOut = function(){ $('#out').val('') }
	pub.saveFile = function(){
		var container = document.querySelector('textarea');	//console.log(container);
		var anchor = document.querySelector(\"a[id='btn-save']\");
		anchor.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(container.value);
		anchor.download = zname+'.sql';
	}
	return pub;
}());
$(function(){
	$.extend(libs, app);
	$('#out').css('height',($(window).height()-256)+'px');
	$('#fileupload').fileupload({
		url: upldUrl, dataType: 'json', done: function (e, data) {
			if(data.result.success){ 
				$('#out').val(data.result.out); zname=data.result.name; 
			}
		}
	})
});", View::POS_END);

$css=[
	'//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
	'//almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css',
];
$js=[
	'https://blueimp.github.io/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
	'https://blueimp.github.io/jQuery-File-Upload/js/jquery.iframe-transport.js',
	'https://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload.js'
];
$depends=['depends' => [\yii\web\JqueryAsset::className()]];
foreach($css as $z) $this->registerCssFile($z);
foreach($js as $z) $this->registerJsFile($z, $depends);
?>
<?= Html::Button('<i class="fa fa-upload text-blue"></i> Upload<input id="fileupload" type="file" name="files[]" accept="application/vnd.ms-excel" />', ['class' => 'btn btn-default btn-file', 'title'=>'Upload file excel (.xls)'])."\n" ?>
<?= Html::a('<i class="fa fa-save text-blue"></i> Save', 'javascript:void(0)', ['id' => 'btn-save', 'class' => 'btn btn-default', 'title' => 'Save File (.sql)', 'onclick' => 'libs.saveFile()'])."\n" ?>
<?= Html::Button('<i class="fa fa-remove text-red"></i> Clear', ['id' => 'btn-save', 'class' => 'btn btn-default', 'title' => 'Clear Output Area', 'onclick' => 'libs.clearOut()'])."\n" ?>
<div style="margin-top:10px">
<?= Html::textarea('','',['id'=>'out', 'style'=>'font-family: monospace; width:100%'])."\n" ?>
</div>
