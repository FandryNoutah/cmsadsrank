<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Export extends MY_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('campagne_model');
        $this->excel->setActiveSheetIndex(0);
        $this->tablefields = $this->db->list_fields('hm_panneau');
		$this->headers = $this->panneau_model->get_table_headers('hm_panneau');
        $this->unsetValues = array("id", "panneau_date_pose", "status", "visuel_id", "campagne_id", "panneau_autres_images", "panneau_visuel_actuel_path");
		$this->campagne = $this->campagne_model->get_campagne_visuels();
		$this->styleArray = [
            'font' => [
                'size' => 8
            ],
			'borders' => [
				'allborders' => [
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => ['argb' => '555555']
				]
			]
        ];
		
		$this->campagneStyleArray = [
            'font' => [
                'size' => 8
            ],
			'borders' => [
				'allborders' => [
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => ['argb' => '555555']
				]
			],
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'F0F0F0'),
			]
        ];
		
		$this->headerStyleArray = [
            'font' => [
                'size' => 9,
				'bold'  => true,
            ],
			'borders' => [
				'allborders' => [
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => ['argb' => '555555']
				]
			],
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'FFDD00'),
			]
        ];
		
		$this->campagneHeaderStyleArray = [
            'font' => [
                'size' => 9,
				'bold'  => true,
            ],
			'borders' => [
				'allborders' => [
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => ['argb' => '555555']
				]
			],
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'DDDDDD'),
			]
        ];
	}
    public function index($toexcel = null) {
        //echo "session";
        //datadump($_SESSION);
		$toexcel = $this->session->flashdata("result");
        $filters = $this->session->flashdata("filters");
       // datadump($toexcel);
        //datadump($filters);
        //datadump(gettype($toexcel));
        //datadump($this->tablefields);
        //datadump($this->headers);

        //die();
		
        /*
        foreach($tablefields as $k => $field) {
            $title[$field] = $this->setColumnTitle($field);
        }
        */
        
        $worksheet = $this->excel->getActiveSheet();
        $worksheet->setTitle('Panneaux');
        $row = 2;
        
		//Frormatter au format du prix sur excel
        $priceformat = array("panneau_cout_impression", "panneau_cout_pose_finition", "panneau_cout_location");
		
		//Ne pas afficher les valeurs de cescolonnes dans le fichier Excel
        $unsetValues = array("id", "status", "visuel_id", "campagne_id", "panneau_autres_images", "panneau_visuel_actuel_path");
		
		$cell = 0;
		if(is_array($toexcel)) {
			
			$this->set_headers($worksheet, $cell, 1, $this->headerStyleArray);
			
			foreach($toexcel as $keyRow => $valueRow) {
            $cell = 0;
			/*
			unset($valueRow["id"]);
			unset($valueRow["status"]);
			unset($valueRow["visuel_id"]);
			unset($valueRow["campagne_id"]);
			unset($valueRow["panneau_autres_images"]);
			unset($valueRow["panneau_visuel_actuel_path"]);
			*/
			
			foreach($this->unsetValues as $unsetKey) {
				unset($valueRow[$unsetKey]);
			}
			
            foreach ($valueRow as $keyCell => $valueCell) {
				
				
				$worksheet->getCellByColumnAndRow($cell, $row)
                            ->getStyle()
							->applyFromArray($styleArray);
							  
				$worksheet->getCellByColumnAndRow($cell, $row)
                            ->getStyle()
							->getBorders()
							->getAllBorders()
							->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
							->getColor()
							->setRGB('000000');
				
				$this->setCellStyle($worksheet, $cell, $row, $this->styleArray);
				
				
				/* Auto width */
				$cellIterator = $worksheet->getRowIterator()->current()->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(true);
				foreach($cellIterator as $cellS) {
					$worksheet->getColumnDimension($cellS->getColumn())->setAutoSize( true );
				}				
				/* Auto width */
				
                if($row == 1) {
                    //$worksheet->setCellValueByColumnAndRow($cell, $row, $title[$keyCell]);
                }


                
                if (in_array($keyCell, $priceformat)) {
                    $worksheet->getCellByColumnAndRow($cell, $row)
                              ->getStyle()
                              ->getNumberFormat()
                              ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }

                if(!is_array($valueCell)) {
                    switch ($keyCell) {
						/***
                        case 'panneau_format':
                            $valueCell = $filters["_formats"][$valueCell]["format"];
                            break;
                        case 'panneau_type':
                            $valueCell = $filters["_types"][$valueCell]["type"];
                            break;
                        case 'panneau_province':
                            $valueCell = $filters["_provinces"][$valueCell]["label"];
                            break;
                        case 'panneau_axe':
                            $valueCell = $filters["_axes"][$valueCell]["label"];
                            break;
                        case 'panneau_sam':
                            $valueCell = $filters["_sam"][$valueCell]["label"];
                            break;
                        case 'panneau_regisseur':
                            $valueCell = $filters["_regisseurs"][$valueCell]["label"];
                            break;
                        case 'panneau_couverture_4g':
                        case 'panneau_couverture_fo':
                        case 'panneau_couverture_adsl':
                            $valueCell = $filters["_yesno"][$valueCell];
                        default:
                            break;
						
						----------------------------***/
						
						case 'panneau_format':
							$valueCell = $filters["panneau_format"][$valueCell]["label"];
							break;
						case 'panneau_type':
							$valueCell = $filters["panneau_type"][$valueCell]["label"];
							break;
						case 'panneau_province':
							$valueCell = $filters["panneau_province"][$valueCell]["label"];
							break;
						case 'panneau_axe':
							$valueCell = $filters["panneau_axe"][$valueCell]["label"];
							break;
						case 'panneau_sam':
							$valueCell = $filters["panneau_sam"][$valueCell]["label"];
							break;
						case 'panneau_regisseur':
							$valueCell = $filters["panneau_regisseur"][$valueCell]["label"];
							break;
						case 'panneau_cout_impression':
						case 'panneau_cout_pose_finition':
						case 'panneau_cout_location':
							$valueCell = "Ar " . number_format(intval($valueCell), 0, '', '.');
							break;
						case 'panneau_couverture_4g':
							$valueCell = $filters["panneau_couverture_4g"][$valueCell];
							break;
						case 'panneau_couverture_fo':
							$valueCell = $filters["panneau_couverture_fo"][$valueCell];
							break;
						case 'panneau_couverture_adsl':
							$valueCell = $filters["panneau_couverture_adsl"][$valueCell];
							break;
						default:
							break;
						/***----------------------------***/
                    }
/*
                    $worksheet->getCellByColumnAndRow($cell, $row)
                              ->getStyle()
                              ->getFont()
                              ->s‌​etBold(true);
*/
                    $worksheet->setCellValueByColumnAndRow($cell, $row, $valueCell);

                    $cell++;
                } else {
                    foreach ($valueCell as $key => $value) {
						
						$this->setCellStyle($worksheet, $cell, $row, $this->campagneStyleArray);
						$v_id = $value["visuel_id"] == 0 ? "" : $filters["visuel_id"][$value["visuel_id"]]["panneau_visuel_name"];
						$campagne = $value["visuel_id"] == 0 ? "" : $filters["_campagnes"][$value["campagne_id"]]["panneau_campagne_nom"];
						
						$line = 1;
						if($line == 1)
							$this->setCellStyle($worksheet, $cell, $line, $this->campagneHeaderStyleArray);
							$worksheet->setCellValueByColumnAndRow($cell, $line, utf8_encode($campagne));
							
                        $worksheet->setCellValueByColumnAndRow($cell, $row, utf8_encode($v_id));
                        $cell++;
                    }
                }
                
                //datadump($valueCell);
                
            }
            $row++;
			}
        } else {
			die(gettype($toexcel));
		}
		
        //die();

        $filename ='panneaux.xls';
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');
        //redirect('panneau/liste', 'refresh');
    }
	
	public function setCellStyle($ws, $cell, $row, $style) {
		$ws->getCellByColumnAndRow($cell, $row)
					->getStyle()
					->applyFromArray($style);
					  
		$ws->getCellByColumnAndRow($cell, $row)
					->getStyle()
					->getBorders()
					->getAllBorders()
					->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
					->getColor()
					->setRGB('000000');
		return;
	}
	
	public function set_headers($ws, $cell, $row, $style) {
		//$header = $this->headers;
		$cell = 0;
		foreach($this->headers as $key => $value) {
			if(!in_array($value["column_name"], $this->unsetValues)) {
				$this->setCellStyle($ws, $cell, $row, $style);
				$ws->setCellValueByColumnAndRow($cell, $row, $value["column_comment"]);
				$cell++;
			}
			
		}
		return;
	}
}