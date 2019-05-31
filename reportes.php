<?php 

	//IMPORTANTE PARA QUE NO SE FRIEGUE EL EXCEL

	ob_start();

	//require 'generarreporte.php';

	require 'Classes/PHPExcel.php';

	require 'fpdf/fpdf.php';

	session_start();



if (!isset($_SESSION['idUsuario'])) {

	header('Location: index.php');

} 



/*var descarga=false;

if(!isset($_GET['Ancho']) && !isset($_GET['Alto']) )

{

echo "<script language=\"JavaScript\">

<!-- 

document.location=\"$PHP_SELF?Ancho=\"+screen.width+\"&Alto=\"+screen.height;

//-->

</script>";

}

else {

if(isset($_GET['Ancho']) && isset($_GET['Alto'])) {

// Resoluci�n de pantalla detectada

if($_GET['Ancho']>800) {

 //// error en la detecci�n de resoluci�n de pantalla

 descarga=true;

 }else{

     descarga=false;

 }

}

}*/



	$idUsuario = $_SESSION['idUsuario'];

	$conexion = '';

	try{

		$conexion = new PDO('mysql:host=localhost;dbname=gastos_bd','root','');

	} catch (PDOException $e){

		echo "Error" . $e->getMessage();

		die();

	}

	$monedaSelec = 'USD';

	$MYMFechaGasto = $conexion->prepare("SELECT MIN(dia) as diaMin,MAX(dia) as diaMax FROM gastos WHERE idUsuario = :idUsuario" );

	$MYMFechaGasto->execute(array(

			':idUsuario' => $idUsuario,

	));

	$MYMFechaGasto=$MYMFechaGasto->fetch();

	/*Para que no esten vacias las variables*/

	$MYMFechaGasto['diaMin'] = $MYMFechaGasto['diaMin'] ? $MYMFechaGasto['diaMin'] : '99/99/9999';

	$MYMFechaGasto['diaMax'] = $MYMFechaGasto['diaMax'] ? $MYMFechaGasto['diaMax'] : '00/00/0000';



	$MYMFechaIngreso = $conexion->prepare("SELECT MIN(dia) as diaMin,MAX(dia) as diaMax FROM ingresos WHERE idUsuario = :idUsuario" );

	$MYMFechaIngreso->execute(array(

			':idUsuario' => $idUsuario,

	));

	$MYMFechaIngreso=$MYMFechaIngreso->fetch();

	/*Para que no esten vacias las variables*/

	$MYMFechaIngreso['diaMin'] = $MYMFechaIngreso['diaMin'] ? $MYMFechaIngreso['diaMin'] : '99/99/9999';

	$MYMFechaIngreso['diaMax'] = $MYMFechaIngreso['diaMax'] ? $MYMFechaIngreso['diaMax'] : '00/00/0000';



	$fechaDesde = min($MYMFechaGasto['diaMin'],$MYMFechaIngreso['diaMin']);

	$fechaHasta = max($MYMFechaGasto['diaMax'],$MYMFechaIngreso['diaMax']);



	$listaMonedas = $conexion->prepare("SELECT tipoDeCambio,codMoneda,nombreMoneda FROM monedas ORDER BY codMoneda");

	$listaMonedas->execute();

	$listaMonedas = $listaMonedas->fetchAll();



	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		//echo 'HAGOREPORTE';

		$fechaDesde = $_POST['fechaDesde'];

		$fechaHasta = $_POST['fechaHasta'];

		$monedaSelec = $_POST['moneda'];



		$factor = $conexion->prepare("SELECT tipoDeCambio FROM monedas WHERE codMoneda = :codMoneda");

		$factor->execute(array(

				':codMoneda' => $monedaSelec

		));

		$factor=$factor->fetch();

		$factor = $factor['tipoDeCambio'];



		$listaGastos =$conexion->prepare("SELECT dia,codMoneda, nombreMoneda, nombreCatGasto as categoria, monto, nota FROM (gastos NATURAL JOIN monedas) NATURAL JOIN categoriagasto WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta ORDER BY dia");

		$listaGastos->execute(array(

				':idUsuario' => $idUsuario,

				':fechaDesde' => $fechaDesde,

				':fechaHasta' => $fechaHasta,

		));

		$listaGastos=$listaGastos->fetchAll();



		$gastosAgrupados =$conexion->prepare("SELECT nombreCatGasto AS categoria, SUM(monto*tipoDeCambio/:factor) AS MontoEst FROM (gastos NATURAL JOIN monedas) NATURAL JOIN categoriagasto WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta GROUP BY idCatGasto");

		$gastosAgrupados->execute(array(

				':factor' => $factor,

				':idUsuario' => $idUsuario,

				':fechaDesde' => $fechaDesde,

				':fechaHasta' => $fechaHasta,

		));

		$gastosAgrupados=$gastosAgrupados->fetchAll();



		$listaIngresos =$conexion->prepare("SELECT dia,codMoneda, nombreMoneda, nombreCatIngreso as categoria, monto, nota FROM (ingresos NATURAL JOIN monedas) NATURAL JOIN categoriaingreso WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta ORDER BY dia");

		$listaIngresos->execute(array(

				':idUsuario' => $idUsuario,

				':fechaDesde' => $fechaDesde,

				':fechaHasta' => $fechaHasta,

		));

		$listaIngresos=$listaIngresos->fetchAll();



		$ingresosAgrupados =$conexion->prepare("SELECT nombreCatIngreso AS categoria, SUM(monto*tipoDeCambio/:factor) AS MontoEst FROM (ingresos NATURAL JOIN monedas) NATURAL JOIN categoriaingreso WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta GROUP BY idCatIngreso");

		$ingresosAgrupados->execute(array(

				':factor' => $factor,

				':idUsuario' => $idUsuario,

				':fechaDesde' => $fechaDesde,

				':fechaHasta' => $fechaHasta,

		));

		$ingresosAgrupados=$ingresosAgrupados->fetchAll();

		//----DEFINIR CUAL SE VA A USAR

		$tipo = $_POST['id'];

		if($tipo  == 'Generar EXCEL'){

			generarReporteExcel($listaGastos,$gastosAgrupados,$listaIngresos,$ingresosAgrupados,$monedaSelec);

		}



		if($tipo  == 'Generar PDF'){

			class myPDF extends FPDF{

				function header(){

					$this->Ln();

					$this->Image('imagenes/gasto.png',20,6);

					$this->SetFont('Arial','B',22);

					$this->Cell(280,5,'REPORTE DE GASTOS E INGRESOS',0,0,'C');

					$this->Ln();

					$this->SetFont('Times','',14);

					$this->Cell(276,15,'Facultad de Ingenieria de Sistemas e Inform�tica',0,0,'C');

					$this->Ln();

				}

				function headerGastos(){

					$this->Ln();

					$this->Image('imagenes/gasto.png',20,6);

					$this->SetFont('Arial','B',16	);

					$this->Cell(276,5,'TABLA DE GASTOS',0,0,'C');

					$this->Ln();

					$this->SetFont('Times','',14);

					$this->Ln();

				}

				function headerIngresos(){

					$this->Ln();

					$this->SetFont('Arial','B',16	);

					$this->Cell(276,5,'TABLA DE INGRESOS',0,0,'C');

					$this->Ln();

					$this->SetFont('Times','',14);

					$this->Ln();

				}

				function footer(){

					$this->SetY(-15);

					$this->SetFont('Arial','',8);

					$this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C' );

				}

				function headerTable(){

					$this->SetFont('Times','B',12);

					$this->Cell(40,10,'Fecha',1,0,'C');

					$this->Cell(50,10,'Categoria',1,0,'C');

					$this->Cell(50,10,'Codigo moneda',1,0,'C');

					$this->Cell(60,10,'Moneda',1,0,'C');

					$this->Cell(40,10,'Monto',1,0,'C');

					$this->Cell(38,10,'Nota',1,0,'C');

					$this->Ln();

				}

				function viewTable($listaTotal){

					$this->SetFont('Times','',12);

					foreach ($listaTotal as $lista) {

						$this->Cell(40,10,$lista['dia'],1,0,'C');

						$this->Cell(50,10,$lista['categoria'],1,0,'L');

						$this->Cell(50,10,$lista['codMoneda'],1,0,'L');

						$this->Cell(60,10,$lista['nombreMoneda'],1,0,'L');

						$this->Cell(40,10,$lista['monto'],1,0,'L');

						$this->Cell(38,10,$lista['nota'],1,0,'L');

						$this->Ln();

					}

				}

                function headerPorCategoria($tipo){

                    $this->Ln();

    				$this->SetFont('Arial','B',16	);

					$this->Cell(276,5,"TABLA DE $tipo POR CATEGORIA",0,0,'C');

					$this->Ln();

					$this->SetFont('Times','',14);

					$this->Ln();

                }

                function headerTablePorCategoria($tipo){

                    $this->SetFont('Times','B',12);

					$this->Cell(50,10,'Categoria',1,0,'C');

					$this->Cell(50,10,"Monto en $tipo",1,0,'C');

					$this->Ln();

                }

                function viewTablePorCategoria($listaTotal){

    				$this->SetFont('Times','',12);

					foreach ($listaTotal as $lista) {

						$this->Cell(50,10,$lista['categoria'],1,0,'L');

						$this->Cell(50,10,$lista['MontoEst'],1,0,'L');

						$this->Ln();

					}

				}

			}

			$pdf=new myPDF();

			$pdf->AliasNbPages();

			$pdf->AddPage('L','A4',0);

			$pdf->headerGastos();

			$pdf->headerTable();

			$pdf->viewTable($listaGastos);

			$pdf->headerIngresos();

			$pdf->headerTable();

			$pdf->viewTable($listaIngresos);

            $pdf->headerPorCategoria('GASTOS');

    		$pdf->headerTablePorCategoria($monedaSelec);

    		$pdf->viewTablePorCategoria($gastosAgrupados);

            $pdf->headerPorCategoria('INGRESOS');

        	$pdf->headerTablePorCategoria($monedaSelec);

    		$pdf->viewTablePorCategoria($ingresosAgrupados);

			$pdf->Output();

            /*if(descarga=true){

                $pdf->Output('D');

            }else{

                $pdf->Output();

            }*/



				

			

		}

		



	}



	function generarReporteExcel($listaGastos,$gastosAgrupados,$listaIngresos,$ingresosAgrupados, $codMoneda){

		$objPHPExcel  = new PHPExcel();

		generarHojaExcel($objPHPExcel,$listaGastos,$gastosAgrupados,$codMoneda,0,'Gastos');

		$objPHPExcel->createSheet();

		generarHojaExcel($objPHPExcel,$listaIngresos,$ingresosAgrupados,$codMoneda,1,'Ingresos');

		$objPHPExcel->setActiveSheetIndex(0);



		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		header('Content-Disposition: attachment;filename="Reporte de Gastos e Ingresos.xls"');

		header('Cache-Control: max-age=0');



		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$writer->setIncludeCharts(TRUE);

		// incluir gráfico

		$writer->save('php://output');





	}



	function generarHojaExcel($objPHPExcel,$listaTotal, $listaAgrupada, $codMoneda, $activeIndex, $titulo ){

		//generarExcel($gastosArticulos);

		//Establecemos en que fila inciara a imprimir los datos

		$fila = 9;

		//Objeto de PHPExcel

		

		//Propiedades de Documento

		$objPHPExcel->getProperties()->setCreator("Marko robles")->setDescription("Reporte de gastos e ingresos");



		//Establecemos la pestaña activa y nombre a la pestaña

		$objPHPExcel->setActiveSheetIndex($activeIndex);

		$objPHPExcel->getActiveSheet()->setTitle($titulo);



		$estiloTituloReporte = array(

		    'font' => array(

				'name'      => 'Arial',

				'bold'      => true,

				'italic'    => false,

				'strike'    => false,

				'size' =>13

		    ),

		    'fill' => array(

				'type'  => PHPExcel_Style_Fill::FILL_SOLID

			),

		    'borders' => array(

				'allborders' => array(

					'style' => PHPExcel_Style_Border::BORDER_NONE

				)

		    ),

		    'alignment' => array(

				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER

		    )

		);



		$estiloSubtitulo = array(

		    'font' => array(

				'name'      => 'Arial',

				'bold'      => true,

				'italic'    => false,

				'strike'    => false,

				'size' =>12

		    ),

		    'fill' => array(

				'type'  => PHPExcel_Style_Fill::FILL_SOLID

			),

		    'borders' => array(

				'allborders' => array(

					'style' => PHPExcel_Style_Border::BORDER_NONE

				)

		    ),

		    'alignment' => array(

				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER

		    )

		);

		

		$estiloTituloColumnas = array(

		    'font' => array(

				'name'  => 'Arial',

				'bold'  => true,

				'size' =>10,

				'color' => array(

				'rgb' => 'FFFFFF'

			)

		    ),

		    'fill' => array(

			'type' => PHPExcel_Style_Fill::FILL_SOLID,

			'color' => array('rgb' => '538DD5')

		    ),

		    'borders' => array(

			'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN

			)

		    ),

		    'alignment' =>  array(

			'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

			'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER

		    )

		);

		

		$estiloInformacion = new PHPExcel_Style();

		$estiloInformacion->applyFromArray( array(

		    'font' => array(

			'name'  => 'Arial',

			'color' => array(

			'rgb' => '000000'

			)

		    ),

		    'fill' => array(

			'type'  => PHPExcel_Style_Fill::FILL_SOLID

			),

		    'borders' => array(

			'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN

			)

		    ),

			'alignment' =>  array(

			'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

			'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER

		    )

		));

		

		$objPHPExcel->getActiveSheet()->getStyle('A1:F4')->applyFromArray($estiloTituloReporte);

		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->applyFromArray($estiloSubtitulo);

		$objPHPExcel->getActiveSheet()->getStyle('A8:F8')->applyFromArray($estiloTituloColumnas);

		

		$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Reporte de '.$titulo);

		$objPHPExcel->getActiveSheet()->mergeCells('B3:E3');

		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Lista completa de '.$titulo);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:C6');

		



		for($i = 'A'; $i <= 'F'; $i++){

 	   		$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);

		}

		//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);

		$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Fecha');

		//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

		$objPHPExcel->getActiveSheet()->setCellValue('B8', 'Categoria');

		//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		$objPHPExcel->getActiveSheet()->setCellValue('C8', 'Codigo moneda');

		//$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

		$objPHPExcel->getActiveSheet()->setCellValue('D8', 'Moneda');

		//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);

		$objPHPExcel->getActiveSheet()->setCellValue('E8', 'Monto');

		//$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);

		$objPHPExcel->getActiveSheet()->setCellValue('F8', 'Nota');



		//Recorremos los resultados de la consulta y los imprimimos

		for ($i=0; $i < count($listaTotal ); $i++) { 

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $listaTotal[$i]['dia']);

			$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $listaTotal[$i]['categoria']);

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $listaTotal[$i]['codMoneda']);

			$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $listaTotal[$i]['nombreMoneda']);

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $listaTotal[$i]['monto']);

			$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $listaTotal[$i]['nota']);

			$fila = $fila+1;

		}



		$fila = $fila-1;

	

		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A9:F".$fila);



		//Lista agrupada

		$fila = $fila+2;



		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':F'.$fila)->applyFromArray($estiloSubtitulo);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $titulo.' por categoria');

		$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':C'.$fila);



		$fila += 2;



		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':B'.$fila)->applyFromArray($estiloTituloColumnas);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'Categoria');

		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, 'Monto en '.$codMoneda);

		

		$fila++;

		$temp = $fila;

		for ($i=0; $i < count($listaAgrupada ); $i++, $fila++) { 

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $listaAgrupada[$i]['categoria']);

			$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $listaAgrupada[$i]['MontoEst']);

		}

		$fila = $fila-1;

	

		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, 'A'.$temp.':B'.$fila);



		$filaGrafica = $fila + 3;

		// definir origen de los valores

		$values = new PHPExcel_Chart_DataSeriesValues('Number', $titulo.'!$B'.$temp.':$B$'.$fila);

		

		// definir origen de los rotulos

		$categories = new PHPExcel_Chart_DataSeriesValues('String', $titulo.'!$A'.$temp.':$A$'.$fila);

		

		

		// definir  gráfico

		$series = new PHPExcel_Chart_DataSeries(

		PHPExcel_Chart_DataSeries::TYPE_PIECHART, // tipo de gráfico

		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,

		range(0, count($values)-1),

		array($categories),

		array($categories), // rótulos das columnas

		array($values) // valores

		);

		

		//$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		

		// inicializar gráfico

		$layout = new PHPExcel_Chart_Layout();

		$layout->setShowVal(TRUE);

		$layout->setShowPercent(TRUE);

		

		$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));

		$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

		

		// definir título do gráfico

		$title = new PHPExcel_Chart_Title(null, $layout);

		$title->setCaption('Gráfico PHPExcel Chart Class');



		$chart = new PHPExcel_Chart(

			'chart',		// name

			$title,		// title

			$legend,		// legend

			$plotarea,		// plotArea

			true,			// plotVisibleOnly

			0,				// displayBlanksAs

			null,			// xAxisLabel

			null			// yAxisLabel		- Pie charts don't have a Y-Axis

		);



		

		// definir posiciondo gráfico y título

		$chart->setTopLeftPosition('B'.$filaGrafica);

		$filaFinal = $filaGrafica + 10;

		$chart->setBottomRightPosition('E'.$filaFinal);

		

		// adicionar o gráfico à folha

		$objPHPExcel->getActiveSheet()->addChart($chart);

		

		



	}

require 'views/reportes.view.php';



?>