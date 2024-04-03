<?php

/**
 * Description of FrobizAdmin
 *
 * @author hoksi
 */
class ForbizExcel
{
    protected $sheet = 'Worksheet';
    protected $title = false;
    protected $data = false;
    protected $mergeCells = false;
    protected $mergeCellsData = false;
    protected $wrapTextCells = [];
    protected $memory_limit = '1024M';
    protected $maxRow = 65000;

    public function __construct()
    {
        // 실행시간 설정
        set_time_limit(0);
    }

    public function getMaxRow()
    {
        return $this->maxRow;
    }

    public function setMemofy($memory_limit)
    {
        $this->memory_limit = $memory_limit;
        return $this;
    }

    public function setSheet($sheet)
    {
        $this->sheet = $sheet;
        return $this;
    }

    public function setTitle($title)
    {
        $title = (is_array($title) ? $title : [$title]);
        $_title = [];
        $excelColumn = 'A';
        $columnIndex = 0;
        foreach ($title as $key => $_title) {
            $title[$key] = [
                'columnIndex' => $columnIndex
                , 'excelColumn' => $excelColumn
                , 'title' => $_title
            ];
            $excelColumn++;
            $columnIndex++;
        }
        $this->title[$this->sheet] = $title;
        return $this;
    }

    public function setMergeCells($mergeCells)
    {
        $this->mergeCells[$this->sheet] = (is_array($mergeCells) ? $mergeCells : [$mergeCells]);
        return $this;
    }

    public function setData($data)
    {
        $this->data[$this->sheet] = [];
        if (empty($this->title[$this->sheet])) {
            $this->data[$this->sheet] = array_merge([array_keys($data[0])], $data);
        } else {
            // wrapTextCells 초기화
            $this->wrapTextCells[$this->sheet] = [];
            // 타이틀 set
            $this->data[$this->sheet][] = array_column($this->title[$this->sheet], 'title');
            // data 를 title 순서대로 처리
            if (is_array($data) && !empty($data)) {
                foreach ($data as $dt) {
                    $row = [];
                    foreach ($this->title[$this->sheet] as $key => $_title) {
                        $row[] = ($this->convertData($key, $dt[$key]) ?? '');
                    }
                    $this->data[$this->sheet][] = $row;
                }
                //cell 머지 하기 위한 데이터 생성
                $this->makeMergeCellsData();
            }
        }
        return $this;
    }

    protected function convertData($column, $data)
    {
        if (is_array($data)) {
            if (!in_array($column, $this->wrapTextCells[$this->sheet])) {
                array_push($this->wrapTextCells[$this->sheet], $column);
            }
            return implode(chr(10), $data);
        } else {
            return $data;
        }
    }

    protected function makeMergeCellsData()
    {
        if ($this->mergeCells !== false && !empty($this->mergeCells[$this->sheet])) {
            //mergeCellsData false 에서 배열로
            $this->mergeCellsData[$this->sheet] = [];
            //$indexInfo - mergeCells을 하기 위한 index 정보 set (columnIndex : $this->data 열 의 index, excelColumn : 엑셀 열)
            $indexInfo = [];
            foreach ($this->mergeCells[$this->sheet] as $mergeColumn) {
                array_push($indexInfo, $this->title[$this->sheet][$mergeColumn]);
            }
            //set $this->mergeCellsData
            $dataCount = count($this->data[$this->sheet]);
            foreach ($this->data[$this->sheet] as $rowIndex => $data) {
                $rowNum = $rowIndex + 1; //$rowIndex = 0 은 excel 행 1
                foreach ($indexInfo as $_key => $info) {
                    $_data = ${'data' . $_key} = (isset(${'data' . ($_key - 1)}) ? ${'data' . ($_key - 1)} . '|' : '') . $data[$info['columnIndex']];
                    $_bdata = ${'bdata' . $_key} ?? null;
                    if ($_data != $_bdata) {
                        $setMergeBool = true;
                        $setEndRowNumBool = false;
                    } else {
                        if ($dataCount == ($rowIndex + 1)) {
                            $setMergeBool = true;
                            $setEndRowNumBool = true;
                        } else {
                            $setMergeBool = false;
                            $setEndRowNumBool = true;
                        }
                    }
                    if ($setEndRowNumBool) {
                        ${'endRowNum' . $_key} = $rowNum;
                    }
                    if ($setMergeBool) {
                        $_startRowNum = ${'startRowNum' . $_key} ?? 1;
                        $_endRowNum = ${'endRowNum' . $_key} ?? 1;
                        if ($_startRowNum != $_endRowNum) {
                            array_push($this->mergeCellsData[$this->sheet], [
                                'excelColumn' => $info['excelColumn']
                                , 'startRowNum' => $_startRowNum
                                , 'endRowNum' => $_endRowNum
                            ]);
                        }
                        ${'startRowNum' . $_key} = $rowNum;
                        ${'endRowNum' . $_key} = $rowNum;
                    }
                    ${'bdata' . $_key} = ${'data' . $_key};
                }
            }
        }
    }

