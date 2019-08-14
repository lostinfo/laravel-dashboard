<?php


namespace App\Support;


use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;

trait ExportHelper
{
    public function export(Request $request)
    {
        if (!$this instanceof ExportHelperInterface) {
            throw new RuntimeException('数据导出方法未完成');
        }

        $writer = WriterFactory::createFromType(Type::XLSX);
        $writer->openToBrowser(time());
        $writer->addRow(WriterEntityFactory::createRowFromArray($this->getExportHeaders()));

        foreach ($this->getExportData($request) as $row) {
            $writer->addRow(WriterEntityFactory::createRowFromArray($row));
        }
        $writer->close();
    }
}