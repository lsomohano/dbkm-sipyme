<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/proveedores_direccion','config/direcciones');

class ProveedoresdireccionController extends BackendController {
    
    /**
     * Método para asignar direcciónes a la empresa.
     */
    public function createProDir(){
        if (Input::hasPost('proveedoresdireccion')){
            $proveedoresdireccion = new ProveedoresDireccion(Input::post('proveedoresdireccion'));
            
            $proveedores_id = $proveedoresdireccion->proveedores_id;
            $direcciones_id = $proveedoresdireccion->direcciones_id;
            if (!$proveedoresdireccion->save() ){
                Flash::error('No se agregar la dirección.');
            }else{
                $cambiestatus = new direcciones();
                $cambiestatus->dirCambiaEstatus($direcciones_id);
                Flash::valid("El registro de la dirección se creo corectamente");
                return Router::redirect("config/empresas/edit/$proveedores_id");
            }
        }
    }
    
}