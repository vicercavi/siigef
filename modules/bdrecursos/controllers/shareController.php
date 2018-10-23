<?php
class shareController extends bdrecursosController
{
	private $_share;

	public function __construct($lang, $url)
	{
		parent::__construct($lang, $url);
        $this->_bdrecursos = $this->loadModel('indexbd');
        $this->_import = $this->loadModel('import');
        $this->_estandar = $this->loadModel('index', 'estandar');  
        $this->_registro = $this->loadModel('registros', 'estandar');          
	}

	public function json($arg1 = '', $arg2 = '', $arg3 = '')
	{
		$recursos = $this->_bdrecursos->getRecursos("WHERE tir.Tir_IdTipoRecurso=1");

        $estandares = $this->_bdrecursos->getEstandar();

		if($arg1!='')
        {
        	ob_end_clean(); 
        	header('Content-type: application/json;');

        	$rss_titulo='SIIGEF';
	        $rss_url=BASE_URL;
	        $rss_descripcion="";	        
	        	
		    if($arg1 == 'recurso')
		    {
		    	echo json_encode($recursos);
		    }
		    else 
		    {
		    	$id_recurso = $this->filtrarInt($arg2);

		    	$recursos = $this->_bdrecursos->getRecursos("WHERE rec.Rec_IdRecurso=$id_recurso");

		    	$tipoEstandarRecurso = $recursos[0]['Esr_Tipo'];

		    	//$estandar = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$id_estandar");

		    	switch (str_replace(' ', '', strtolower($recursos[0]['Esr_Nombre']))) 
		        {
		            case 'calidaddeagua':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Mca_IdMonitoreoCalidadAgua DESC LIMIT 100");
			            
				        break;

		            case 'legislacion':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Mal_IdMatrizLegal DESC LIMIT 100");	                
		                
		                break;

		            case 'dublincore':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Dub_IdDublinCore DESC LIMIT 100");	
		                
		                break;

		            case 'darwincore':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Dar_IdDarwinCore DESC LIMIT 100");	
		                
		                break;

		            case 'pliniancore':
		                
		                $registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Pli_IdPlinian DESC LIMIT 100");	
		                
		                break;

		            default:

		            	$tipoEstandarRecurso = $recursos[0]['Esr_Tipo'];
		            	if($tipoEstandarRecurso==2)
		        		{
		        			$arg1 = 'variable_'.$arg1;
		        		}
		                $fichaEstandar = $this->_import->getFichaEstandar($recursos[0]['Esr_IdEstandarRecurso'], 'es');
		                $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Id";
        				$idTabla = $ini . str_replace(' ', '', ucwords(str_replace('_', ' ', $arg1))); 
        				$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY $idTabla DESC LIMIT 100");                           
		                
		        }     		
        		
        		echo json_encode($registros, true);
		    }
        }
        else
        {
        	$this->_acl->autenticado();
			$this->validarUrlIdioma();
			$this->_view->setTemplate(LAYOUT_FRONTEND);
	        $this->_view->getLenguaje("bdrecursos_metadata");
	        $this->_view->setJs(array('index'));
	        $this->_view->assign('titulo', 'Compartir datos RSS');

        	if ($this->botonPress("bt_generar_json"))
        	{
        		$id_estandar = $this->getPostParam('sl_estandar');
        		$id_recurso = $this->getPostParam('sl_recurso');	

        		$estandar = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$id_estandar");
        		
        		$nombre_tabla = $estandar[0]['Esr_NombreTabla'];

        		if($estandar[0]['Esr_Tipo']==2)
        		{
        			$nombre_tabla = str_replace('variable_', '', $nombre_tabla);
        		}

        		$this->_view->assign('link_json', '1');
        		$this->_view->assign('nombre_tabla', $nombre_tabla);
        		$this->_view->assign('id_recurso', $id_recurso);
        	}

        	$this->_view->assign('recursos', $recursos);
        	$this->_view->assign('estandares', $estandares);
        	$this->_view->renderizar('json','share');
        }  
	}

