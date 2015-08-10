<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/empresas_direccion','config/direcciones');

class EmpresasdireccionController extends BackendController {
    
    /**
     * Método para asignar direcciónes a la empresa.
     */
    public function createEmpDir(){
        if (Input::hasPost('empresasdireccion')){
            $empresasdireccion = new EmpresasDireccion(Input::post('empresasdireccion'));
            
            $empresas_id = $empresasdireccion->empresas_id;
            $direcciones_id = $empresasdireccion->direcciones_id;
            if (!$empresasdireccion->save() ){
                Flash::error('No se agregar la dirección.');
            }else{
                $cambiestatus = new direcciones();
                $cambiestatus->dirCambiaEstatus($direcciones_id);
                Flash::valid("El registro de la dirección se creo corectamente");
                return Router::redirect("config/empresas/edit/$empresas_id");
            }
        }
    }
    
}