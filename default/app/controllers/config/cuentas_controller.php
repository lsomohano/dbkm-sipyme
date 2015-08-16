<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/cuentas','config/empresas_cuentas','catalogos/bancos','catalogos/monedas');

class CuentasController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Cuentas Bancarias';
    }
    
    /**
     * Método principal
     */
    public function index() {
        Redirect::toAction('listar');
    }
       
    /**
     * Create crear nuevas eempresas
     */
    public function create($empresa_id=NULL)
    {
        View::template(null);
        if (Input::hasPost('cuentas')){
            $cuentas = new cuentas(Input::post('cuentas'));
            if (!$cuentas->save()){
                Flash::error('No se pudo guardar la cuenta.');
            }else{
                $empresas_id = Input::request("empresas_id");
                Flash::valid("El registro de la dirección se creo corectamente");
//                return Router::redirect("config/empresas/edit/$empresas_id");
                return header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
        
        $this->empresa_id = $empresa_id;
        $this->page_title = 'Nueva Cuenta.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($empresa_id=NULL, $id=NULL)
    {
        View::template(null);
        $cuentas = new cuentas();
        if(Input::hasPost('cuentas')){
            if(!$cuentas->update(Input::post('cuentas'))){
                Flash::error('No se pudo actualizar la cuenta');
            }  else {
                $empresas_id = Input::request("empresas_id");
                Flash::valid('La direccion se actualizo corectamente');
//                return Router::redirect("config/empresas/edit/$empresas_id");
                return header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        } 
        
        $this->empresa_id = $empresa_id;
        $this->cuentas = $cuentas->find((int)$id);
        $this->page_title = 'Editar Cuenta.';
    }
}