    public function load($file_name)
    {
        if (file_exists($file_name)) {
            $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($file_name);
            return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        } else {
            return false;
        }
    }

    public function save($file_name)
    {
        if (!empty($this->data)) {
            // 최대 메모리 설정
            ini_set('memory_limit', $this->memory_limit);

            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheetIndex = 0;
            foreach ($this->data as $sheet => $data) {
                if ($sheetIndex != 0) {
                    $spreadsheet->createSheet();
                }
                $spreadsheet->setActiveSheetIndex($sheetIndex);
                $spreadsheet->getActiveSheet()->setTitle($sheet);
                $spreadsheet->getActiveSheet()->fromArray($data);

                //줄바꿈 처리
                if (!empty($this->wrapTextCells[$sheet])) {
                    foreach ($this->wrapTextCells[$sheet] as $wrapTextColumn) {
                        $excelColumn = $this->title[$sheet][$wrapTextColumn]['excelColumn'];
                        $spreadsheet->getActiveSheet()->getStyle($excelColumn . "1:" . $excelColumn . "" . $spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
                        //열 넓이 자동 처리
                        $spreadsheet->getActiveSheet()->getColumnDimension($excelColumn)->setAutoSize(true);
                    }
                }

                //열 머지 처리
                if ($this->mergeCellsData !== false && !empty($this->mergeCellsData[$sheet])) {
                    foreach ($this->mergeCellsData[$sheet] as $mergeData) {
                        $spreadsheet->getActiveSheet()->mergeCells($mergeData['excelColumn'] . $mergeData['startRowNum'] . ':' . $mergeData['excelColumn'] . $mergeData['endRowNum']);
                    }
                }

//                $spreadsheet->getActiveSheet()->calculateColumnWidths();

                $sheetIndex++;
            }
            $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($file_name);

            return realpath($file_name);
        } else {
            return false;
        }
    }

    public function download($file_name)
    {
        $xls_file = $this->save(@tempnam(sys_get_temp_dir(), 'fobizxlstmp'));

        if ($xls_file) {
            if (($fp = @fopen($xls_file, 'rb')) === FALSE) {
                return false;
            }

            // Generate the server headers
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Expires: 0');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . @filesize($xls_file));
            header('Cache-Control: private, no-transform, no-store, must-revalidate');

            // Clean output buffer
            if (ob_get_level() !== 0 && @ob_end_clean() === FALSE) {
                @ob_clean();
            }

            // Flush 1MB chunks of data
            while (!feof($fp) && ($data = fread($fp, 1048576)) !== FALSE) {
                echo $data;
            }

            fclose($fp);

            // Remove tmp file
            @unlink($xls_file);
            exit;
        } else {
            return false;
        }
    }
}