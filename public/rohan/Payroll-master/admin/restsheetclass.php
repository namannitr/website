<?php

class enter_rest_data {

    private $emp_id = array();
    private $month;
    private $year;
    private $query;

    public function rest_sheet($ids, $rests, $month, $year) {
        include_once '../dbfiles/config.php';
        $this->emp_id = $ids;
        $emp_rest = $rests;
        $this->month = $month;
        $this->year = $year;
        $i = 0;
        foreach ($this->emp_id as $id) {
            $this->query = mysql_query("Insert into worker_rest_sheet (id, day, month, year) values ('$id', '$emp_rest[$i]', '$this->month', '$this->year')");
            if (!$this->query) {
                echo mysql_error();
            } else {
                header('location:showrestsheet.php?m=' . $this->month . '&y=' . $this->year);
            }
            $i = $i + 1;
        }
    }

}

class make_rep {

    private $month;
    private $year;
    private $query;

    public function makerep($m, $y) {
        include_once '../dbfiles/config.php';
        require_once('../library/odf.php');
        $this->month = $m;
        $this->year = $y;
        $odf = new odf("rest.odt");
        $odf->setVars('month', $this->month);
        $odf->setVars('year', $this->year);
        $restsheet = $odf->setSegment('rest');
        $s = 1;
        $this->query = mysql_query("SELECT workers.id as id, worker_fname, worker_lname, day, month, year FROM workers, worker_rest_sheet where workers.id=worker_rest_sheet.id and month='$this->month' and year='$this->year'");
        while ($result = mysql_fetch_array($this->query)) {
            $name = $result['worker_fname'] . ' ' . $result['worker_lname'];
	    if($result['id']==30 || $result['id']==31){
		continue;
	    }
            $restsheet->s($s);
            $restsheet->name($name);
            $restsheet->day($result['day']);
            $restsheet->merge();
            $s = $s + 1;
        }
        $odf->mergeSegment($restsheet);
        $odf->exportAsAttachedFile('RestSheet.odt');
    }

}

class update_sheet{
    private $emp_id = array();
    private $month;
    private $year;
    private $query;

    public function upsheet($ids, $rests, $month, $year) {
        include_once '../dbfiles/config.php';
        $this->emp_id = $ids;
        $emp_rest = $rests;
        $this->month = $month;
        $this->year = $year;
        $i = 0;
        foreach ($this->emp_id as $id) {
            $this->query = mysql_query("Update worker_rest_sheet set day='$emp_rest[$i]' where month='$this->month' and year='$this->year' and id='$id'");
            if (!$this->query) {
                echo mysql_error();
            } else {
                header('location:showrestsheet.php?m=' . $this->month . '&y=' . $this->year);
            }
            $i = $i + 1;
        }
    }
}
?>
