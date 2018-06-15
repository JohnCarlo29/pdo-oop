<?php
	include_once '__autoload.php';
	require 'vendor/autoload.php';


	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

	$spreadsheet = new Spreadsheet();  /*----Spreadsheet object-----*/
	$Excel_writer = new Xlsx($spreadsheet);  /*----- Excel (Xls) Object*/

	$spreadsheet->setActiveSheetIndex(0);
	$activeSheet = $spreadsheet->getActiveSheet();
	$activeSheet->getProtection()->setSheet(true);
	$activeSheet->getProtection()->setPassword("password");

	$i = 6;//starting row of year result
	$j = 4;//starting row of year percent
	$k = 15;


	$style = array(
        'alignment' => array(
            'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ),
        'borders' => array(
       		'top' => array(
            	'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
       		),
       		'left' => array(
            	'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
       		),
       		'right' => array(
            	'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
       		),
       		'bottom' => array(
            	'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
       		)
    	)
    );

	$activeSheet->mergeCells('B2:N2');
	$activeSheet->mergeCells('C3:N3');
	$activeSheet->mergeCells('C4:D4');
	$activeSheet->mergeCells('E4:F4');
	$activeSheet->mergeCells('G4:H4');
	$activeSheet->mergeCells('I4:J4');
	$activeSheet->mergeCells('K4:L4');
	$activeSheet->mergeCells('M4:N4');
	$activeSheet->mergeCells('P2:R2');
	$activeSheet->mergeCells('D12:K12');
	$activeSheet->mergeCells('D13:D14');
	$activeSheet->mergeCells('E13:F13');
	$activeSheet->mergeCells('G13:G14');
	$activeSheet->mergeCells('H13:I13');
	$activeSheet->mergeCells('J13:J14');
	$activeSheet->mergeCells('K13:K14');

	$activeSheet->setCellValue('B2','Per Year Result')->getStyle('B2')->getFont()->setBold(true);
	$activeSheet->setCellValue('B3','Year')->getStyle('B3')->getFont()->setBold(true);
	$activeSheet->setCellValue('C3','Subjects')->getStyle('C3')->getFont()->setBold(true);
	$activeSheet->setCellValue('C4','CJP')->getStyle('C4')->getFont()->setBold(true);
	$activeSheet->setCellValue('E4','LEA')->getStyle('E4')->getFont()->setBold(true);
	$activeSheet->setCellValue('G4','CDIP')->getStyle('G4')->getFont()->setBold(true);
	$activeSheet->setCellValue('I4','C')->getStyle('I4')->getFont()->setBold(true);
	$activeSheet->setCellValue('K4','CA')->getStyle('K4')->getFont()->setBold(true);
	$activeSheet->setCellValue('M4','CSEHR')->getStyle('M4')->getFont()->setBold(true);
	$activeSheet->setCellValue('C5','Passed')->getStyle('C5')->getFont()->setBold(true);
	$activeSheet->setCellValue('D5','Failed')->getStyle('D5')->getFont()->setBold(true);
	$activeSheet->setCellValue('E5','Passed')->getStyle('E5')->getFont()->setBold(true);
	$activeSheet->setCellValue('F5','Failed')->getStyle('F5')->getFont()->setBold(true);
	$activeSheet->setCellValue('G5','Passed')->getStyle('G5')->getFont()->setBold(true);
	$activeSheet->setCellValue('H5','Failed')->getStyle('H5')->getFont()->setBold(true);
	$activeSheet->setCellValue('I5','Passed')->getStyle('I5')->getFont()->setBold(true);
	$activeSheet->setCellValue('J5','Failed')->getStyle('J5')->getFont()->setBold(true);
	$activeSheet->setCellValue('K5','Passed')->getStyle('K5')->getFont()->setBold(true);
	$activeSheet->setCellValue('L5','Failed')->getStyle('L5')->getFont()->setBold(true);
	$activeSheet->setCellValue('M5','Passed')->getStyle('M5')->getFont()->setBold(true);
	$activeSheet->setCellValue('N5','Failed')->getStyle('N5')->getFont()->setBold(true);
	$activeSheet->setCellValue('P2','Year Percentage')->getStyle('Q2')->getFont()->setBold(true);
	$activeSheet->setCellValue('P3','Year')->getStyle('Q3')->getFont()->setBold(true);
	$activeSheet->setCellValue('Q3','Passed')->getStyle('R3')->getFont()->setBold(true);
	$activeSheet->setCellValue('R3','Failed')->getStyle('S3')->getFont()->setBold(true);
	$activeSheet->setCellValue('D12','Per Year Batch Results')->getStyle('D12')->getFont()->setBold(true);
	$activeSheet->setCellValue('D13','Year')->getStyle('D13')->getFont()->setBold(true);
	$activeSheet->setCellValue('E13','1st Batch')->getStyle('E13')->getFont()->setBold(true);
	$activeSheet->setCellValue('G13','No. of Takers')->getStyle('G13')->getFont()->setBold(true);
	$activeSheet->setCellValue('H13','2nd Batch')->getStyle('H13')->getFont()->setBold(true);
	$activeSheet->setCellValue('J13','No. of Takers')->getStyle('J13')->getFont()->setBold(true);
	$activeSheet->setCellValue('K13','Total Takers')->getStyle('K13')->getFont()->setBold(true);
	$activeSheet->setCellValue('E14','Passed')->getStyle('E14')->getFont()->setBold(true);
	$activeSheet->setCellValue('F14','Failed')->getStyle('F14')->getFont()->setBold(true);
	$activeSheet->setCellValue('H14','Passed')->getStyle('H14')->getFont()->setBold(true);
	$activeSheet->setCellValue('I14','Failed')->getStyle('I14')->getFont()->setBold(true);


	$results = new Results();
	$yearResults = $results->getPerYearPass();
	$yearPercent = $results->getPerYearPercentage();
	$batchResult = $results->getPerBatchResult();
	$batchTotal = $results->getPerYearBatchTotal();

	foreach($yearResults as $result){
		$activeSheet->setCellValue('B'.$i,$result[0]->year);
		$activeSheet->setCellValue('C'.$i,$result[0]->cjp.'%');
		$activeSheet->setCellValue('D'.$i,100 - $result[0]->cjp.'%');
		$activeSheet->setCellValue('E'.$i,$result[0]->lea.'%');
		$activeSheet->setCellValue('F'.$i,100 - $result[0]->lea.'%');
		$activeSheet->setCellValue('G'.$i,$result[0]->cdip.'%');
		$activeSheet->setCellValue('H'.$i,100 - $result[0]->cdip.'%');
		$activeSheet->setCellValue('I'.$i,$result[0]->c.'%');
		$activeSheet->setCellValue('J'.$i,100 - $result[0]->c.'%');
		$activeSheet->setCellValue('K'.$i,$result[0]->ca.'%');
		$activeSheet->setCellValue('L'.$i,100 - $result[0]->ca.'%');
		$activeSheet->setCellValue('M'.$i,$result[0]->csehr.'%');
		$activeSheet->setCellValue('N'.$i,100 - $result[0]->csehr.'%');
		$i++;
	}

	foreach ($yearPercent as $percent) {
		$activeSheet->setCellValue('P'.$j,$percent[0]->year);
		$activeSheet->setCellValue('Q'.$j,$percent[0]->percent.'%');
		$activeSheet->setCellValue('R'.$j,100 - $percent[0]->percent.'%');
		$j++;
	}

	$l = count($batchTotal['year']);

	for($m = 0; $m < $l; $m++){
		$activeSheet->setCellValue('D'.$k,$batchTotal['year'][$m]);
		$activeSheet->setCellValue('E'.$k,$batchResult['first'][$m].'%');
		$activeSheet->setCellValue('F'.$k,100-$batchResult['first'][$m].'%');
		$activeSheet->setCellValue('G'.$k,$batchTotal['fbtotal'][$m]);
		$activeSheet->setCellValue('H'.$k,$batchResult['second'][$m].'%');
		$activeSheet->setCellValue('I'.$k,100-$batchResult['second'][$m].'%');
		$activeSheet->setCellValue('J'.$k,$batchTotal['sbtotal'][$m]);
		$activeSheet->setCellValue('K'.$k,$batchTotal['sbtotal'][$m]+$batchTotal['fbtotal'][$m]);
		$k++;
	}


	$activeSheet->getStyle("B2:N".$i)->applyFromArray($style);
	$activeSheet->getStyle("B3:B3")->applyFromArray($style);
	$activeSheet->getStyle("B4:B4")->applyFromArray($style);
	$activeSheet->getStyle("C3:N3")->applyFromArray($style);
	$activeSheet->getStyle('C4:D4')->applyFromArray($style);
	$activeSheet->getStyle('E4:F4')->applyFromArray($style);
	$activeSheet->getStyle('G4:H4')->applyFromArray($style);
	$activeSheet->getStyle('I4:J4')->applyFromArray($style);
	$activeSheet->getStyle('K4:L4')->applyFromArray($style);
	$activeSheet->getStyle('M4:N4')->applyFromArray($style);
	$activeSheet->getStyle("P2:R".$j)->applyFromArray($style);
	$activeSheet->getStyle("P3:P3")->applyFromArray($style);
	$activeSheet->getStyle("Q3:Q3")->applyFromArray($style);
	$activeSheet->getStyle("R3:R3")->applyFromArray($style);
	$activeSheet->getStyle("D12:K".$k)->applyFromArray($style);
	$activeSheet->getStyle("D13:D14")->applyFromArray($style);
	$activeSheet->getStyle("E13:F13")->applyFromArray($style);
	$activeSheet->getStyle("E14:E14")->applyFromArray($style);
	$activeSheet->getStyle("F14:F14")->applyFromArray($style);
	$activeSheet->getStyle("G13:G14")->applyFromArray($style);
	$activeSheet->getStyle("J13:J14")->applyFromArray($style);
	$activeSheet->getStyle("K13:K14")->applyFromArray($style);
	$activeSheet->getStyle("H13:I13")->applyFromArray($style);
	$activeSheet->getStyle("H14:H14")->applyFromArray($style);
	$activeSheet->getStyle("I14:I14")->applyFromArray($style);

	$activeSheet->getColumnDimension('G')->setAutoSize(true);
	$activeSheet->getColumnDimension('J')->setAutoSize(true);
	$activeSheet->getColumnDimension('K')->setAutoSize(true);


	// We'll be outputting an excel file
	header('Content-type: application/vnd.ms-excel');

	// It will be called file.xls
	header('Content-Disposition: attachment; filename="report.xlsx"');

	// Write file to the browser
	$Excel_writer->save('php://output');
	

?>
