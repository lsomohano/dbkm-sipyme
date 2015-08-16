<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/clientes_cuentas','config/cuentas');

class ClientescuentasController extends BackendController {
    
    /**
     * Método para asignar direcciónes a la empresa.
     */
    public function createClientCue(){
        if (Input::hasPost('clientescuentas')){
            $clientescuentas = new ClientesCuentas(Input::post('clientescuentas'));
            $clientes_id = $clientescuentas->empresas_id;
            $cuentas_id = $clientescuentas->cuentas_id;
            if (!$clientescuentas->save() ){
                Flash::error('No se agregar la cuenta.');
            }else{
                $cambiestatus = new cuentas();
                $cambiestatus->dirCambiaEstatus($cuentas_id);
                Flash::valid("El registro de la dirección se creo corectamente");
                return Router::redirect("config/clientes/edit/$clientes_id");
            }
        }
    }
    
}