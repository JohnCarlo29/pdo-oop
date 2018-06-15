<?php
    class Paginator extends Database{
        private $gen_aveRow;
        private $pages;
        private $currentPage;
        private $offset;
        private $limit;

        public function __construct(){
            parent::__construct();
            $this->limit = 10;
        
        }


        public function countExamPages($year){
            $this->select('*', 'examinees')->where('year')->build();
            $this->gen_aveRow = $this->execute([$year])->rowCount();
            $this->pages = ceil($this->gen_aveRow/10);
            return $this->pages;
        }

        public function examineePagesData($page, $year){
            $this->offset = ($page * 10)-10;
            $this->select("*", "examinees")->where("year")->orderBy("id", "DESC")->limit($this->offset,$this->limit)->build();
            return $this->execute([$year])->fetch_all();   
        }

        public function resultPagesData($page, $year){
            $this->offset = ($page * 10)-10;
            $sql = "select examinees.examinee_no, examinees.lname, examinees.fname, examinees.m_i, results.cjp,results.lea,results.cdip,results.c,results.ca,results.csehr,results.gen_ave from examinees, results where results.examinee_id = examinees.id and examinees.year = {$year} LIMIT {$this->offset},{$this->limit}";
            $this->query($sql)->build();
            return $this->execute()->fetch_all();   
        }

    }
?>