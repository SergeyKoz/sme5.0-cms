<?php
class CsvExport
{
    var $stream = null;

    function CsvExport() {
        $this->init();
    }

    function out($filename = '') {
        if ($filename == '') {
            $filename = 'export-' . date("Y-m-d-H-i") . '.csv';
        }
        ob_end_clean();
        header("Content-disposition: attachment; filename={$filename}");
        echo $this->toString($csv);
        die;
    }

    function init() {
        $this->stream = array(array());
    }


    function add($item) {
        $this->stream[count($this->stream)-1][] = $item;
    }

    function newRow() {
        $this->stream[count($this->stream)] = array();
    }

    function toString() {
        $data = '';
        foreach ($this->stream as $csvRow) {
            $row = '';
            foreach ($csvRow as $csvItem) {
                if ($row != '') {
                    $row .= ',';
                }
                $row .= '"' . str_replace('"', '""', $csvItem) . '"';
            }
            $row = preg_replace('/(\n\r|\r\n|\n|\r)/ms', ' ', $row);
            $data .= $row . "\n";
        }
        return $data;
    }

}