	public function rss($arg1 = '', $arg2 = '', $arg3 = '')
	{
		$recursos = $this->_bdrecursos->getRecursos("WHERE tir.Tir_IdTipoRecurso=1");

        $estandares = $this->_bdrecursos->getEstandar();

		if($arg1!='')
        {
        	ob_end_clean(); 
        	header('Content-type: application/rss+xml;');

        	$rss_titulo='SIIGEF';
	        $rss_url=BASE_URL;
	        $rss_descripcion="";
	       
	        echo '<?xml version="1.0" encoding="UTF-8"?>';
       		echo '<rss version="2.0">
       			<channel>
                <title>'.$rss_titulo.'</title>
                <link>'.$rss_url.'</link> 
                <description>'.$rss_descripcion.'</description>
                ';
				
		    if($arg1 == 'recurso')
		    {
		    	foreach ($recursos as $recurso) 
		        {
		        	echo '<item>';
		        	echo '<title><![CDATA['.$recurso['Rec_Nombre'].']]></title>';
		        	echo '<link><![CDATA['.BASE_URL.'bdrecursos/metadata/index/'.$recurso['Rec_IdRecurso'].']]></link>';
		        	echo '<category><![CDATA['.$recurso['Esr_Nombre'].']]></category>';
		        	echo '<description><![CDATA['.$recurso['Rec_Origen'].']]> | <![CDATA['.$recurso['Tir_Nombre'].']]></description>';
		        	//echo '<author><![CDATA['.$recurso['Rec_Fuente'].']]]></author>';
		        	echo '<guid>'.BASE_URL.'bdrecursos/metadata/index/'.$recurso['Rec_IdRecurso'].'</guid>';
		        	//echo '<pubDate>'.$recurso['Rec_UltimaModificacion'].'</pubDate>';
		        	echo '</item>';	        	
		        }
		    }
		    else 
		    {
		    	$id_recurso = $this->filtrarInt($arg2);

		    	$recursos = $this->_bdrecursos->getRecursos("WHERE rec.Rec_IdRecurso=$id_recurso");

		    	switch (str_replace(' ', '', strtolower($recursos[0]['Esr_Nombre']))) 
		        {
		            case 'calidaddeagua':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Mca_IdMonitoreoCalidadAgua DESC LIMIT 100");
			            $this->_mca = $this->loadModel('monitoreo', 'calidaddeagua');

			            foreach ($registros as $registro) 
				        {
				        	$monitoreo = $this->_mca->getMonitoreoCalidadAgua($registro['Mca_IdMonitoreoCalidadAgua']); 
				        	$fecha = date('d/m/Y', strtotime($monitoreo['Mca_Fecha']));

				        	echo '<item>';
				        	echo '<title><![CDATA['.$monitoreo['Var_Nombre'].']]></title>';
				        	echo '<link><![CDATA['.BASE_URL.'calidaddeagua/monitoreo/metadata/'.$registro['Mca_IdMonitoreoCalidadAgua'].']]></link>';
				        	echo '<category><![CDATA['.$monitoreo['Esm_Nombre'].']]></category>';
				        	echo '<description><![CDATA['.$monitoreo['Mca_Valor'].']]></description>';
				        	//echo '<author><![CDATA['.$recurso['Rec_Fuente'].']]></author>';
				        	echo '<guid>'.BASE_URL.'calidaddeagua/monitoreo/metadata/'.$registro['Mca_IdMonitoreoCalidadAgua'].'</guid>';
				        	//echo '<pubDate>'.$fecha.'</pubDate>';
				        	echo '</item>';	      	
				        }
				        break;

		            case 'legislacion':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Mal_IdMatrizLegal DESC LIMIT 100");	                
		                $this->_legislacion = $this->loadModel('legal', 'legislacion');

			            foreach ($registros as $registro) 
				        {
				     		$legislacion = $this->_legislacion->getLegislaciones("WHERE Mal_IdMatrizLegal = ".$registro['Mal_IdMatrizLegal']."", "es"); 

				        	$fecha = date('d/m/Y', strtotime($legislacion[0]['Mal_FechaPublicacion']));

				        	echo '<item>';
				        	echo '<title><![CDATA['.$legislacion[0]['Mal_Titulo'].']]></title>';
				        	echo '<link><![CDATA['.BASE_URL.'legislacion/legal/metadata/'.$registro['Mal_IdMatrizLegal'].']]></link>';
				        	echo '<category><![CDATA['.$legislacion[0]['Mal_Titulo'].']]></category>';
				        	echo '<description><![CDATA['.$legislacion[0]['Mal_ResumenLegislacion'].']]></description>';
				        	//echo '<author><![CDATA['.$legislacion[0]['Mal_Entidad'].']]></author>';
				        	echo '<guid>'.BASE_URL.'legislacion/legal/metadata/'.$registro['Mal_IdMatrizLegal'].'</guid>';
				        	//echo '<pubDate>'.$fecha.'</pubDate>';
				        	echo '</item>';	      	
				        }
		                break;

		            case 'dublincore':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Dub_IdDublinCore DESC LIMIT 100");	
		                $this->_dubllincore = $this->loadModel('dublin', 'dublincore');

			            foreach ($registros as $registro) 
				        {
				     		$dublincore = $this->_dubllincore->getDocumentos("WHERE dub.Dub_IdDublinCore = ".$registro['Dub_IdDublinCore'].""); 

				        	$fecha = date('d/m/Y', strtotime($dublincore[0]['Dub_FechaDocumento']));

				        	echo '<item>';
				        	echo '<title><![CDATA['.$dublincore[0]['Dub_Titulo'].']]></title>';
				        	echo '<link><![CDATA['.BASE_URL.'dublincore/documentos/metadata/'.$registro['Dub_IdDublinCore'].']]></link>';
				        	echo '<category><![CDATA['.$dublincore[0]['Ted_Descripcion'].']]></category>';
				        	echo '<description><![CDATA['.$dublincore[0]['Dub_Descripcion'].']]></description>';
				        	//echo '<author><![CDATA['.$dublincore[0]['Aut_Nombre'].']]></author>';
				        	//echo '<copyright><![CDATA['.$dublincore[0]['Dub_Derechos'].']]></copyright>';
				        	echo '<guid>'.BASE_URL.'dublincore/documentos/metadata/'.$registro['Dub_IdDublinCore'].'</guid>';
				        	//echo '<pubDate>'.$fecha.'</pubDate>';
				        	echo '</item>';	      	
				        }
		                break;

		            case 'darwincore':

		            	$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Dar_IdDarwinCore DESC LIMIT 100");	
		                $this->_darwincore = $this->loadModel('biodiversidad', true);

			            foreach ($registros as $registro) 
				        {
				     		$darwincore = $this->_darwincore->obtenerDarwinXid($registro['Dar_IdDarwinCore']);

				        	//$fecha = date('d/m/Y', strtotime($darwincore['Dub_FechaDocumento']));

				        	echo '<item>';
				        	echo '<title><![CDATA['.$darwincore['Dar_NombreComunOrganismo'].']]></title>';
				        	echo '<link><![CDATA['.BASE_URL.'biodiversidad/metadata/'.$registro['Dar_IdDarwinCore'].']]></link>';
				        	echo '<category><![CDATA['.$darwincore['Dar_EspecieOrganismo'].']]></category>';
				        	echo '<description><![CDATA['.$darwincore['Dar_FamiliaOrganismo'].']]></description>';
				        	//echo '<author><![CDATA['.$darwincore['Dar_AutorNombreCientifico'].']]></author>';
				        	//echo '<copyright><![CDATA['.$dublincore[0]['Dub_Derechos'].']]></copyright>';
				        	echo '<guid>'.BASE_URL.'biodiversidad/metadata/'.$registro['Dar_IdDarwinCore'].'</guid>';				        	
				        	echo '</item>';	      	
				        }
		                break;

		            case 'pliniancore':
		                
		                $registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, "ORDER BY Pli_IdPlinian DESC LIMIT 100");	
		                $this->_pliniancore = $this->loadModel('botanico', 'atlas');

			            foreach ($registros as $registro) 
				        {
				     		$pliniancore = $this->_pliniancore->getPlinianXId($registro['Pli_IdPlinian']);

				        	//$fecha = date('d/m/Y', strtotime($darwincore['Dub_FechaDocumento']));

				        	echo '<item>';
				        	echo '<title><![CDATA['.$pliniancore['Pli_NombresComunes'].']]></title>';
				        	echo '<link><![CDATA['.BASE_URL.'atlas/botanico/metadata/'.$registro['Pli_IdPlinian'].']]></link>';
				        	echo '<category><![CDATA['.$pliniancore['Pli_Clase'].']]></category>';
				        	echo '<description><![CDATA['.$pliniancore['Pli_DescripcionGeneral'].']]></description>';
				        	//echo '<author><![CDATA['.$pliniancore['Pli_AutorFechaTaxon'].']]></author>';
				        	//echo '<content><![CDATA['.$pliniancore['Pli_Usos'].']]></content>';
				        	echo '<guid>'.BASE_URL.'atlas/botanico/metadata/'.$registro['Pli_IdPlinian'].'</guid>';				        	
				        	echo '</item>';	      	
				        }
		                break;

		            default:

		            	$tipoEstandarRecurso = $recursos[0]['Esr_Tipo'];

		            	if($tipoEstandarRecurso==2)
		        		{
		        			$arg1 = 'variable_'.$arg1;
		        		}

		                $fichaEstandar = $this->_import->getFichaEstandar($recursos[0]['Esr_IdEstandarRecurso'], 'es');
		                $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Id";
        				$idTabla = $ini . str_replace(' ', '', ucwords(str_replace('_', ' ', $arg1))); 
        				$registros = $this->_bdrecursos->getRegistrosXRecurso($arg1, $id_recurso, " LIMIT 100");	
        				
		                $this->_registros = $this->loadModel('registros', 'estandar');

		                foreach ($registros as $registro) 
				        {				        	
				        	$lista = $this->_registros->getListaRegistrosEstandar($arg1, 'es', "AND $idTabla=".$registro[$idTabla]."");

				        	//$fecha = date('d/m/Y', strtotime($darwincore['Dub_FechaDocumento']));
				     		echo '<item>';
				        	echo '<title><![CDATA['.$lista[0][1].']]></title>';
				        	echo '<link><![CDATA['.BASE_URL.'bdrecursos/registros/metadata/'.$registro[$idTabla].']]></link>';
				        	echo '<description><![CDATA['.$lista[0][1].']]></description>';
				        	echo '<guid>'.BASE_URL.'bdrecursos/registros/metadata/'.$registro[$idTabla].'</guid>';				        	
				        	echo '</item>';	      	
				        }              
		                
		        }

		    }	        

	           //$this->_view->renderizar('index');
	        echo "</channel>";
	        echo "</rss>";    	
        }
        else
        {
        	$this->_acl->autenticado();
			$this->validarUrlIdioma();
			$this->_view->setTemplate(LAYOUT_FRONTEND);
	        $this->_view->getLenguaje("bdrecursos_metadata");
	        $this->_view->setJs(array('index'));
	        $this->_view->assign('titulo', 'Compartir datos RSS');

        	if ($this->botonPress("bt_generar_rss"))
        	{
        		$id_estandar = $this->getPostParam('sl_estandar');
        		$id_recurso = $this->getPostParam('sl_recurso');	

        		$estandar = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$id_estandar");
        		
        		$nombre_tabla = $estandar[0]['Esr_NombreTabla'];

        		if($estandar[0]['Esr_Tipo']==2)
        		{
        			$nombre_tabla = str_replace('variable_', '', $nombre_tabla);
        		}

        		$this->_view->assign('link_rss', '1');
        		$this->_view->assign('nombre_tabla', $nombre_tabla);
        		$this->_view->assign('id_recurso', $id_recurso);
        	}

        	$this->_view->assign('recursos', $recursos);
        	$this->_view->assign('estandares', $estandares);
        	$this->_view->renderizar('rss','share');
        }  
	}

	public function excel($nombre_tabla='', $subtema='', $Rec_IdRecurso=false)
	{
		$this->_acl->autenticado();
		$this->validarUrlIdioma();
		$this->_view->setTemplate(LAYOUT_FRONTEND);

		$Rec_IdRecurso = $this->filtrarInt($Rec_IdRecurso);

		$subtema = str_replace('_', ' ', $subtema);

		$dato_recurso = $this->_import->getRecurso($Rec_IdRecurso);

        $tabla_data = $dato_recurso[1];

        //error_reporting(0);
        $objPHPExcel = new PHPExcel();        

        $this->_share = $this->loadModel('share');

        $ficha = $this->_share->getColumnaTabla($nombre_tabla);     

        $ini = substr($ficha[0]['Fie_ColumnaTabla'],0,3);
        
        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre1)));
        $campo_subtema=$ini.'_Subtema';  

        $variable = $this->_share->getTablaVariable($nombre_tabla, $Rec_IdRecurso, "AND $campo_subtema='".$subtema."'"); 
        $data = $this->_share->getTablaData($tabla_data);
        	
    	for ($i = 0; $i < count($variable); $i++) 
        {
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, $variable[$i][2]);
        	$c=2;
        	for ($j = 0; $j < count($data); $j++) 
	        {			     
		        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $c, $data[$j][$variable[$i][1]]);	
    			$c++; 		           	
		    }		        			        	   
	    }
        
        $objPHPExcel->getActiveSheet()->setTitle('GEF-OTCA');

        $objPHPExcel->setActiveSheetIndex(0);

        ob_end_clean();
        ob_start();
        Session::destroy('Descargar');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="datos.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
        
    }

	public function _filtroRecursoXEstandar()
	{
		$id_estandar = $this->getPostParam('id_estandar');
		$recursos = $this->_bdrecursos->getRecursos("WHERE tir.Tir_IdTipoRecurso=1 and est.Esr_IdEstandarRecurso=$id_estandar");
		$this->_view->assign('recursos', $recursos);

		$this->_view->renderizar('ajax/lista_recurso', false, true);
	}

	public function mostrar_recursos()
	{		
		return $recursos;
	}
}
?>