<?php
$idpage = 46;
include_once("php/session_check.php");
include_once("php/function.php");
include_once("param.php");
require('php/FPDF/fpdf.php');

class PDF extends FPDF
{
    /*private $charroi;
    private $plaque_bus;
    private $marque_bus;
    private $couleur_bus;*/
    

    /*function setVar($charroi_in,$plaque_bus_in,$marque_bus_in,$couleur_bus_in){
        $this->charroi = $charroi_in;
        $this->plaque_bus = $plaque_bus_in;
        $this->marque_bus = $marque_bus_in;
        $this->couleur_bus = $couleur_bus_in;
        
     }*/
// En-tête
function Header()
{
    // Logo
    $this->Cell(5);
    $this->Image('images/logo2.jpg',10,6,50);
    $this->SetFont('Arial','B',7);$this->Ln(15);
    $this->Cell(110);$this->Cell(80,6,'Architecte des voyages sur mesure',0,0,'R');$this->Ln(2);
    $this->SetLineWidth(0.5);
    $this->Line(8, 31, 200, 31);
    //$this->Cell(10,10,'---------------------------------------------------------------------------------------------------------------------------------------',0,0,'C');
	// Police Arial gras 15
	
    // Décalage à droite
    $this->Ln(10);
    
   
    
    
	// Titre
	
	// Saut de ligne
	$this->Ln(20);
}

// Pied de page
function Footer()
{
	// Positionnement à 1,5 cm du bas
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
    
    $this->Cell(0,10,'@'.$_SESSION['my_username'],0,0,'L');$this->Cell(0,10,'+243 82 6999 755 / 97 0639 702 ',0,0,'R');
     $this->Ln(5);
    $this->Cell(0,10,'info@passportsarl.voyage, www.passportsarl.voyage ',0,0,'R');   $this->Ln(5);

    
    
}


function FancyTable($header, $data)
{
	// Couleurs, épaisseur du trait et police grasse
	$this->SetFillColor(72,108,250);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
    $this->SetFont('','B',9.5);
    //$this->SetFont('Arial','B',12);
	// En-tête
    $w = array(10, 90,40, 30);
	for($i=0;$i<count($header);$i++){
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
    }
	$this->Ln();
	// Restauration des couleurs et de la police
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	// Données
	$fill = false;
	while($row=mysqli_fetch_array($data))
	{
		$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		
        $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
        
               $this->Ln();
        
        $fill = !$fill;
        
        
	}
	// Trait de terminaison
	$this->Cell(array_sum($w),0,'','T');
}


}


if(isset($_GET['print_pdf']) && $_GET['print_pdf']=='ok' && clean_in_integer($_GET['idt_all'])>0){
    $idt_transaction=clean_in_integer($_GET['idt_all']);
    $data_transaction=get_transaction_data($idt_transaction);
    // Instanciation de la classe dérivée
    
    if($data_transaction['is_exist']==1){
        $data_set=get_transaction_data_for_print($idt_transaction);
        //$data_voyage=get_voyage_data_full($idt_voyage);

        //echo $data_voyage['nom_charroi'];
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','BU',15);
        $pdf->Cell(90);
        $pdf->Image('images/globe.png',6,60,200);
        $pdf->Cell(30,10,'FACTURE : '.$data_transaction['code_transaction'],0,0,'C');
        $pdf->Ln(10);
        $pdf->Ln(40);
        $pdf->SetFont('Times','',12);
        $header=array("N","OPERATION","MONTANT","DEVISE");
        
        $pdf->FancyTable($header,$data_set);
        $pdf->Ln(5);
        $pdf->Cell('',10,'LIBELLE : '.$data_transaction['sup_detail'],0,0,'L');
        $pdf->Ln(20);
        $pdf->Cell('',10,'Fait a Kinshasa, le '.date("d-m-Y"),0,0,'R');
        $pdf->Ln(10); $pdf->Ln(10);
        $pdf->SetFont('Arial','BUI',13);
        //$pdf->Cell(20,10,'AGENCE : ',0,0,'L');$pdf->Cell(110);$pdf->Cell(50,10,'GERANT BUS',0,0,'R');
        
        
        $pdf->Output('I','Fact-'.$data_transaction['code_transaction'].'.pdf');
        

    }



}







?>