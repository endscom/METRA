<?php 
header("Content-type: application/octect-stream");
header("Content-Disposition: attachment; filename=Analisis_de_consumo.xls");
header("pragma: no-cache");
header("Expires: 0");
?>
 <div id= "MyBar" class="progress green" style="Display:none;">
  <div class="indeterminate blue"></div>
</div>
<h5 class="center" style="font-family:'robotoblack'; color:#616161"><br>ANÁLISIS DE CONSUMO</h5>
<div class="row">
  <div class="col s12">
   <div class="row center">

  </div>
  <div style="overflow-x:auto;">
    <table id = "tbArticulos" class="tableizer-table responsive-table"  width="100%">
      <thead>
       <tr>
         <th>ARTICULO</th>
         <th>DESCRIPCION</th>
         <th>LABORATORIO</th>
         <th>UNIDAD</th>
         <th>PROVEEDOR</th>
         <th>EXISTENCIAS</th>
         <th>PROMEDIO TRES MÁS ALTOS</th>
         <th>PENDIENTE CRUZ AZUL</th>
         <th>CONSUMO CRUZ AZUL</th>
         <th>CANTIDAD BAJO PEDIDO</th>
         <th>CANTIDAD EN TRANSITO</th>             
         <th>MESES DE EXISTENCIA POR PROMEDIO DE TRES MAS ALTOS</th>
         <th>CONTRATO ANUAL</th>
         <th>PENDIENTES INST-PUB</th>
         <th>CANT DOCE MESES CRUZ AZUL</th>
         <th>CUMPLIMIENTO CA %</th>
         <th>PENDIENTE ORDER CA</th>
         <th>ORDENAR</th>
         <th>CLASIFICACIÓN</th>
         <th>DAÑADOS Y VENCIDOS</th>
       </tr>
     </thead>
     

    <tbody>
      <?php
      foreach ($AllART['Analisis'] as $key) {
        

        if ($key['PROMEDIO']=='0.00') {
          echo "<tr class='ocultar'>";
        }
        else{echo "<tr>";}
        
        echo "<td class='Ancho negra'><a href='#' onclick='Deathalles(".'"'.$key['ARTICULO'].'"'.")'>".$key['ARTICULO']." </a></td>
        <td class='Ancho medium'>".utf8_decode($key['DESCRIPCION'])."</td>
        <td>".$key['LABORATORIO']."</td>
        <td>".$key['UNIDAD']."</td>
        <td class='Ancho medium'>".$key['PROVEEDOR']."</td>
        <td>".$key['CANT_DISPONIBLE']."</td>
        <td class='Ancho negra'><a style='cursor:pointer;' onclick='modalABC(".'"'.$key['ARTICULO'].'"'.")'>".$key['PROMEDIO']."</a></td>";
        
        $impresion1;
        $impresion2;
        $impresion3;
        $impresion4;
        if ($key['Comnet0']=="")
          {$impresion1 = "<a style='color:#4D4D4D;'>".$key['PEDDCA']."</a>";}
        else{$impresion1 = "<a style='color:#4D4D4D;'class='tooltipped' data-position='bottom' data-delay='50' data-tooltip='".$key['Comnet0']."'>".$key['PEDDCA']."</a>";}
        
        if ($key['Comnet1']=="")
          {$impresion2 = "<a style='color:#4D4D4D;'>".$key['CSCA']."</a>";}
        else{$impresion2 = "<a style='color:#4D4D4D;' class='tooltipped' data-position='bottom' data-delay='50' data-tooltip='".$key['Comnet1']."'>".$key['PEDDCA']."</a>";}
        
        if ($key['Comnet2']=="")
          {$impresion3 = "<a style='color:#4D4D4D;'>".$key['CTBP']."</a>";}
        else{$impresion3 = "<a style='color:#4D4D4D;'
        class='tooltipped' data-position='bottom' data-delay='50' data-tooltip='".$key['Comnet2']."'>".$key['CTBP']."</a>";}
        
        if ($key['Comnet3']=="")
          {$impresion4 = "<a style='color:#4D4D4D;'>".$key['CTTS']."</a>";}
        else{$impresion4 = "<a style='color:#4D4D4D;' 
        class='tooltipped' data-position='bottom' data-delay='50' data-tooltip='".$key['Comnet3']."'>".$key['CTTS']."</a>";}
        
        echo "<td style='background-color:#c1f4ff'>".$impresion1."</td>
        <td style='background-color:#c1f4ff'>".$impresion2."</td> 
        <td style='background-color:#63e3ff'>".$impresion3."</td>
        <td style='background-color:#63e3ff'>".$impresion4."</td>
        ";
        $promedio;
        if ($key['PROMEDIO']==0)
          {$promedio=0.00;  
          }
          else
            {$promedio=number_format($key['CANT_DISPONIBLE']/$key['PROMEDIO'],2);
        }
        echo "<td>".$promedio."</td>";
        echo "   
        <td>".number_format($key['CONTRATO_ANUAL'],2)."</td>        
        <td>".$key['PEDDCA']."</td>";
        /*CANT DOCE MESES CA*/
        $CANTIDADCA = $key['CANT12CA'];
        echo"<td><a style='color:#4D4D4D;' class='tooltipped' data-position='bottom' data-delay='20' data-tooltip='".$key['MENSAJE']. "'>
        ".$key['CANT12CA']."</a></td>";
        /***************************************/
        /*CUMPLIMIENTO CA%*/
        if($key['CONTRATO_ANUAL']!=0)
        {
          echo"
          <td>".number_format(($key['TOTAL_ANUAL_CA']+$key['PEDDCA'])*100/$key['CONTRATO_ANUAL'],1)." %</td>";
        }else{echo"
        <td>CONTRATO ANUAL NO DISPONIBLE</td>";}
        /***************************************/
        /*PENDIENTE ORDER CA*/    
        $CONTRATO; $color;
        if ($key['CONTRATO_ANUAL']>($key['TOTAL_ANUAL_CA']+$key['PEDDCA']))
        {
          $CONTRATO=$key['CONTRATO_ANUAL']-($key['TOTAL_ANUAL_CA']+$key['PEDDCA']);
          $color="red";
          /*echo "<td class='negra' style='color: red;!important'>".number_format($key['CONTRATO_ANUAL']-($key['TOTAL_ANUAL_CA']+$key['PEDDCA']),2)."</td>";*/
        }
        else{
          $CONTRATO=($key['TOTAL_ANUAL_CA']+$key['PEDDCA'])-$key['CONTRATO_ANUAL'];
          $color="green";
          /*echo " <td class='negra' style='color: green;!important'>".number_format(($key['TOTAL_ANUAL_CA']+$key['PEDDCA'])-$key['CONTRATO_ANUAL'],2)."</td> ";*/
        }
        echo "<td class='negra' style='color: ".$color.";!important'>".number_format($CONTRATO,2)."</td>";
        /********************************************************/
        /*ORDERNAR----CLASIFICACION-----DAÑADOS Y VENCIDOS*/
        $ORDENAR;
        $ORDENAR=number_format(($key['CANT_DISPONIBLE']+$key['CTBP']+$key['CTTS'])-($key['PEDDCA']+$CANTIDADCA+($key['PROMEDIO']*6)));
        echo"
        <td class='Ancho negra'>".$ORDENAR."</td>
        <td class='negra'>".$key['CLASE_ABC']."</td>
        <td>".$key['VENCIDOS']."</td>
        </tr>
        ";
      }
      ?>                         
    </tbody>
  </table>
</div>
</div>
</div>