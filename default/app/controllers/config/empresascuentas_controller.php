<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/empresas_cuentas','config/cuentas');

class EmpresascuentasController extends BackendController {
    
    /**
     * Método para asignar direcciónes a la empresa.
     */
    public function createEmpCue(){
        if (Input::hasPost('empresascuentas')){
            $empresascuentas = new EmpresasCuentas(Input::post('empresascuentas'));
            $empresas_id = $empresascuentas->empresas_id;
            $cuentas_id = $empresascuentas->cuentas_id;
            if (!$empresascuentas->save() ){
                Flash::error('No se agregar la cuenta.');
            }else{
                $cambiestatus = new cuentas();
                $cambiestatus->dirCambiaEstatus($cuentas_id);
                Flash::valid("El registro de la dirección se creo corectamente");
                return Router::redirect("config/empresas/edit/$empresas_id");
            }
        }
    }
    
}