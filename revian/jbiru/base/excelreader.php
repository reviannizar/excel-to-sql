<?php
/*!
 *  Php Excel Reader
 *  Copy Right (c)2015 
 *  author	: Abu Dzunnuraini
 *  email	: almprokdr@gmail.com
*/

namespace jbiru\base;

class excelreader{

	public static function start($path){
		require_once(dirname(__FILE__) . '/Classes/ExcelReader.php');
		return new \Spreadsheet_Excel_Reader($path);
	}

}
