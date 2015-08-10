<?php

/* 
 * Descripcion: Controlador que se encarga de la gestion del catalogo de los tipos de productos.
 * 
 * @category    
 * @package     Controllers 
 */
Load::models('catalogos/tipoproducto');

class TipoproductoController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Tipo de productos';
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
    	$tipoproducto = new tipoproducto();
    	$this->tipoproducto = $tipoproducto -> find(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de los tipos de productos.';
    }
    
    /**
     * Create crear nuevas eempresas
     */
    public function create()
    {
        View::template(null);
        if (Input::hasPost('tipoproducto')){
            $tipoproducto = new tipoproducto(Input::post('tipoproducto'));
            if (!$tipoproducto->save()){
                Flash::error('No se pudo guardar el nuevo tipo de producto.');
            }else{
                Flash::valid('El tipo de producto se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        $enum = new tipoproducto();
        $this->estatus = $enum->devuelveENUM('tipoproducto', 'tip_estatus');
        
        $this->page_title = 'Nuevo tipo de producto.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        View::template(null);
        $tipoproducto = new tipoproducto();
        if(Input::hasPost('tipoproducto')){
            if(!$tipoproducto->update(Input::post('tipoproducto'))){
                Flash::error('No se pudo actualizar el tipo de producto');
            }  else {
                Flash::valid('El tipo de producto se actualizo corectamente');
                return Router::redirect();
            }
        } 
        $enum = new tipoproducto();
        $this->estatus = $enum->devuelveENUM('tipoproducto', 'tip_estatus');
        
        $this->tipoproducto = $tipoproducto->find((int)$id);
        $this->page_title = 'Editar tipo de producto.';
    }
}