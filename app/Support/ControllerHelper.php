<?php


namespace App\Support;


use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Illuminate\Http\Request;

trait ControllerHelper
{
    public function export(Request $request)
    {
        if (!method_exists($this, 'getQuery') || !property_exists($this, 'exportHeaders')) {
            return new \Exception('export method not ready');
        }

        $writer = WriterFactory::createFromType(Type::XLSX);
        $writer->openToBrowser(time());
        $writer->addRow(WriterEntityFactory::createRowFromArray(array_keys($this->exportHeaders)));

        $list = $this->getQuery($request)->get()->toArray();

        foreach ($list as $index => $row) {
            $writerRow = [];
            foreach ($this->exportHeaders as $label => $key) {
                $item = '';
                if ($key instanceof \Closure) {
                    $item = $key($row);
                } elseif (array_key_exists($key, $row)) {
                    $item = $row[$key];
                }
                array_push($writerRow, $item);
            }
            $writer->addRow(WriterEntityFactory::createRowFromArray($writerRow));
        }
        $writer->close();
    }

}