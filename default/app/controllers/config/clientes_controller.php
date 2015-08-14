<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de los clientes
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/clientes', 'config/direcciones', 'config/clientes_direccion', 'config/cuentas', 'config/clientes_cuentas');

class ClientesController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Clientes';
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
    	$clientes = new clientes();
    	$this->clientes = $clientes -> find(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de Clientes.';
    }
    
    /**
     * Create crear nuevas eempresas
     */
    public function create()
    {
        if (Input::hasPost('clientes')){
            $clientes = new clientes(Input::post('clientes'));
            if (!$clientes->save()){
                Flash::error('No se pudo guardar el nuevo cliente.');
            }else{
                Flash::valid('El registro del cliente se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        
        $this->page_title = 'Nuevo Cliente.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        $clientes = new clientes();
        if(Input::hasPost('clientes')){
            if(!$clientes->update(Input::post('clientes'))){
                Flash::error('No se pudo actualizar el cliente');
            }  else {
                Flash::valid('El cliente se actualizo corectamente');
                return Router::redirect();
            }
        } 
        
        $client_dirc = new ClientesDireccion();
        $this->direcciones = $client_dirc->getClientesDireccion($id);
        
        $cuentas = new ClientesCuentas();
        $this->cuentas = $cuentas->getClientesCuentas($id);
        
        $this->clientes = $clientes->find((int)$id);
        $this->page_title = 'Editar clientes.';
    }
    
}
