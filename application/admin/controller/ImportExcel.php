<?php
namespace app\admin\controller;

use PHPExcel_IOFactory;
use PHPExcel;
use PHPExcel_Cell;
use app\admin\model\User;
use think\Controller;

class ImportExcel extends Controller
{
    public static function importExcel($path)
    {
        //载入excel文件
        $objPHPExcel = PHPExcel_IOFactory::load($path);

        $dataArr = array();

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow();
            $highestColumn      = $worksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            //行、列取值赋值
            for ($row = 1; $row <= $highestRow; ++ $row) {
                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    $dataArr[$row][$col] = $val;
                }
            }
        }

        //写入数据库
        unset($dataArr[1]);
        $user = new User;
        foreach($dataArr as $val){
            $list[] = [
                'code'       => $val[0],
                'uname'     => $val[1],
                'sex'       => $val[2],
                'age'       => $val[3],
                'role'      => $val[4],
                'class'     => $val[5],
            ];
        }
        $user->saveAll($list , false);
    }
}