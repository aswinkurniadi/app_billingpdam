<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF extends PDF_MC_Table{
      
      // Page header
    function Header(){
        if ($this->PageNo() == 1){
            $this->setFont('Arial','I',9);
            $this->setFillColor(255,255,255);
            $this->cell(90,6,'',0,0,'L',1); 
            $this->cell(100,6,"Printed date : " . date('d-M-Y'),0,1,'R',1); 
            $this->Line(10,$this->GetY(),200,$this->GetY());
        }else{
            $this->setFont('Arial','I',9);
            $this->setFillColor(255,255,255);
            $this->cell(90,6,"Laporan",0,0,'L',1); 
            $this->cell(100,6,"Printed date : " . date('d-M-Y'),0,1,'R',1); 
        }
    }

    function Content($repayment, $tglAwal, $tglAkhir, $menu, $colektor){
        if ($this->PageNo() == 1){
            $this->setFont('Arial','B',10);
            $this->setFillColor(255,255,255);
            $this->cell(0,6,'PDAM TIRTA PANGABUAN',0,1,'C',1); 
            $this->cell(0,6,'ALAMAT LENGKAP',0,1,'C',1); 
            $this->cell(0,6,'KECAMATAN AAAAAA, KABUPATEN AAAAAAA',0,1,'C',1); 
            $this->cell(0,6,'KODE POS : 00000 || 0000000000',0,1,'C',1); 
            $this->Ln(2);
            $this->SetLineWidth(1);
            $this->Line(10,$this->GetY(),200,$this->GetY());
            $this->SetLineWidth(0);

            // Line break
            $this->Ln(3);
            $this->setFont('Arial','B',12);
            $this->setFillColor(255,255,255);
            $this->cell(0,6,$menu,0,1,'C',1); 
            $this->cell(0,6,date("d/n/Y", strtotime($tglAwal)).' s/d '.date("d/n/Y", strtotime($tglAkhir)),0,1,'C',1); 

            $this->Ln(2);
            $this->setFont('Arial','B',9);
            $this->setFillColor(255,255,255);
            $this->cell(27,6,'Nama Kolektor',0,0,'L',1);
            $this->cell(3,6,':',0,0,'C',1);
            $this->cell(160,6,$colektor,0,1,'L',1);

            $this->setFont('Arial','B',9);
            $this->setFillColor(255,255,255);
            $this->cell(13,6,'No',1,0,'C',1);
            $this->cell(23,6,'Tanggal',1,0,'C',1);
            $this->cell(15,6,'ID',1,0,'C',1);
            $this->cell(30,6,'Cust',1,0,'C',1);
            $this->cell(59,6,'Alamat',1,0,'C',1);
            $this->cell(17,6,'Metode',1,0,'C',1);
            $this->cell(33,6,'Nominal',1,0,'C',1);

            //jika terdapat interface
            if($repayment)
            {
                $this->Ln();
                $this->setFont('Arial','',9);
                $this->SetWidths(Array(13,23,15,30,59,17,33));
                $this->SetAligns(Array('C','C','L','L','L','L','R'));
                $this->SetLineHeight(5);
                $i = 1;
                $total = 0;
                foreach ($repayment as $re) {
                    $this->Row(Array(
                        $i++,
                        date('d-m-Y', strtotime( $re['tgl'])),
                        $re['no_plng'],
                        $re['nm'],
                        $re['almt'],
                        $re['nm_kas'],
                        number_format($re['nilai'],0,',','.'),
                    ));
                    $total += $re['nilai'];
                }
                
                $this->setFont('Arial','B',9);
                $this->setFillColor(255,255,255);
                $this->cell(157,6,'Jumlah',1,0,'R',1);
                $this->cell(33,6,number_format($total,0,',','.'),1,0,'R',1);
                
            } else {
                $this->Ln();
                $this->setFont('Arial','',9);
                $this->cell(190,6,'Tidak Ada',1,1,'C',1);
            }
        }
    }
}
 
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle('['.$tglAwal.' sd '.$tglAkhir.'] Laporan Pelunasan '.$colektor,true);
$pdf->Content($repayment, $tglAwal, $tglAkhir, $menu, $colektor);
$pdf->Output('['.$tglAwal.' sd '.$tglAkhir.'] Laporan Pelunasan '.$colektor.'.pdf', 'I');

?>