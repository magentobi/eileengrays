<?php

/**
 *
 * @desc       ExcelController.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class ExcelController extends CController
{

    public function actionTest()
    {   $sku = Yii::app()->getRequest()->getQuery('sku');
        $country = Yii::app()->getRequest()->getQuery('country','Australia');
        $province = Yii::app()->getRequest()->getQuery('province','');


        $service = new Orders();
//        $service =  Yii::app()->amazonImportOrders;
        echo "<pre>";
        $sku = $service->exchangeSku($sku,$country,$province,function($sku){
            var_dump($sku) ;
        });

        var_dump($sku);
    }
    public function actionIndex()
    {
        ini_set('display_errors','On');
        error_reporting(11);


        $file = "E:/�ֵ�ѹ��С��Ʒ.xls";
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.phpexcel.Classes.PHPExcel', true);
        $phpExcel = PHPExcel_IOFactory::load($file);
        $content = <<<PHP
<?php
return array(\r\n
PHP;
        $skuArray = array();
        for($i = 0 ;$i<3;$i++)
        {
            $sheet = $phpExcel->getSheet($i);
            $highestRow = $sheet->getHighestRow(); // ȡ��������
            $highestColumm = $sheet->getHighestColumn(); // ȡ��������
//            $highestColumm= PHPExcel_Cell::columnIndexFromString($highestColumm); //��ĸ��ת��Ϊ������ ��:AA��Ϊ27


            /** ѭ����ȡÿ����Ԫ������� */
            for ($row = 2; $row <= $highestRow; $row++){//�������Ե�1�п�ʼ
//            $sku = $sheet->getCell("A".$row);
//            $replaceSku = $sheet->getCell("C".$row);
                $sku = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                $skuArray[$sku] =1;
            }
        }

        foreach($skuArray as $sku => $o)
        {
            $content .= "'".$sku."' => '1',\r\n";
        }
        $content .="\r\n);";
        echo $content;
        file_put_contents("z.php",$content);

    }

    protected function x()
    {
        $file = "E:/20151027��վSKU.xlsx";
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.phpexcel.Classes.PHPExcel', true);
        $phpExcel = PHPExcel_IOFactory::load($file);
        $sheet = $phpExcel->getActiveSheet();
        $highestRow = $sheet->getHighestRow(); // ȡ��������
        $highestColumm = $sheet->getHighestColumn(); // ȡ��������
        $highestColumm= PHPExcel_Cell::columnIndexFromString($highestColumm); //��ĸ��ת��Ϊ������ ��:AA��Ϊ27

        $content = <<<PHP
<?php
return array(\r\n
PHP;
        /** ѭ����ȡÿ����Ԫ������� */
        for ($row = 2; $row <= $highestRow; $row++){//�������Ե�1�п�ʼ
//            $sku = $sheet->getCell("A".$row);
//            $replaceSku = $sheet->getCell("C".$row);
            $sku = $sheet->getCellByColumnAndRow(0, $row)->getValue();
            $replaceSku = $sheet->getCellByColumnAndRow(2, $row)->getValue();

            $content .= "'".$sku."' => '".$replaceSku."',\r\n";
//            for ($column = 0; $column < $highestColumm; $column++) {//�������Ե�0�п�ʼ
//                $columnName = PHPExcel_Cell::stringFromColumnIndex($column);
////                 $columnIndex =PHPExcel_Cell::columnIndexFromString($column);
//                echo $columnName."--".$row.":".$sheet->getCellByColumnAndRow($column, $row)->getValue()."<br />";
//            }

        }
        $content .="\r\n);";
        echo $content;
        file_put_contents("x.php",$content);
    }

    public function y()
    {
        $file = "E:/�ֲ�ͷ���Ĳ�Ʒ.xlsx";
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.phpexcel.Classes.PHPExcel', true);
        $phpExcel = PHPExcel_IOFactory::load($file);
        $sheet = $phpExcel->getActiveSheet();
        $highestRow = $sheet->getHighestRow(); // ȡ��������
        $highestColumm = $sheet->getHighestColumn(); // ȡ��������
        $highestColumm= PHPExcel_Cell::columnIndexFromString($highestColumm); //��ĸ��ת��Ϊ������ ��:AA��Ϊ27

        $content = <<<PHP
<?php
return array(\r\n
PHP;
        /** ѭ����ȡÿ����Ԫ������� */
        $skuArray = array();
        for ($row = 2; $row <= $highestRow; $row++){//�������Ե�1�п�ʼ
//            $sku = $sheet->getCell("A".$row);
//            $replaceSku = $sheet->getCell("C".$row);
            $sku = $sheet->getCellByColumnAndRow(1, $row)->getValue();
            $skuArray[$sku] =1;
        }
        foreach($skuArray as $sku => $o)
        {
            $content .= "'".$sku."' => '1',\r\n";
        }
        $content .="\r\n);";
        echo $content;
        file_put_contents("y.php",$content);
    }

}