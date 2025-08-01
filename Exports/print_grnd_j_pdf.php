<?php 
   $idpage = 9;
   include_once("../php/session_check.php");
   include_once("../php/function.php");

   require('../php/FPDF/fpdf.php');
    
    $param_query = "";
    
    $datarange = "";
    
    /*$pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World !');
    $pdf->Output();*/

    class export_pdf extends FPDF{
       
        function Header(){
            $img= "../images/logo2.jpg";
            //$this->Cell(5);
            $this->Image($img,10,6,50);
            $this->SetTextColor(255,0,0);
            $this->SetFont('Arial','B',7);
            $this->Image('../images/globe.png',60,30,150);
            $this->Ln(15);
           
            $this->Ln();
           // $this->SetLineWidth(0.5);
            
        }
        
       // Pied de page
        /*function Footer()
        {
            // Positionnement à 1,5 cm du bas
            
            // Numéro de page
            $this->SetY(-30);
            // Police Arial italique 8
            $this->SetFont('Arial','I',7);
            // Numéro de page
            $this->Cell(60,10,'CD/KNG/RCCM/18-B-01378',0,0,'L');$this->Cell(0,10,'Kinshasa: 8778, Av Wagenia, Kinshasa-Gombe, CTC Shopping Mall.',0,0,'R');
            $this->Ln(5);
            $this->Cell(0,10,'Id. Nat. : 01-9-N37238M',0,0,'L');$this->Cell(0,10,'+243 82 7000 755 / 85 0050 755',0,0,'R');
            $this->Ln(5);
            $this->Cell(0,10,'Numero Impot : A1820041E',0,0,'L');   $this->Cell(0,10,'Lubumbashi : 43, Av. Mwepu, Batiment Delbar (Centre-Ville).',0,0,'R');
            $this->Ln(5);
            
            $this->Cell(0,10,'@'.$_SESSION['my_username'],0,0,'L'); $this->Cell(0,10,'+243 82 6999 755 / 97 0639 702 ',0,0,'R');
             $this->Ln(5);
            $this->Cell(0,10,'info@passportsarl.voyage, www.passportsarl.voyage ',0,0,'R');   $this->Ln(5);
            
            
        }*/
        function enteteTable(){
            if(isset($_SESSION['daterange']) && !$_SESSION['daterange']== "")
            {

                $tempo=explode("-",$_SESSION['daterange']);
                $date_debut=trim($tempo[0]);
                $date_fin=trim($tempo[1]);
                
                $this->SetTextColor(255,0,0);
            $this->SetFont('Arial','B',7);
                 $this->Cell(0,6,'Architecte des voyages sur mesure',0,0,'R');
                 
                 $this->Ln(10);
                 $this->Line(7, 31, 290, 31);
                 $this->Ln(10);
                $this->setFont('Arial','BU',16);

                $this->SetTextColor(000);
                $this->Cell(205,6,'ETATS FINANCIERS: DU '.$date_debut.' AU '.$date_fin,0,0,'R');
                $this->Ln(5);
                //$this->Cell(30,15, "GRAND JOURNAL",0,0,'C');
                $this->setFont('Arial','',8);
                $this->setFillColor(80,80,80); 
                $this->SetTextColor(255,255,255);
                $this->SetLineWidth(.0);

                // En-tête
                $width = array(28,20, 65,  25, 45, 20,20,8, 30, 20);
                $header = array("DATE CREATION","AGENCE","OPERATIONS","TRANSACTIONS","COMPTE","ENTREES","SORTIES","$/Fc","SOLDE CDF","SOLDE USD");

                //$this->SetFont('Arial','B',9);
               
                $this->Ln();
                for($i=0;$i<count($header);$i++)
                $this->Cell($width[$i],7,$header[$i],1,0,'C',true);
                $this->Ln();
                

            }else{
                header('Location: ../grand_journal_dg.php');
            }
           
        }

        function vueDonnee($bdd){
            
            if(isset($_GET['print_pdf']) && $_GET['print_pdf'] == "valid" && !empty($_SESSION['_req']))
            {
                //$_POST= $date = date('m/d/Y');
                $limit=" ";
                $this->SetDrawColor(235,236,236);
                $this->SetTextColor(000);
                $this->SetFont('Times','',8);
               
                $stmt = $bdd->query("select t.*, t_livre_compte.label, identite, t_agence.label as agence from t_grand_journal t join t_livre_compte on (ref_compte=account_no and ref_agence_action=t_livre_compte.ref_agence) left join t_dossier on idt_dossier=ref_id_source join t_agence on ref_agence_action=id_agence ".$_SESSION['_req']." order by id_grand_journal ASC");

                $fill=false;
                while($data = $stmt->fetch(PDO::FETCH_OBJ))
                {


                    //$this->Image('../images/globe.png',10,20,200);
                    $this->SetFillColor(235,236,236);
                    $width_cell=array(10,30,40,40,30,30);
                    $this->Cell(28,6, $data->creationdate,1,0,'L',$fill);
                    $this->Cell(20,6, $data->agence,1,0,'L',$fill);
                    $this->Cell(65,6, $data->code_operation,1,0,'L',$fill);
                    $this->Cell(25,6, $data->ref_transaction,1,0,'L',$fill);
                    
                    $this->Cell(45,6, $data->ref_compte." ".$data->label,1,0,'L',$fill);
                    
                    
                    $this->Cell(20,6, $data->debit_action,1,0,'R',$fill);
                    $this->Cell(20,6, $data->credit_action,1,0,'R',$fill);
                    $this->Cell(8,6, ($data->ref_devise),1,0,'L',$fill);

                    $this->Cell(30,6, $data->solde_parent. " Fc",1,0,'R',$fill);
                    $this->Cell(20,6, round($data->solde_parent/$_SESSION['my_taux'],0)." $",1,0,'R',$fill);
                   
                    
                    
                    $this->Ln();

                    $fill = !$fill;

                }

           /* $this->Ln();
            $this->SetFont('Arial','I',7);
            // Numéro de page
            $this->Cell(60,10,'CD/KNG/RCCM/18-B-01378',0,0,'P');$this->Cell(0,10,'Kinshasa: 8778, Av Wagenia, Kinshasa-Gombe, CTC Shopping Mall.',0,0,'R');
            $this->Ln(5);
            $this->Cell(0,10,'Id. Nat. : 01-9-N37238M',0,0,'P');$this->Cell(0,10,'+243 82 7000 755 / 85 0050 755',0,0,'R');
            $this->Ln(5);
            $this->Cell(0,10,'Numero Impot : A1820041E',0,0,'P');   $this->Cell(0,10,'Lubumbashi : 43, Av. Mwepu, Batiment Delbar (Centre-Ville).',0,0,'R');
            $this->Ln(5);
            
            $this->Cell(0,10,'@'.$_SESSION['my_username'],0,0,'P');$this->Cell(0,10,'+243 82 6999 755 / 97 0639 702 ',0,0,'R');
             $this->Ln(5);
            $this->Cell(0,10,'info@passportsarl.voyage, www.passportsarl.voyage ',0,0,'R'); */

            }else{

                header('Location: ../grand_journal_dg.php');
            }
   
        }
       
       
        function  Footer(){

            $this->SetY(-20);
            // Police Arial italique 8
            $this->SetFont('Arial','I',6);
            // Numéro de page
            $this->Cell(0,10,'CD/KNG/RCCM/18-B-01378',0,0,'P');$this->Cell(0,10,'Kinshasa: 8778, Av Wagenia, Kinshasa-Gombe, CTC Shopping Mall.',0,0,'R');
            $this->Ln(2);
            $this->Cell(0,10,'Id. Nat. : 01-9-N37238M',0,0,'P');$this->Cell(0,10,'+243 82 7000 755 / 85 0050 755',0,0,'R');
            $this->Ln(2);
            $this->Cell(0,10,'Numero Impot : A1820041E',0,0,'P');   $this->Cell(0,10,'Lubumbashi : 43, Av. Mwepu, Batiment Delbar (Centre-Ville).',0,0,'R');
            $this->Ln(2);
            
            $this->Cell(0,10,'@'.$_SESSION['my_username'],0,0,'P');$this->Cell(0,10,'+243 82 6999 755 / 97 0639 702 ',0,0,'R');
             $this->Ln(2);
            $this->Cell(0,10,'info@passportsarl.voyage, www.passportsarl.voyage ',0,0,'R'); 
            $this->Ln(2);
            $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
           
        }

    
        
        
    }

   
    
    $pdf = new export_pdf();
    $pdf->AliasNbPages();
    $pdf->AddPage('L');
    $pdf->enteteTable();
    $pdf->vueDonnee($bdd);
   // $pdf->vueFooter();
    $pdf->Output('I','Etats_Financiers-'.$_SESSION['daterange'].'.pdf');
  
   
?>