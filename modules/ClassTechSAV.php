<?php
//  SOFIANE 20/01/2022
class TechSAV {
    // fonction d'affichage des mini formulaires 
    //  SOFIANE 20/01/2022
    public function showInitial($data){
        // echo "<div class='half-box'>";
        foreach($data as $dataRows){
            // echo "<div class='fold-container'>";
            echo "<H4 class='folder-title'>Dossier non traité </H4>";
            echo '<form action="" method="POST">'; 
            echo " <input type='text' name='getorhnum' class='form-fold' id='username' value='".$dataRows['OHR_ORDERNUMBER']."' readonly>" ;
            echo " <input type='text' name='getorhdate' class='form-fold' id='username' value='".$dataRows['OHR_DATE']."' readonly>" ;
            echo " <input type='text' name='getdiag' class='form-fold' id='username' value='".$dataRows['DSV_COM_DIAG_INITIAL']."' readonly>" ;
                echo " <input type='text' name='getsavid' class='form-fold hidden' id='username' value='".$dataRows['DSV_ID']."' readonly>";
                echo " <input type='text' name='gettdsid' class='form-fold hidden' id='username' value='".$dataRows['DSV_TDS_ID']."' readonly>";
                echo " <input type='text' name='getprdid' class='form-fold hidden' id='username' value='".$dataRows['DSV_PRD_ID']."' readonly>";
                echo " <input type='text' name='getorhid' class='form-fold hidden' id='username' value='".$dataRows['DSV_ORH_ID']."' readonly>";
                echo "<input type='submit' class='btn-submit' value='submit'><br/>";
            echo "</form>";
            // echo "</div>";
                
            // echo $data[''];            
                // DSV_TDS_ID   DSV_PRD_ID	DSV_ORH_ID
        }
        // echo "</div>";
    }
    // function d'affichage de la data des mini formulaire en classant les dossier SAV qui n'ont pas été traité
    //  SOFIANE 26/01/2022
    public function getNotTreated(){
        $sql = 'SELECT * FROM T_D_dossier_sav_DSV AS DSV
                JOIN type_dossier_tds as TDS on DSV.DSV_ID = TDS.TDS_ID
                JOIN t_d_product_prd as PRD on DSV.DSV_PRD_ID = PRD.PRD_ID
                JOIN t_d_orderheader_ohr AS OHR ON DSV.DSV_ORH_ID = OHR.OHR_ID
                 WHERE DSV.DSV_ETAT < 1 ORDER BY DSV.DSV_ID ASC';
        $db = Connector::getInstance();
        $query = $db->prepareQuery($sql);        
        $query->execute();
        $result = $query->fetchAll();
        return $this->showInitial($result);  
    }
    // function d'affichage ave details d'un dossier non traité allant de paire avec la function printFolders
    public function printSAVFolder($post){
        $db = Connector::getInstance();

        $savID = intVal($post['getsavid'], 10); 
        // $tdsID = $post['gettdsid'];
        // $prdID = $post['getprdid'];
        // $orhID = $post['getorhid'];

        // $sql = 'SELECT * from t_d_dossier_sav_dsv as DSV
        // JOIN type_dossier_tds as TDS on DSV.DSV_ID = TDS.TDS_ID
        // JOIN t_d_product_prd as PRD on DSV.DSV_PRD_ID = PRD.PRD_ID
        // JOIN t_d_orderheader_ohr AS OHR ON DSV.DSV_ORH_ID = OHR.OHR_ID';

        $query = $db->prepareQuery('SELECT * from t_d_dossier_sav_dsv as DSV
                                    JOIN type_dossier_tds as TDS on DSV.DSV_ID = TDS.TDS_ID
                                    JOIN t_d_product_prd as PRD on DSV.DSV_PRD_ID = PRD.PRD_ID
                                    JOIN t_d_orderheader_ohr AS OHR ON DSV.DSV_ORH_ID = OHR.OHR_ID
                                    WHERE DSV.DSV_ID = ?');

        $query->bindValue(1, $savID, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();
        return $this->printFolders($result);


    }
    // function d'imprimerie du code HTML
    //  SOFIANE 26/01/2022
    public function printFolders($data){
                // print sizeof($data);
                foreach($data as $datas){
                    echo "<div class='dos-container'>";
                    echo "<H3 class='legend-title'>DOSSIER NUMERO: ".$datas['OHR_ORDERNUMBER']."</h3><br/>";
                    // if($datas[''] --- TO DO
                    echo "<p class='folder-info'> COMMENTAIRE INITIAL: ".$datas['DSV_COM_DIAG_INITIAL']."</p><br/>";
                    // faire un form pour update le dossier --TO DO--
                    echo "<p class='folder-info'> COMMENTAIRE FINAL: ".$datas['DSV_COM_DIAG_TERM']."</p><br/>";
                    echo "<p class='folder-info'> TYPE DE DOSSIER: ".$datas['TDS_TYPE']."</p><br/>";
                    echo "<p class='folder-info'> REFERENCE PRODUIT: ".$datas['PRD_REFERENCE']."</p><br/>";
                    echo "<p class='folder-info'> FOURNISSEUR PRODUIT: ".$datas['PRD_SUPPLIER']."</p><br/>";
                    echo "<p class='folder-info'> DESIGNATION PRODUIT: ".$datas['PRD_DESIGNATION']."</p><br/>";
                    echo "<p class='folder-info'> FAMILLE DU PRODUIT: ".$datas['PRD_FAMILY']."</p><br/>";
                    echo "<p class='folder-info'> DESCRIPTION DU PRODUIT: ".$datas['PRD_FAMILY']."</p><br/>";
                    echo "<p class='folder-info'> GARANTIE: ".$datas['PRD_GUARANTEE']."</p><br/>";
                    echo "<p class='folder-info'> IMAGE DU PRODUIT: ".$datas['PRD_IMAGE_URL']."</p><br/>";
                    echo "<p class='folder-info'> DATE DE COMMANDE: ".$datas['OHR_DATE']."</p><br/>";
                    echo "<p class='folder-info'> NUMERO DE COMMANDE: ".$datas['OHR_ORDERNUMBER']."</p><br/>";
                    echo "<p class='folder-info'> NUMERO DE TELEPHONE DU CLIENT: ".$datas['OHR_DELIVERYPHONE']."</p><br/>";
                    echo "</div";
                }
                // echo "</table>";
    }
    // function pour aller rechercher les dossiers par type
    // SOFIANE 20/01/2022
    public function searchByType($post){
        $db = Connector::getInstance();        
        $query = $db->prepareQuery('SELECT * from t_d_dossier_sav_dsv as DSV
                                    JOIN type_dossier_tds as TDS on DSV.DSV_ID = TDS.TDS_ID
                                    JOIN t_d_product_prd as PRD on DSV.DSV_PRD_ID = PRD.PRD_ID
                                    JOIN t_d_orderheader_ohr AS OHR ON DSV.DSV_ORH_ID = OHR.OHR_ID
                                    WHERE TDS.TDS_ID = ?'); 
        $val = intVal($post['foldertype'], 10);        
        $query->bindValue(1, $val, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();

        return $this->printFolders($result);
    
    }
    // function de recherche avec possibilité d'avoir plusieurs arguments de recherche
    public function searchForMe($post){
        $db = Connector::getInstance();
            $stack = array();
            if(!empty($post['searchtype'])){
                $val = intVal($post['searchtype'], 10);
                $first = " TDS.TDS_ID LIKE ".$val;
                array_push($stack, $first);
            }
            if(!empty($post['searchord'])){                
                $second = " OHR.OHR_ORDERNUMBER LIKE ".$post['searchord']."%";
                array_push($stack, $second);
            }
            if(!empty($post['searchdate'])){ 
                $date = $post['searchdate'];
                // $date = explode("-", $post['searchdate']);
                // $year = $date[0];
                // $month = $date[1];
                // $day = $date[2];          
                $third = " OHR.OHR_DATE LIKE "."'".$date."%'";
                // DATE_FORMAT("2018-09-24", "%d/%m/%Y")
                array_push($stack, $third);
            }
            if(!empty($post['searchprod'])){                
                $fourth = " PRD.PRD_DESIGNATION LIKE "."'%".$post['searchprod']."%'";
                array_push($stack, $fourth);
            }
            $count = sizeOf($stack);
            $sqlBind = "";
            if($count == 1){
                if (DateTime::createFromFormat('Y-m-d', $sqlBind) !== false) {
                    $sqlBind = DateTime::createFromFormat('Y-m-d', $sqlBind);
                    // DateTime::createFromFormat('Y-m-d H:i:s', $myString)
                }
                elseif(is_numeric($stack[0])){               
                $sqlBind = intVal($stack[0], 10);
                } else {
                $sqlBind = $stack[0];
                }
            }
            if($count > 1){
                $sqlBind = implode(" OR ", $stack);
            }


            $sql = 'SELECT * from t_d_dossier_sav_dsv as DSV
                        JOIN type_dossier_tds as TDS on DSV.DSV_ID = TDS.TDS_ID
                        JOIN t_d_product_prd as PRD on DSV.DSV_PRD_ID = PRD.PRD_ID
                        JOIN t_d_orderheader_ohr AS OHR ON DSV.DSV_ORH_ID = OHR.OHR_ID
                        JOIN t_d_orderdetail_odt AS ODT ON ODT.ODT_OHR_ID = OHR.OHR_ID
                    WHERE'."$sqlBind";
            $query = $db->prepareQuery($sql);
            $query->execute();
            $result = $query->fetchAll();
            $count = $query->rowCount();
            if($count > 0){
                return $this->printFolders($result);
                // return var_dump($sql);
            }else{
                echo "<p class='warning'>aucun resultats trouvé.</p>";
            }
        
    }


}

?>