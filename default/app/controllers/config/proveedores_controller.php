<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de los proveedores
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/proveedores', 'config/direcciones', 'config/proveedores_direccion', 'config/cuentas', 'config/proveedores_cuentas');

class ProveedoresController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Proveedores';
    }
    
    /**
     * Método principal
     */
    public function index() {
        Redirect::toAction('listar');
    }
    
    /**
     * Método para listar
     */
    public function listar() 
    {
    	$proveedores = new proveedores();
    	$this->proveedores = $proveedores -> find(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de Proveedores.';
    }
    
    /**
     * Create crear nuevo proveedor
     */
    public function create()
    {
        if (Input::hasPost('proveedores')){
            $proveedores = new proveedores(Input::post('proveedores'));
            if (!$proveedores->save()){
                Flash::error('No se pudo guardar el nuevo proveedor.');
            }else{
                Flash::valid('El registro del proveedor se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        
        $this->page_title = 'Nuevo Proveedor.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        $proveedores = new proveedores();
        if(Input::hasPost('proveedores')){
            if(!$proveedores->update(Input::post('proveedores'))){
                Flash::error('No se pudo actualizar el proveedor');
            }  else {
                Flash::valid('El proveedor se actualizo corectamente');
                return Router::redirect();
            }
        } 
        
        $client_dirc = new ProveedoresDireccion();
        $this->direcciones = $client_dirc->getProveedoresDireccion($id);
        
        $cuentas = new ProveedoresCuentas();
        $this->cuentas = $cuentas->getProveedoresCuentas($id);
        
        $this->proveedores = $proveedores->find((int)$id);
        $this->page_title = 'Editar proveedores.';
    }
   
}
