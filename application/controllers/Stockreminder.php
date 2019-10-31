<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Stockreminder extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

		}
		public function index()
		{
			//create folder if not exist
			if (!is_dir(APPPATH.'stockreminderfile')) 
			{
			    mkdir(APPPATH.'stockreminderfile/',0777,TRUE);
			}

			$this->db->select('p.id,p.name,p.design_no,p.quantity,ROUND((p.quantity*'.Stock_Reminder.')/100) as req,SUM(o.quantity) as sold,p.quantity-SUM(o.quantity) as rem');
	        $this->db->from('products AS p');
	        $this->db->join('order_products AS o','p.id=o.product_id');
	        $this->db->where('p.status',1);
	        $this->db->group_by('o.product_id');
	        $this->db->having('ROUND((p.quantity*'.Stock_Reminder.')/100)>=p.quantity-SUM(o.quantity)');
	        $this->db->order_by('rem asc');
	        $stockcount=$this->db->get()->num_rows();

	        if($stockcount>=1)
	        {

				// empty the folder if any other file is exist
			    $files = glob(APPPATH.'stockreminderfile/*');
				foreach($files as $file)
				{
				    if(is_file($file))
				    unlink($file);
				}
			
		        // load excel library
		        $this->load->library('excel');
		        $objPHPExcel = new PHPExcel();
		        $objPHPExcel->setActiveSheetIndex(0);

		        // set Header
		        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr No');
		        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product Name');
		        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Design No');
		        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Total Quantity');
		        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Required Quantity');
		        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Total Sold Quantity');
		        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Remaining Quantity');

	        	// database data
		        $this->db->select('p.id,p.name,p.design_no,p.quantity,ROUND((p.quantity*'.Stock_Reminder.')/100) as req,SUM(o.quantity) as sold,p.quantity-SUM(o.quantity) as rem');
		        $this->db->from('products AS p');
		        $this->db->join('order_products AS o','p.id=o.product_id');
		        $this->db->where('p.status',1);
		        $this->db->group_by('o.product_id');
		        $this->db->having('ROUND((p.quantity*'.Stock_Reminder.')/100)>=p.quantity-SUM(o.quantity)');
		        $this->db->order_by('rem asc');
		        $listInfo=$this->db->get()->result_array();
		        $rowCount = 2;
		        $srno1=1;
		        foreach ($listInfo as $list)
		        {
		            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $srno1++);
		            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['name']);
		            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['design_no']);
		            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['quantity']);
		            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['req']);
		            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['sold']);
		            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['rem']);
		            $rowCount++;
		        }
	        
		        $fileName='Stockreminder of '.date('j-F').",".date('Y').".csv";
		        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV'); 
		        //ob_end_clean();
		        $objWriter->save(str_replace(__FILE__,APPPATH.'stockreminderfile/'.$fileName,__FILE__)); // save file in folder

	        	$this->load->library('phpmailer_lib');
		        $mail = $this->phpmailer_lib->load();

		        $mail->isSMTP();
		        $mail->Host     = Mail_Host;
		        $mail->SMTPAuth = true;
		        $mail->Username = Mail_Username;
		        $mail->Password = Mail_Password;
		        $mail->SMTPSecure = 'ssl';
		        $mail->Port     = 465;

		        $mail->setFrom('info.emailtest1@gmail.com', 'Low Stock Reminder');
		        $mail->addReplyTo('info.emailtest1@gmail.com', 'Low Stock Reminder');

		        // Add a recipient
		        //$mail->addAddress('gaurav.webpatriot@gmail.com');

	        	// Email subject
		        $mail->Subject = 'Low Stock Reminder Mail';

		        // Set email format to HTML
		        $mail->isHTML(true);

		        // Email body content
		        $mailContent = "<h1><font color='red'>Low Stock Reminder Mail</font></h1>
		            <p style='font-size:20px;'>Dear Admin, Kindly find the attached excelsheet which indicated some products are less than 25% in your stock. Kindly take some rapid action to deny that.</p>
		            <p style='font-size:20px;'>Thank You.</p>";
		        $mail->Body = $mailContent;
		        $mail->AddAttachment(APPPATH.'stockreminderfile/'.$fileName);

		        $sendmailto=$this->db->select('email')->from('admin_users')->get()->result_array();

		        foreach ($sendmailto as $value)
		        {
		        	$sendto=trim($value['email']);
		        	$mail->addAddress($sendto);
		        	$mail->send();
		        }
		    }
		}
	}
?>    