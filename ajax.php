<?php
	include_once '__autoload.php';

	$examinees = new Examinees();
	$results = new Results();
	$paginator = new Paginator();

	//var_dump($examinees->getCorrelation());


	if(isset($_POST['action'])){

		if($_POST['action']=='getExamineeResult'){
			$id = Cleaner::clean($_POST['id']);
			echo json_encode($results->getExamineeResult($id));
		}

		if($_POST['action']=='updateResult'){
			$examinee_id = Cleaner::clean($_POST['studNo']);
			$test1 = Cleaner::clean($_POST['test1']);
			$test2 = Cleaner::clean($_POST['test2']);
			$test3 = Cleaner::clean($_POST['test3']);
			$test4 = Cleaner::clean($_POST['test4']);
			$test5 = Cleaner::clean($_POST['test5']);
			$test6 = Cleaner::clean($_POST['test6']);
			echo json_encode($results->updateResult($examinee_id, $test1,$test2,$test3,$test4,$test5,$test6));
		}

		if($_POST['action']=='getCorrelation'){
			echo json_encode($examinees->getCorrelation());
		}

		if($_POST['action'] == 'getExaminees'){
			$year = $_POST['year'];
			$data = $examinees->display_examinees($year);
			
			echo json_encode($data);
		}

		if($_POST['action'] == 'getResults'){
			$year = $_POST['year'];
			$data = $examinees->display_results($year);
			
			echo json_encode($data);
		}

		if($_POST['action'] == 'getYears'){
			$data = $examinees->getYears();
			echo json_encode($data);
		}

		if($_POST['action'] == 'examGetTotalPage'){
			$year = $_POST['year'];
			$page = $paginator->countExamPages($year);
			echo $page;
		}


		if($_POST['action'] == 'searchExaminees'){
			$examineeNo = $_POST['examNum'];
			$year = $_POST['year'];
			$data = $examinees->searchExaminees($examineeNo, $year);

			echo json_encode($data);
		}

		if($_POST['action'] == 'searchExamineesResult'){
			$examineeNo = $_POST['resultNum'];
			$year = $_POST['year'];
			$data = $examinees->searchExamineesResult($examineeNo, $year);

			echo json_encode($data);
		}

		if($_POST['action'] == 'getExamPerPage'){
			$page = $_POST['page'];
			$year = $_POST['year'];
			$data = [];
			$data[] = $paginator->examineePagesData($page, $year);
			echo json_encode($data);
		}

		if($_POST['action'] == 'getResultPerPage'){
			$page = $_POST['page'];
			$year = $_POST['year'];
			$data = [];
			$data[] = $paginator->resultPagesData($page, $year);
			echo json_encode($data);
		}

		if($_POST['action'] == 'getPerYearResult'){
			$data = $results->getPerYearPass();
			
			echo json_encode($data);
		}

		if($_POST['action'] == 'getPerYearPercentage'){
			$data = $results->getPerYearPercentage();
			
			echo json_encode($data);
		}

		if($_POST['action'] == 'getPerBatchResult'){
			$data = $results->getPerBatchResult();

			echo json_encode($data);
		}

		if($_POST['action'] == 'getTotalExamineePerYear'){
			$year = $_POST['year'];
			$data = $examinees->getTotalExamineePerYear($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalPassed'){
			$year = $_POST['year'];
			$data = $examinees->getTotalPassed($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalFailed'){
			$year = $_POST['year'];
			$data = $examinees->getTotalFailed($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalExamineePerYearFB'){
			$year = $_POST['year'];
			$data = $examinees->getTotalExamineePerYearFB($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalExamineePerYearSB'){
			$year = $_POST['year'];
			$data = $examinees->getTotalExamineePerYearSB($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalPassedFB'){
			$year = $_POST['year'];
			$data = $examinees->getTotalPassedFB($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalPassedSB'){
			$year = $_POST['year'];
			$data = $examinees->getTotalPassedSB($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalFailedFB'){
			$year = $_POST['year'];
			$data = $examinees->getTotalFailedFB($year);

			echo $data;
		}

		if($_POST['action'] == 'getTotalFailedSB'){
			$year = $_POST['year'];
			$data = $examinees->getTotalFailedSB($year);

			echo $data;
		}

		if($_POST['action'] == 'getNPR'){
			$data = $results->getNPR();

			echo json_encode($data);
		}



	}

?>