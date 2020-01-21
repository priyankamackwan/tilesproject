<?php

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;

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
			$this->db->where('p.is_deleted', 0); 
			$this->db->group_by('o.product_id');
			$this->db->having('ROUND((p.quantity*'.Stock_Reminder.')/100)>=p.quantity-SUM(o.quantity)');
			$this->db->order_by('rem asc');
			$stockcount=$this->db->get()->num_rows();

			if($stockcount>=1) // some low stock is exist
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
				$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Sold Quantity');
				$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Balance Quantity');

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
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, round($list['quantity'],2));
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, round($list['req'],2));
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, round($list['sold'],2));
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, round($list['rem'],2));
					$rowCount++;
				}

				//$fileName='Stockreminder of '.date('j-F').",".date('Y').".csv";
				$fileName='Stockreminder-of-'.date('j-F')."-".date('Y').".csv";
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV'); 
				//ob_end_clean();
				$objWriter->save(str_replace(__FILE__,APPPATH.'stockreminderfile/'.$fileName,__FILE__)); // save file in folder

				/*$this->load->library('phpmailer_lib');
				$mail = $this->phpmailer_lib->load();

				$mail->isSMTP();
				$mail->Host     = Mail_Host;
				$mail->SMTPAuth = true;
				$mail->Username = Mail_Username;
				$mail->Password = Mail_Password;
				$mail->SMTPSecure = 'ssl';
				$mail->Port     = 465;

				$mail->setFrom('pnpsales2019@gmail.com', 'Low Stock Reminder');

				// Email subject
				$mail->Subject = 'Low Stock Reminder Mail';

				// Set email format to HTML
				$mail->isHTML(true);*/

				$mail = new PHPMailer;
				$mail->isMail();
				$mail->setFrom('pnpsales2019@gmail.com', 'Tiles Admin');
				$mail->Subject = "Low Stock Reminder";

				// Email body content
				/*$mailContent = "<h1><font color='red'>Low Stock Reminder Mail</font></h1><p style='font-size:20px;'>Dear Admin, Kindly find the attached excelsheet which indicated some products are less than 25% in your stock. Kindly take some rapid action to deny that.</p><p style='font-size:20px;'>Thank You.</p>";*/
				$mail->MsgHTML("<h1><font color='red'>Low Stock Reminder</font></h1><p style='font-size:20px;'>Dear Admin, Kindly find the attached excelsheet which indicated some products are less than ".Stock_Reminder."% in the stock.</p><p style='font-size:20px;'>Thank You.</p>");
				//$mail->Body = $mailContent;
				$mail->AddAttachment(APPPATH.'stockreminderfile/'.$fileName);

				$sendmailto = $this->db->select('email')->from('admin_users')->where('role_id',1)->where('status',1)->where('is_deleted',0)->get()->result_array();

				if(sizeof($sendmailto)>=1) // if admin is exist and not deleted
				{
					foreach ($sendmailto as $value) // create an array having email address of admin
					{
						// $sendto[] = trim($value['email']);
						$mail->addAddress(trim($value['email']));
					}
					$mail->send();
				}
			}
		}
	}
?>