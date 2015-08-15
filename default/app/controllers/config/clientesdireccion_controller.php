<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/clientes_direccion','config/direcciones');

class ClientesdireccionController extends BackendController {
    
    /**
     * Método para asignar direcciónes a la empresa.
     */
    public function createClientDir(){
        if (Input::hasPost('clientesdireccion')){
            $clientesdireccion = new ClientesDireccion(Input::post('clientesdireccion'));
            
            $clientes_id = $clientesdireccion->clientes_id;
            $direcciones_id = $clientesdireccion->direcciones_id;
            if (!$clientesdireccion->save() ){
                Flash::error('No se agregar la dirección.');
            }else{
                $cambiestatus = new direcciones();
                $cambiestatus->dirCambiaEstatus($direcciones_id);
                Flash::valid("El registro de la dirección se creo corectamente");
                return Router::redirect("config/clientes/edit/$clientes_id");
            }
        }
    }
    
}