<?php

//echo "Hello World.\n";

$filePath = "input/orders-2020-06-11-09-44-44.csv";
        
$bp = new Parser;
//$bp->syncBankData($filePath);

$array = $bp->csv_to_array($filePath);
//var_dump($array);
 
foreach($array as $item) { 
    echo $item['Customer Username']."\n";
    echo $item['Item #']."\n";
}

class Parser {
    public function __construct() {
        setlocale(LC_ALL, 'zh_TW'); 
//        $this->reportTable           = 'bank_report';
//        $this->reportLogTable        = 'bank_report_log';
//        $this->kvaccountTable        = 'kgi_virtual_account_table';
//        $this->kvaccountRecordTable  = 'kgi_virtual_account_record_table';
//        $this->kcompanyTable         = 'kgi_company_identification_table';
//        $this->serpOrderTable        = 'serp_order';
//        $this->serpCitationTable     = 'serp_citation';
//        $this->serpCitationLogTable  = 'serp_citation_log';
        $this->now                   = date('Y-m-d H:i:s');
        $this->inputCsvColumns       = array('Order Number','Customer User ID','Customer Username','First Name Shipping','Last Name Shipping','Phone Billing','State Code Shipping','City Shipping','Postcode Shipping','Address 1&2 Shipping','SKU','Quantity','Order Status','Order Date','Customer Note','First Name Billing','Last Name Billing','Company Billing','Address 1&2 Billing','City Billing','State Code Billing','Postcode Billing','Country Code Billing','Email Billing','Country Code Shipping','Payment Method Title','Cart Discount Amount','Order Subtotal Amount','Shipping Method Title','Order Shipping Amount','Order Refund Amount','Order Total Amount','Order Total Tax Amount','Item #','Item Name','Item Cost','Coupon Code','Discount Amount','Discount Amount Tax','Points','Invoice','Tax ID');
        $this->reportTableColumns    = array('log_id', 'date', 'bankDate', 'info', 'outAmount', 'inAmount', 'remainder', 'note', 'kar_id', 'createAt');
//        $this->reportLogTableColumns = array('rDate', 'rName', 'rType', 'createAt');
        $this->response              = [];
    }
    
     public function linkdb() {
//        require_once('../Connections/link.php');
//        require_once('../tools.php');
    }
    
/* #API: /apis/bank_parser.php?action=importData 
       匯入企業網路銀行交易資料 */
     public function syncBankData($bankFilePath) {
//        if (count($files) < 1) { echo json_encode(['error'=>'檔案不得為空']); exit; }
//        if (!$input['date']) { echo json_encode(['error'=>'報表日期不得為空']); exit; }

//        $this->replaceBankDataIfExistOfDate($input['date']);

//        $bankFileDate       = $input['date'];
//        $bankFile           = $files['bankinfo'];
//        $bankFileName       = $bankFile['name'];
//        $bankFilePath       = $bankFile['tmp_name'];
//        $bankFileType       = $bankFile['type'];
        $queryAllData       = array();
        $reportTableColumns = $this->reportTableColumns;

        /* 入金Log資料表 Insert */
//        $log_id = $this->newBankReportLog($bankFileDate, $bankFileName, $bankFileType, $this->now);
        /*====================*/

//        if ($log_id) {
            $bankFileContentArray = file($bankFilePath, FILE_IGNORE_NEW_LINES);
            foreach($bankFileContentArray as $transInfo) {
                echo $transInfo."\n";
                echo mb_strcut($transInfo,  34, 8)."\n";
//                $date      = mb_strcut($transInfo,  24, 8);
//                $bankDate  = mb_strcut($transInfo,  32, 8);
//                $info      = trim(mb_strcut($transInfo,  40, 18));
//                $outAmount = (int)mb_strcut($transInfo,  58, 13);
//                $inAmount  = (int)mb_strcut($transInfo,  71, 13);
//                $remainder = (int)mb_strcut($transInfo,  84, 13);
//                $note      = trim(mb_strcut($transInfo,  97, 40));
//                $kar_id    = '';

//                    $queryData = [$reportTableColumns[0]=>$log_id, $reportTableColumns[1]=>$date, $reportTableColumns[2]=>$bankDate,
//                                $reportTableColumns[3]=>$info, $reportTableColumns[4]=>$outAmount, $reportTableColumns[5]=>$inAmount,
//                                $reportTableColumns[6]=>$remainder, $reportTableColumns[7]=>$note, $reportTableColumns[8]=>$kar_id, 
//                                $reportTableColumns[9]=>$this->now];
//                    /*針對 Big5 處理*/
//                    foreach($queryData as $key => $col) {
//                        $queryData[$key] = iconv('big5', 'UTF-8', $col);
//                    }
//
//                    array_push($queryAllData, $queryData);
//                }
            }

    
//            /* 入金資料表 Insert */
//            $queryColumns   = implode("," , $reportTableColumns);
//            $queryValues = '';
//            $count = 0;
//            foreach($queryAllData as $data)
//            {
//                $count++;
//                $values = implode("','",$data);
//                $values = "('".$values."')";
//                $values .= $count == count($queryAllData) ?  "" : ",";
//                $queryValues .= $values;
//            }

            // var_dump("INSERT INTO $this->reportTable ($queryColumns) VALUES $queryValues");
//            $result = mysql_query("INSERT INTO $this->reportTable ($queryColumns) VALUES $queryValues");
//            $this->response['error'] = $result ? '0' : mysql_error();
            /*====================*/
//        } else {
//            $this->response['error'] = mysql_error();
//        }

        unlink($bankFilePath);
        echo json_encode($this->response);
    }
    
    public function csv_to_array($filename) {
        $csv = array_map('str_getcsv', file($filename));

        array_walk($csv, function(&$row) use ($csv) {
            /*針對 Big5 處理*/
            foreach($row as $key => $col) { 
                $rowFormat[$key] = iconv('big5', 'UTF-8', $col);
            }
            
            $row = array_combine($csv[0], $rowFormat);
        });

        array_shift($csv); // 移掉第一行的標題陣列

        return $csv;
    }
}