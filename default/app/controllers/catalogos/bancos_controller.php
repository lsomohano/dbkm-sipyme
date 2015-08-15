<?php

/* 
 * Descripcion: Controlador que se encarga de la gestion del catalogo de los bancos.
 * 
 * @category    
 * @package     Controllers 
 */
Load::models('catalogos/bancos');

class BancosController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Bancos';
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
    	$bancos = new bancos();
    	$this->bancos = $bancos -> find(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de los tipos de productos.';
    }
    
    /**
     * Create crear nuevas eempresas
     */
    public function create()
    {
        View::template(null);
        if (Input::hasPost('bancos')){
            $bancos = new bancos(Input::post('bancos'));
            if (!$bancos->save()){
                Flash::error('No se pudo guardar el nuevo banco.');
            }else{
                Flash::valid('El registro del banco se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        $enum = new bancos();
        $this->estatus = $enum->devuelveENUM('bancos', 'b_estatus');
        
        $this->page_title = 'Nuevo banco.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        View::template(null);
        $bancos = new bancos();
        if(Input::hasPost('bancos')){
            if(!$bancos->update(Input::post('bancos'))){
                Flash::error('No se pudo actualizar el banco');
            }  else {
                Flash::valid('El banco se actualizo corectamente');
                return Router::redirect();
            }
        } 
        $enum = new bancos();
        $this->estatus = $enum->devuelveENUM('bancos', 'b_estatus');
        
        $this->bancos = $bancos->find((int)$id);
        $this->page_title = 'Editar banco.';
    }
}