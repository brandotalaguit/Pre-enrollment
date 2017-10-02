<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        
        $inactive = 5500;
        if(isset($_SESSION['start']) )
        {
            $session_life = time() - $_SESSION['start'];
            if($session_life > $inactive)
            {
                $this->M_admin->updateLoggedOut($_SESSION['username']);
                unset($_SESSION);
                session_destroy();
                redirect('site/admin');
            }
        }
        $_SESSION['start'] = time();

        if(!isset($_SESSION['username']) || empty($_SESSION['username']))
        {
            redirect('site/admin');
        }        
        $this->load->library('session');
        $this->load->model('M_enroll');
        $this->load->model('M_assessment');
        $this->load->library('form_validation');

        // $_SESSION['sy_sem'] = $this->M_enroll->get_current_sy_sem();
        // $_SESSION['student_info'] = $this->M_enroll->get_student_info($_SESSION['student_id']);
        // $_SESSION['student_curriculum'] = $this->M_enroll->get_student_curriculum($_SESSION['student_id']);

        $data['site_title'] = 'University of Makati Online Enrollment';
        $data['site_description'] = 'University of Makati Online Enrollment - An Online Enrollment Solutions for UMak students';
        $data['site_author'] = 'University of Makati ITC Department';
        $data['site_icon'] = 'favicon.ico';
        $data['user_type'] = 'Registration Officer';
        $this->load->vars($data);
    }
    
    public function index()
    {        
        $data['main_content'] = 'registration_page';        

        $this->load->view('template_admin',$data);        
    }
    
    
    function deactivate_unpaid_students()
    {
    	$deactivation_date = $this->uri->segment(3,"0");
    	
    	if($deactivation_date > "0")
    	{
    		$sql = "UPDATE tblstudentschedule as A 
    				LEFT JOIN tblenrollmenttrans as B ON A.StudNo = B.StudNo 
    			SET IsActive = 0, IsDeactivated = 1 
    				WHERE
                        (
    						NOT EXISTS( SELECT * FROM tbllandbank_otc as C WHERE B.StudNo = C.StudentId ) 
    					OR 
    						EXISTS( SELECT * FROM tbllandbank_otc as C WHERE B.StudNo = C.StudentId AND OtcDate > '$deactivation_date' )
    					)
    				AND PaymentDate= '$deactivation_date' 
    			";
            echo '<link href="'.base_url().'assets/css/bootstrap.min.css" rel="stylesheet">';
            echo "<pre>";
    		$this->db->query($sql);
    		echo $this->db->last_query();
            echo "</pre><br/>";
    		echo "<br> <p><span class='label label-info'>Affected rows</span> <span class='badge badge-warning'>" . $this->db->affected_rows() . "</span>";
    		echo "<br> Command Finish Executing.";
    	}
    	
    }
    
    function migrate_token_fee_payment()
    {
        $date = $this->uri->segment(3,"0");
	$alldata = $this->uri->segment(4,0);
        if ($date > "0" || $alldata > 0)
        {
		$this->db->select('LEFT(date,10) as date, time_start, time_end, Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                    booklet, ornum, Amount as payment, "2nd Sem." as semester, "2013-2014" as acadyr,
                    IF(CollegeCode = "COAHS", 0.00, 
                    	IF(IsMakatiResident=1, 
                    		IF(DiscountPercentage>0,IF(DiscountPercentage=1,0.00,500.00),1000.00), 
                    		IF(DiscountPercentage>0,IF(DiscountPercentage=1,0.00,1500.00),3000.00)
                    	)
                    ) as assessment,
		    User as cashuser, "OL ASSESSED" as acctuser
                    ',FALSE);
                $this->db->join('tblstudcurriculum as studcurr', 'a.StudNo = studcurr.StudNo', 'left');
                $this->db->join('tblcurriculum as b','studcurr.curriculumid = b.curriculumid','left');
                $this->db->join('tblcollege as c', 'b.collegeid = c.collegeid', 'left');
                $this->db->join('tblprogram as d', 'b.programid = d.programid', 'left');
                $this->db->join('tblmajor as e', 'b.majorid = e.majorid', 'left');
                $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');
                $this->db->join('tblstudentscholar as f', 'a.StudNo = f.StudNo','left');
                $this->db->join('tblscholarship as g', 'f.ScholarshipId = g.ScholarshipId','left');
                $this->db->join('tblpayment as h', 'a.StudNo = h.StudNo','left');
                
                $this->db->where('IsPrinted',1);
                $this->db->where_in('FeeId',array(20,21));
                //if($alldata == 0)
                if(substr($date,0,4) == "2013")
                {
                $this->db->where('LEFT(DatePrint,10)',$date,FALSE);
                // $this->db->where('PaymentDate',$date);
                // $this->db->where('isEncoded',1);
                // $this->db->where('isAssessed',1);
                // $this->db->where_not_in('CollegeCode',array('CGPP'));
                // $this->db->or_where('Preenrolled',1);
		}

                $data['payment'] = $this->db->get('tblenrollmenttrans as a')->result_array();
                print_r($this->db->last_query());
                $db_name = 'token_fee_payment-on-'. date("Y-m-d-H-i-s");

                //header("Content-type: application/vnd.ms-excel");
                //header("Content-Disposition: attachment;Filename=$db_name.xls");
                //$this->load->view('token_fee_payment',$data);
        }
    }

    function migrate_printsec()
    {

    $date = $this->uri->segment(3,"0");
	$alldata = $this->uri->segment(4,0);

    $SyId = 4;
    $SemId = 2;

        if ($date > "0" || $alldata > 0)
        {
                $this->db->select('EncodedDateTimeEnd as date_ncode, DatePrint as date_print, Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                    CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level, 
                    b.CurriculumId, b.collegeid, b.programid, b.majorid, LengthOfStayBySem,
                    "2" as opt1, "3" as opt2, IF(Gender="M", "1",IF(Gender="F",2,0)) as opt3,
                    IsMakatiResident as opt_mkt, IF(IsMakatiResident=0,"1","0") as opt_nonmkt,
                    IF(CollegeCode = "COAHS", 0.00, 10000.00) as tuitionfee, 
                    IF(CollegeCode = "COAHS", 0.00, 
                    	IF(IsMakatiResident=1, IF(DiscountPercentage>0,IF(DiscountPercentage=1,10000.00,9500.00),9000.00), 
                    		IF(DiscountPercentage>0,IF(DiscountPercentage=1,10000.00,8500.00),7000.00)
                    	)
                    ) as scho_priv, ScholarshipDesc as assess_des,
                    IF(CollegeCode = "COAHS", 0.00, 
                    	IF(IsMakatiResident=1, 
                    		IF(DiscountPercentage>0,IF(DiscountPercentage=1,0.00,500.00),1000.00), 
                    		IF(DiscountPercentage>0,IF(DiscountPercentage=1,0.00,1500.00),3000.00)
                    	)
                    ) as assessment,
                    AddressStreet as street, AddressBarangay as barangay, AddressCity as city,
                    ( SELECT amount FROM tblassessmentinfo as a1 
                        LEFT JOIN tblfees as b1 
                            ON a1.feeid = b1.feeid 
                        LEFT JOIN tblassessmenttrans as c1
                            ON a1.assid = c1.assid
                        WHERE c1.StudNo = a.StudNo AND c1.assid IN (8,13)
                        ORDER BY amount DESC 
                        LIMIT 1 ) as nstp,
                    ( SELECT amount FROM tblassessmentinfo as a1 
                        LEFT JOIN tblfees as b1 
                            ON a1.feeid = b1.feeid 
                        LEFT JOIN tblassessmenttrans as c1
                            ON a1.assid = c1.assid
                        WHERE c1.StudNo = a.StudNo AND c1.assid IN (7,49,60,61)
                        ORDER BY amount DESC 
                        LIMIT 1 ) as lab,
                    Guardian, "OL ENCODE" as staff, 
                    (
                        SELECT IF(ISNULL(User), "OL ASSESSED", User) FROM tblassessmentiso WHERE StudNo = a.StudNo AND SyId = '.$SyId.' AND SemId = '.$SemId.' ORDER BY assess_iso_id DESC LIMIT 1
                    ) as acct_user, 
                    BirthDay as bday, EncodedDateTimeStart as time_start, EncodedDateTimeEnd as time_end, PaymentDate,
                    (SELECT SUM(Amount) FROM tblpayment WHERE StudNo = a.StudNo AND SemId = a.SemId AND SyId = a.SyId AND FeeId IN(20,21) AND is_actived = 1) as tokenfee_payments
                    ',FALSE);
                $this->db->join('tblstudcurriculum as studcurr', 'a.StudNo = studcurr.StudNo', 'left');
                $this->db->join('tblcurriculum as b','studcurr.curriculumid = b.curriculumid','left');
                $this->db->join('tblcollege as c', 'b.collegeid = c.collegeid', 'left');
                $this->db->join('tblprogram as d', 'b.programid = d.programid', 'left');
                $this->db->join('tblmajor as e', 'b.majorid = e.majorid AND e.programid = d.programid', 'left');
                $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');
                $this->db->join('tblstudentscholar as f', "a.StudNo = f.StudNo AND f.SemId = $SemId AND f.SyId = $SyId",'left');
                $this->db->join('tblscholarship as g', 'f.ScholarshipId = g.ScholarshipId','left');
                
                $this->db->where('IsPrinted', 1);
                $this->db->where('a.SyId', $SyId);
                $this->db->where('a.SemId', $SemId);

                if($alldata == 0)
                {
	                $this->db->where('LEFT(DatePrint,10)', $date, FALSE);
	                // $this->db->where('PaymentDate',$date);
	                // $this->db->where('isEncoded',1);
	                // $this->db->where('isAssessed',1);
	                // $this->db->where_not_in('CollegeCode',array('CGPP'));
	                // $this->db->or_where('Preenrolled',1);
        	}
	        
	        // $this->db->where('((SELECT SUM(Amount) FROM tblpayment WHERE StudNo = a.StudNo AND SemId = a.SemId AND SyId = a.SyId AND FeeId IN(20,21) AND is_actived = 1) > 0 OR DiscountPercentage > 0)', NULL, FALSE);

	                		
                $data['printsec'] = $this->db->get('tblenrollmenttrans as a')->result_array();
                // print_r($this->db->last_query());
                $db_name = 'printsec-on-'. date("Y-m-d-H-i-s");

                header("Content-type: application/vnd.ms-excel;charset=UTF-8");
                header("Content-Disposition: attachment;Filename=$db_name.xls");
                $this->load->view('printsec',$data);
        }

    }

    function migrate_printmas()
    {
        $date = $this->uri->segment(3,"0");
        $alldata = $this->uri->segment(4,0);

        $SyId = 4;
        $SemId = 2;

        if ($date > "0" || $alldata > 0)
        {        
            $this->db->select('a.transid, a.cfn as nametable, CollegeCode as offerby, 
                IF(subject_id = 0, sub_code, CourseCode) as subcode, 
                IF(subject_id = 0, sub_desc, CourseDesc) as subdes, 
                IF(subject_id = 0, c.units, d.Units) as units, 
                year_section as section, 
                Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, status as droprem,
                IF(IsPrinted=1, IF(a.IsActive=1, "F","T"),"T") as exclude, EncodedDateTimeEnd as date_log, PaymentDate', FALSE);

            $this->db->join('tblenrollmenttrans as b','a.StudNo = b.StudNo','left');
            $this->db->join('tblsched as c', 'a.cfn = c.cfn', 'left');
            $this->db->join('tblcourse as d', 'c.subject_id = d.courseid', 'left');
            $this->db->join('tblcollege as e', 'c.CollegeId = e.collegeid', 'left');
            $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');

	$this->db->where('IsPrinted', 1);
        $this->db->where('a.SyId', $SyId);
        $this->db->where('a.SemId', $SemId);

        if($alldata == 0)
        {
    	    $this->db->where('LEFT(DatePrint,10)',$date,FALSE);
            // $this->db->where('PaymentDate',$date);
            // $this->db->where('isEncoded',1);
            // $this->db->where('isAssessed',1);
            // $this->db->where_not_in('CollegeCode',array('CGPP'));
            // $this->db->or_where('Preenrolled',1);
	}
	
	                
        $this->db->order_by('b.id, a.StudNo');
        $data['printmas'] = $this->db->get('tblstudentschedule as a')->result_array();
	    echo $this->db->last_query();
        $db_name = 'printmas-on-'. date("Y-m-d-H-i-s");
	    
        //header("Content-type: application/vnd.ms-excel");
        //header("Content-Disposition: attachment;Filename=$db_name.xls");
        //$this->load->view('printmas',$data);            
        }

    }

    function migrate_assessment()
    {
        $date = $this->uri->segment(3,"0");
        $alldata = $this->uri->segment(4,0);

        $SyId = 4;
        $SemId = 2;

        if ($date > "0" || $alldata > 0)
        {   
            // IF(IsMakatiResident=2,"BRO/SIS/PARENT", "NON-MAKATI")
            $this->db->select('AssessedDateTime as date_asses, Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level,
                b.CurriculumId, b.CollegeId, b.ProgramId, b.MajorId, LengthOfStayBySem,
                IF(IsMakatiResident=1,"OWN VOTERS", IF(IsMakatiResident=2,"BRO\/SIS\/PARENT", "NON-MAKATI")) as residency,
                IF(CollegeCode = "COAHS", 0.00, 10000.00) as tuitionfee, 
                IF(CollegeCode = "COAHS", 0.00, 
                    	IF(IsMakatiResident=1, IF(DiscountPercentage>0,IF(DiscountPercentage=1,10000.00,9500.00),9000.00), 
                    		IF(DiscountPercentage>0,IF(DiscountPercentage=1,10000.00,8500.00),7000.00)
                    	)
                ) as scho_priv, ScholarshipDesc as assess_des,
                IF(CollegeCode = "COAHS", 0.00, 
                    	IF(IsMakatiResident=1, 
                    		IF(DiscountPercentage>0, IF(DiscountPercentage = 1, 0.00, 500.00), 1000.00), 
                    		IF(DiscountPercentage>0, IF(DiscountPercentage = 1, 0.00, 1500.00), 3000.00)
                    	)
                ) as assessment,
                (
                    SELECT IF(ISNULL(User), "OL ASSESSED", User) FROM tblassessmentiso WHERE StudNo = a.StudNo AND SyId = '.$SyId.' AND SemId = '.$SemId.' ORDER BY assess_iso_id DESC LIMIT 1
                ) as acct_user, 
                ( SELECT time_start FROM tblassessmentiso WHERE StudNo = a.StudNo AND SyId = '.$SyId.' AND SemId = '.$SemId.' ORDER BY assess_iso_id DESC LIMIT 1 ) as time_start, 
                ( SELECT time_end FROM tblassessmentiso WHERE StudNo = a.StudNo AND SyId = '.$SyId.' AND SemId = '.$SemId.' ORDER BY assess_iso_id DESC LIMIT 1 ) as time_end, 
                PaymentDate',
                FALSE );
            $this->db->join('tblstudcurriculum as studcurr', 'a.StudNo = studcurr.StudNo', 'left');
            $this->db->join('tblcurriculum as b','studcurr.curriculumid = b.curriculumid','left');
            $this->db->join('tblcollege as c', 'b.collegeid = c.collegeid', 'left');
            $this->db->join('tblprogram as d', 'b.programid = d.programid', 'left');
            $this->db->join('tblmajor as e', 'b.majorid = e.majorid', 'left');
            $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');
            $this->db->join('tblstudentscholar as f', 'a.StudNo = f.StudNo','left');
            $this->db->join('tblscholarship as g', 'f.ScholarshipId = g.ScholarshipId','left');
            
	    $this->db->where('IsPrinted',1);
        $this->db->where('a.SyId', $SyId);
        $this->db->where('a.SemId', $SemId);
        
            if($alldata == 0)
            {
	    $this->db->where('LEFT(DatePrint,10)',$date,FALSE);
            // $this->db->where('PaymentDate',$date);
            // $this->db->where('isEncoded',1);
            // $this->db->where('isAssessed',1);
            // $this->db->where_not_in('CollegeCode',array('CGPP','COAHS'));
            // $this->db->or_where('Preenrolled',1);
	    }
            $data['assessment'] = $this->db->get('tblenrollmenttrans as a')->result_array();
	    echo $this->db->last_query();
            $db_name = 'assessment-on-'. date("Y-m-d-H-i-s");
		
            //header("Content-type: application/vnd.ms-excel");
            //header("Content-Disposition: attachment;Filename=$db_name.xls");
            //$this->load->view('assessment_page',$data);
        }

    }

    function migrate_miscfee()
    {
        $date = $this->uri->segment(3,"0");
        $alldata = $this->uri->segment(4,0);

        if ($date > "0" || $alldata > 0)
        {        
            $this->db->select('AssessedDateTime as date, 
                Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level,
                "OL ASSESSED" as assessedby, PaymentDate',
                FALSE );

            // SUM(detour+jfinex+jma+jpms+jpia+kafil+mathsoc+nets+pesco+pnsa+polsci+psychsoc+sfop+sms+ssg+sgp+comsoc+concen+umakfilm) as total

            $this->db->join('tblstudcurriculum as studcurr', 'a.StudNo = studcurr.StudNo', 'left');
            $this->db->join('tblcurriculum as b','studcurr.curriculumid = b.curriculumid','left');
            $this->db->join('tblcollege as c', 'b.collegeid = c.collegeid', 'left');
            $this->db->join('tblprogram as d', 'b.programid = d.programid', 'left');
            $this->db->join('tblmajor as e', 'b.majorid = e.majorid', 'left');
            $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');
            
            $this->db->where('IsPrinted',1);
            if($alldata == 0)
            {
	    $this->db->where('LEFT(DatePrint,10)',$date,FALSE);
            // $this->db->where('PaymentDate',$paymentdate);
            // $this->db->where('isEncoded',1);
            // $this->db->where('isAssessed',1);
            // $this->db->where_not_in('CollegeCode',array('CGPP','COAHS'));
            // $this->db->or_where('Preenrolled',1);
	    }
            $data['miscfee'] = $this->db->get('tblenrollmenttrans as a')->result_array();
            // echo $this->db->last_query();

            $db_name = 'miscfee-on-'. date("Y-m-d-H-i-s");

            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;Filename=$db_name.xls");
            $this->load->view('misc_fee',$data);
        }

    }

    function migrate_miscfee2()
    {
	    
            $this->db->select('AssessedDateTime as date, 
                Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level,
                "OL ASSESSED" as assessedby, PaymentDate,h.*',
            FALSE);
            
            
            /*
	    $this->db->select('AssessedDateTime as date, Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level, a.FeeId, f.FeeDesc, a.Amount,
                "OL ASSESSED" as assessedby',FALSE);
            */    

            // SUM(detour+jfinex+jma+jpms+jpia+kafil+mathsoc+nets+pesco+pnsa+polsci+psychsoc+sfop+sms+ssg+sgp+comsoc+concen+umakfilm) as total

            $this->db->join('tblstudcurriculum as studcurr', 'a.StudNo = studcurr.StudNo', 'left');
            $this->db->join('tblcurriculum as b','studcurr.curriculumid = b.curriculumid','left');
            $this->db->join('tblcollege as c', 'b.collegeid = c.collegeid', 'left');
            $this->db->join('tblprogram as d', 'b.programid = d.programid', 'left');
            $this->db->join('tblmajor as e', 'b.majorid = e.majorid', 'left');
            $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');

	    $this->db->join('tblassessmentinfo as i','i.AssId = a.AssId','left');
	    $this->db->join('tblfees h','i.FeeId = h.FeeId','left');
	    $this->db->join('tblenrollmenttrans as g','g.StudNo= a.StudNo','left');	    
            
	    
	    $this->db->where_not_in('h.FeeId',array(20,21));
            $data['miscfee'] = $this->db->get('tblassessmenttrans as a')->result_array();
            
            echo $this->db->last_query();
           

    }

    function migrate_miscfee_collection()
    {
        $date = $this->uri->segment(3,"0");
        $alldata = $this->uri->segment(4,0);

        if ($date > "0" || $alldata > 0)
        {        
            $this->db->select('DISTINCT m.ornum, m.booklet, m.user, LEFT(m.date,10) as date, 
                Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level,
                "OL ASSESSED" as assessedby, PaymentDate',
                FALSE );

            // SUM(detour+jfinex+jma+jpms+jpia+kafil+mathsoc+nets+pesco+pnsa+polsci+psychsoc+sfop+sms+ssg+sgp+comsoc+concen+umakfilm) as total

            $this->db->join('tblstudcurriculum as studcurr', 'a.StudNo = studcurr.StudNo', 'left');
            $this->db->join('tblcurriculum as b','studcurr.curriculumid = b.curriculumid','left');
            $this->db->join('tblcollege as c', 'b.collegeid = c.collegeid', 'left');
            $this->db->join('tblprogram as d', 'b.programid = d.programid', 'left');
            $this->db->join('tblmajor as e', 'b.majorid = e.majorid', 'left');
            $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');
            $this->db->join('tblpaymentmisc as m', 'a.StudNo = m.StudNo','inner');
            
            //$this->db->where('IsPrinted',1);
            if($alldata == 0)
            {
        	    $this->db->where("LEFT(DatePrint,10)='$date'",NULL,FALSE);
    	    }

            $data['miscfee'] = $this->db->get('tblenrollmenttrans as a')->result_array();

            //echo $this->db->last_query();


            $db_name = 'miscfeecollection-on-'. date("Y-m-d-H-i-s");

            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;Filename=$db_name.xls");


            $this->load->view('misc_fee_collection',$data);
        }

    }

    function migrate_miscfee_collection2()
    {
        $sql = "SELECT a.*,Lname,Fname,Mname,CONCAT(Lname,',',Fname, ' ', Mname) as StudName, 
                    CurriculumDesc, FeeDesc 
                    FROM `tblpaymentmisc` as a 
                    LEFT JOIN tblfees as b ON a.FeeId = b.FeeId
                    LEFT JOIN tblstudinfo as c ON a.StudNo = c.StudNo
                    LEFT JOIN tblstudcurriculum as d ON d.StudNo = a.StudNo
                    LEFT JOIN tblcurriculum as e ON e.CurriculumId = d.CurriculumId
                    WHERE SyId = 4 AND SemId = 1";

        echo "<pre>$sql</pre>";
    }


    function migrate_miscfee_collection2old()
    {
    
    
	/*
            $this->db->select('DISTINCT m.ornum, m.booklet, m.user, LEFT(m.date,10) as date, 
                Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level,
                "OL ASSESSED" as assessedby, PaymentDate',
                FALSE );
        */
	
	
	
	$this->db->select('ornum, booklet, user, LEFT(date,10) as date, Lname as lastname, Fname as firstname, Mname as initials, a.StudNo as newstudid, 
                CollegeCode as college, ProgramDesc as program, MajorDesc as major, YrLevel as yr_level, a.FeeId, f.FeeDesc, a.Amount,
                "OL ASSESSED" as assessedby', FALSE);
	
	
        
        // SUM(detour+jfinex+jma+jpms+jpia+kafil+mathsoc+nets+pesco+pnsa+polsci+psychsoc+sfop+sms+ssg+sgp+comsoc+concen+umakfilm) as total

            $this->db->join('tblstudcurriculum as studcurr', 'a.StudNo = studcurr.StudNo', 'left');
            $this->db->join('tblcurriculum as b','studcurr.curriculumid = b.curriculumid','left');
            $this->db->join('tblcollege as c', 'b.collegeid = c.collegeid', 'left');
            $this->db->join('tblprogram as d', 'b.programid = d.programid', 'left');
            $this->db->join('tblmajor as e', 'b.majorid = e.majorid', 'left');
            $this->db->join('tblstudinfo as studinfo', 'a.StudNo = studinfo.StudNo','left');
            $this->db->join('tblfees as f', 'a.FeeId = f.FeeId','left');
            $this->db->join('tblenrollmenttrans as g', 'g.StudNo = a.StudNo','left');
            $this->db->order_by('ornum,booklet,a.StudNo');
            
            if($this->uri->segment(3,FALSE) != FALSE)
            {
	    $this->db->where("LEFT(DatePrint,10)='$date'",NULL,FALSE);
	    }
            $data['miscfee'] = $this->db->get('tblpaymentmisc as a')->result_array();            
            echo $this->db->last_query();


    }




    public function printmas_dump()
    {
	// exec('mysqldump --user=... --password=... --host=... DB_NAME > /path/to/output/file.sql');
    }


    public function olea_studgrade()
    {
        $sql = 'UPDATE tblstudgrade114 as a 
                    LEFT JOIN tblsched as b ON a.NAMETABLE = b.cfn
                    LEFT JOIN tblcourse as c ON b.subject_id = c.CourseId
                    LEFT JOIN tblstudcurriculum as d ON a.StudNo = d.StudNo
                    LEFT JOIN tblcurriculumdetails as e ON d.CurriculumId = e.CurriculumId AND c.CourseId = e.CourseId
                SET a.CourseId = e.CourseId';
        
        $this->db->query($sql);

        $this->db->select('a.*, c.EquivalentCourse, c.CourseId as EquivalentId, d.CurriculumId');
        $this->db->join('tblsched as b', 'a.nametable = b.cfn', 'left');
        $this->db->join('tblcourse as c', 'b.subject_id = c.CourseId', 'left');
        $this->db->join('tblstudcurriculum as d', 'a.StudNo = d.StudNo', 'left');
        $this->db->where('d.CurriculumId >', 0);
        $olea_studgrade = $this->db->where('a.CourseId', 0)->get('tblstudgrade114 as a')->result();
        dump($this->db->last_query());
        foreach ($olea_studgrade as $studgrade) 
        {
            $course_ids = explode(',', $studgrade->EquivalentCourse);
            dump($studgrade->EquivalentCourse);
            foreach ($course_ids as $key => $id) 
            {
                if ($id != $studgrade->CourseId) 
                {
                    $this->db->where(array('CurriculumId' => $studgrade->CurriculumId, 'CourseId' => $id));
                    $curriculum = $this->db->get('tblcurriculumdetails');
                    dump($this->db->last_query());
                    if ($curriculum->num_rows() > 0) 
                    {
                        $this->db->limit(1);
                        $this->db->where(array('StudNo' => $studgrade->StudNo, 'nametable' => $studgrade->nametable));
                        $this->db->update('tblstudgrade114', array('CourseId' => $id, 'EquivalentId' => $studgrade->EquivalentId));
                        dump($this->db->last_query());
                        break;
                    }

                }

            } // end of course id's
        } // end of parent loop

        // set course id to zero(0) for remarks is LOA 
        $this->db->where('remarks', 'LOA');
        $this->db->update('tblstudgrade114', array('CourseId' => 0));

        $this->db->query('DELETE FROM `tblstudgrade114` WHERE StudNo IN(SELECT newstudid FROM univesl1_rog114.stud_info WHERE passkey = " ")');

    }


    public function logout()
    {
        $this->load->model('M_admin');
        $this->M_admin->update_logged_out($_SESSION['username']);
        unset($_SESSION);
        session_destroy();
        redirect('site/admin');
    }

}