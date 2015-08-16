<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/proveedores_cuentas','config/cuentas');

class ProveedorescuentasController extends BackendController {
    
    /**
     * Método para asignar direcciónes a la empresa.
     */
    public function createProCue(){
        if (Input::hasPost('proveedorescuentas')){
            $proveedorescuentas = new ProveedoresCuentas(Input::post('proveedorescuentas'));
            $proveedores_id = $proveedorescuentas->proveedores_id;
            $cuentas_id = $proveedorescuentas->cuentas_id;
            if (!$proveedorescuentas->save() ){
                Flash::error('No se agregar la cuenta.');
            }else{
                $cambiestatus = new cuentas();
                $cambiestatus->dirCambiaEstatus($cuentas_id);
                Flash::valid("El registro de la dirección se creo corectamente");
                return Router::redirect("config/empresas/edit/$proveedores_id");
            }
        }
    }
    
}