<?php 
error_reporting(E_ALL);
 ini_set("display_errors", 0);
include("inc/dbconfig.php");

mysql_query ("SET NAMES UTF8");

$get_var = explode("__", mysql_real_escape_string($_GET['s']));
$psu_selector = 0;
if($get_var[0] == "scm"){

    if(strcasecmp($get_var[1],"Fremont")){
        $query = "SELECT M.Model_Internal, S.P_PFC_D, S.P_Input_D_Type, S.P_Warranty_D, P.Box_Height_mm, P.Box_Width_mm,
    P.Box_Depth_mm, P.Box_Weight_gross_kg, P.Box_CBM, P.Master_quantity, P.Master_Height_mm, P.Master_Width_mm, P.Master_Depth_mm,
    P.Master_Weight_gross_kg, P.Master_CBM, P.FOB_Point, P.Location, P.Pallet_EU, P.Pallet_HK, P.Pallet_NA
    FROM models M, specs_p S, packing P
    WHERE M.Model_Internal = S.Model_Internal
    AND M.Model_Internal = P.Model_Internal
    AND M.PSU_$get_var[1] = 'y'";
    }else{
        $query = "SELECT M.Model_Internal, S.P_PFC_D, S.P_Input_D_Type, S.P_Warranty_D, P.Box_Height_inch, P.Box_Width_inch,
    P.Box_Depth_inch, P.Box_Weight_gross_libs, P.Box_CUFT, P.Master_quantity, P.Master_Height_inch, P.Master_Width_inch, P.Master_Depth_inch,
    P.Master_Weight_gross_libs, P.Master_CUFT, P.FOB_Point, P.Location, P.Pallet_EU, P.Pallet_HK, P.Pallet_NA
    FROM models M, specs_p S, packing P
    WHERE M.Model_Internal = S.Model_Internal
    AND M.Model_Internal = P.Model_Internal
    AND M.PSU_$get_var[1] = 'y'";


    }
}else if($get_var[0] == "psu"){

    switch($get_var[1]){
        case 'output': //PSU_OUTPUT
            $query = "SELECT M.Model_Internal, S.P_Spec_12v_1_max, S.P_Spec_12v_1_min, S.P_Spec_12v_2_max, S.P_Spec_12v_2_min, S.P_Spec_12v_3_max,
                    S.P_Spec_12v_3_min, S.P_Spec_12v_4_max, S.P_Spec_12v_4_min, S.P_Spec_12v_comb_A, S.P_Spec_12v_comb_W,
                    S.P_Spec_33_max, S.P_Spec_33_min, S.P_Spec_5_max, S.P_Spec_5_min, S.P_Spec_33_and_5_comb,
                    S.P_Spec_minus_12_max_A, S.P_Spec_minus_12_min_A, S.P_Spec_5vsb_max_A, S.P_Spec_5vsb_min_A
                    FROM models M, specs_p S
                    WHERE M.Model_Internal = S.Model_Internal
                    AND M.PSU_Global = 'y'";

            break;
        case 'specs': //PSU_SPECS
            $query = "SELECT M.Model_Internal, S.P_Wattage_D, S.P_80_PLUS_D, S.P_Efficiency_Max_D, S.P_Warranty_D,
                    S.P_OEM_Name, P.Unit_Depth_mm, P.Unit_Weight_net_kg, SA.P_Input_D_voltage, SA.P_Input_D_frequency, S.P_Spec_12v_comb_W,
                    S.P_Rails_D, S.P_Spec_33_and_5_comb, S.P_Fan_Size_D, S.P_Fan_Bearing_D, (S.P_Connector_CPU_44_D + S.P_Connector_CPU_8_D) AS SUM_P_Connector_CPU_44_8, (S.P_Connector_PEG_6_D + S.P_Connector_PEG_62_D) AS SUM_P_Connector_PEG_6_62,
                    S.P_Connector_SATA_D, S.P_Connector_Molex_D, S.P_Cable_Lengths_G_screen
                    FROM models M, specs_p S, safety_p SA, packing P
                    WHERE M.Model_Internal = S.Model_Internal
                    AND M.Model_Internal = SA.Model_Internal
                    AND M.Model_Internal = P.Model_Internal
                    AND M.PSU_Support = 'y'";

            break;
        case 'upc': //PSU_UPC
            $query = "SELECT M.Model_Internal, S.UPC_AR_D, S.UPC_AUS_D, S.UPC_BR_D, S.UPC_CN_D, S.UPC_EC_D,
                    S.UPC_HK_D, S.UPC_I_D, S.UPC_IC_D, S.UPC_JD_D, S.UPC_JP_D,
                    S.UPC_KR_D, S.UPC_NC_D, S.UPC_SE_D, S.UPC_TW_D,
                    S.UPC_UK_D, S.UPC_US_D, S.UPC_ZA_D
                    FROM models M, upc S
                    WHERE M.Model_Internal = S.Model_Internal
                    AND M.PSU_Global = 'y'";

            break;

        case 'protections': //PSU_Protections
            $query = "SELECT P.* FROM models M, protections_p P
                        WHERE M.Model_Internal = P.Model_Internal
                        AND M.PSU_Support = 'y'";


            break;    

        default://PSU_SELECTOR
            $query = "SELECT M.Model_Internal, S.P_Wattage_D, S.P_80_PLUS_D, S.P_Warranty_D,
                    S.P_Efficiency_Max_D, P.Unit_Depth_mm, S.P_Coating_D, S.P_Rails_D, S.P_Spec_12v_comb_W, S.P_12V_Ratio_D, S.P_Spec_33_and_5_comb,
                    S.P_Fan_Size_D, S.P_Fan_Bearing_D, S.P_Cable_Lengths_G_screen, S.P_Connector_CPU_4_D, (S.P_Connector_CPU_44_D + S.P_Connector_CPU_8_D) AS SUM_P_Connector_CPU_44_8, (S.P_Connector_PEG_6_D + S.P_Connector_PEG_62_D) AS SUM_P_Connector_PEG_6_62,
                    S.P_Connector_SATA_D, S.P_Connector_Molex_D
                    FROM models M, specs_p S, packing P
                    WHERE M.Model_Internal = S.Model_Internal
                    AND M.Model_Internal = P.Model_Internal
                    AND M.PSU_$get_var[1] = 'y'";
                    $psu_selector = 1;

    }

}else{
    //echo "error";


}


