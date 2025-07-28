<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Export extends MY_Controller
{

    public function index($toexcel = null) {
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $tablefields = $this->db->list_fields('hm_panneau');

        $toexcel = $this->session->flashdata("result");
        $filters = $this->session->flashdata("filters");

        //echo "session";
        //datadump($_SESSION);

        //datadump(count($toexcel));
        //datadump($toexcel);
        //datadump($filters);

        //die();


        /*
        foreach($tablefields as $k => $field) {
            $title[$field] = $this->setColumnTitle($field);
        }
        */
        
        $worksheet = $this->excel->getActiveSheet();
        $worksheet->setTitle('Panneaux');
        $row = 1;
        $styleArray = [
            'font' => [
                'size' => 10
            ]
        ];
        $priceformat = array("panneau_cout_impression", "panneau_cout_pose_finition", "panneau_cout_location");
        foreach($toexcel as $keyRow => $valueRow) {
            $cell = 1;
            foreach ($valueRow as $keyCell => $valueCell) {
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
						
						$v_id = $value["visuel_id"] == 0 ? "" : $filters["_visuels"][$value["visuel_id"]]["panneau_visuel_name"];
						
                        $worksheet->setCellValueByColumnAndRow($cell, $row, $v_id);
                        $cell++;
                    }
                }
                
                //datadump($valueCell);
                
            }
            $row++;
        }
		
        //die();

        $filename ='panneaux.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');
        //redirect('panneau/liste', 'refresh');
    }
}