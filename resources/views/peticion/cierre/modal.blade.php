<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detalle de calculo de ventas diarias</h4>
      </div>
      <div class="modal-body">
	  <h3>Ventas generales </h3>(*Todos los valores que aparecen en <font color="red">rojo</font> se restan, asi mismo todos los valores que aparecen en <font color="#298A08">verde</font> se suman)
														<table class="table table-bordered">
														<tr>
														<td>General ventas: {{number_format($sumarray->valorventa)}} (Gran total de ventas) </td>
														</tr>
														<tr>
														<td><font color="red">Descuentos: {{number_format($sumarray->descuentos)}}</font></td>
														</tr>
														<tr>
														<td><font color="red">Devoluciones: {{number_format($totaldevolucion)}}</font></td>
														</tr>
														<tr>
														<td><font color="red">Convenios: {{number_format($convenios->valorventa)}}</font></td>
														</tr>
														<tr>
														<td><font color="red">Base de caja: {{number_format($base->valorbase)}}</font></td>
														</tr>
														<tr>
														<td><font color="#298A08"><b>Ingresos: {{number_format($valingreso)}}<b></font></td>
														</tr>
														<tr>
														<td><font color="#298A08"><b>Abonos: {{number_format($totalabono)}}<b></font></td>
														</tr>
														<tr>
														<td><b><H4>GRAN TOTAL:</H4> {{number_format($sumarray->valorventa - $sumarray->descuentos - $totaldevolucion  - $base->valorbase - $convenios->valorventa + $valingreso + $totalabono)}}<b></font></td>
														</tr>
														

														</table>
														<h3>Subtotal de ventas </h3>(*Todos los valores que aparecen en <font color="red">rojo</font> se restan, asi mismo todos los valores que aparecen en <font color="#298A08">verde</font> se suman)
														<table class="table table-bordered">
														<tr>
														<td>General Subventas:  {{number_format($sumarray->subtotal)}} (Gran Subtotal de ventas) </td>
														</tr>
														<tr>
														<td><font color="red">Devoluciones: {{number_format($sumadev->subdev)}}</font></td>
														</tr>
								
														<tr>
														<td><font color="red">Convenios: {{number_format($convenios->subtotal)}}</font></td>
														</tr>
														<tr>
														<td><b><H4>GRAN SUBTOTAL:</H4> {{number_format($sumarray->subtotal - $sumadev->subdev - $convenios->subtotal)}}<b></font></td>
														</tr>
														

														</table>

														<h3>Utilidades </h3>(*Todos los valores que aparecen en <font color="red">rojo</font> se restan, asi mismo todos los valores que aparecen en <font color="#298A08">verde</font> se suman)
														<table class="table table-bordered">
														<tr>
														<td>Utilidades de ventas: {{number_format($sumarray->utilidades + $sumasutil)}} (Gran total de utilidad de ventas) </td>
														</tr>
														<tr>
														<td><font color="red">Descuentos: {{number_format($sumarray->descuentos)}}</font></td>
														</tr>
														<tr>
														<td><font color="red">Comisiones de venta: {{number_format($sumarray->com)}}</font></td>
														</tr>
														<tr>
														<td><font color="red">Devoluciones (*Utilidad por devoluciones generadas): {{number_format($sumadev->utilidadsuma)}}</font></td>
														</tr>
														<tr>
														<td><font color="red">Convenios (*Utilidad por Convenios generados): {{number_format($convenios->utilidades)}}</font></td>
														</tr>
														<tr>
														<td><font color="#298A08"><b>Comisiones de las devoluciones generadas: {{number_format($sumadev->com_dev)}}<b></font></td>
														</tr>
														<tr>
														<td><font color="#298A08"><b>Utilidad otros ingresos: {{number_format($utilingreso)}}<b></font></td>
														</tr>
														<tr>
														<td><font color="#298A08"><b>Utilidad por abonos: {{number_format($utilidadabono)}}<b></font></td>
														</tr>
														<tr>
														<td><b><H4>GRAN TOTAL EN UTILIDADES:</H4>{{number_format($sumarray->utilidades - $sumarray->com  - $sumadev->utilidadsuma -  $convenios->utilidades  + $sumadev->com_dev + $utilingreso +  $utilidadabono)}}<b></font></td>
														</tr>
								
														
														

														</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar cuadro de dialogo</button>
      </div>
    </div>

  </div>
</div>