$result = mysql_query( $query ) or die("Couldn't execute query.".mysql_error()); 
while($rows = mysql_fetch_array($result, MYSQL_ASSOC)){
         $data_array[] = $rows; 

}

function checkrow($row){
    if(empty($row)){    
        $row = '';
    }
    return $row;
}

class SimpleXMLExtended extends SimpleXMLElement {
  public function addCData($cdata_text) {
    $node = dom_import_simplexml($this); 
    $no   = $node->ownerDocument; 
    $node->appendChild($no->createCDATASection($cdata_text)); 
    } 
  }

  $xml = new SimpleXMLExtended('<?xml version="1.0" encoding="utf-8" ?><data />');

// the actual query for the grid data 

foreach ($data_array as $data ){

        if (is_array($data)) {
           
            $node_model = $xml->addChild('model');

            $node_model->addAttribute('value', ($psu_selector == 1 ? $data['Model_Name']: $data['Model_Internal']));
                foreach ($data as $key => $row){
                       
                        if( (stripos(substr($row, -4), ".psd") === false) 
                        && (stripos(substr($row, -4), ".jpg") === false) 
                        && (stripos(substr($row, -4), ".png") === false) 
                        && (stripos(substr($row, -4), ".gif") === false)
                        && (stripos(substr($row, -4), ".ind") === false)
                        && (stripos(substr($row, -3), ".ai") === false)
                        && (stripos(substr($row, -5), ".idml") === false)) {
                        //if (strpos($row, "file://") === false){
                            if($key=='Model_Internal' || $key=='Model_Name'){ 
                                $row = "<a href='http://www.antec.com/product/?lan=us&s=".$row."' target='_blank'>".$row."</a>"; 
                                $node_content = $node_model->addChild($key, NULL);
                                $node_content->addCData($row);
                            }else if($key=='P_Cable_Lengths_G_screen'){ 
                           // if($key=='Link'){
                                $row = "<a href='".$row."' target='_blank'>PDF</a>";                                        
                                $node_content = $node_model->addChild($key, NULL);
                                $node_content->addCData($row);
                            }else{
                                $row = checkrow($row);
                                $node_content = $node_model->addChild($key, NULL);
                                $node_content->addCData($row);                                
                            }
                        }else{
                            //$node_content = $node_model->addChild($key, $empty_string);
                            if(empty($row)){
                                //empty images do nothing
                            }else{
                                
                                $row = "<img src='thumbnails/".$row."' />";
                                $node_content = $node_model->addChild($key, NULL);
                                $node_content->addCData($row);
                            }
                        }
                            
                }// end foreach $data
                            
            }else{ //is_array data empty
               continue;   
           }            
    }//end foreach data_array

    header("Content-type: text/xml;charset=utf-8");
    echo $xml->asXML();
 

?>