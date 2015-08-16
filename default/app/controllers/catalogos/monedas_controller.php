<?php

/* 
 * Descripcion: Controlador que se encarga de la gestion del catalogo de monedas.
 * 
 * @category    
 * @package     Controllers 
 */
Load::models('catalogos/monedas');

class MonedasController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Monedas';
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
    	$monedas = new monedas();
    	$this->monedas = $monedas -> find(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de Monedas';
    }
    
    /**
     * Create crear nuevas eempresas
     */
    public function create()
    {
        View::template(null);
        if (Input::hasPost('monedas')){
            $monedas = new monedas(Input::post('monedas'));
            if (!$monedas->save()){
                Flash::error('No se pudo guardar la nueva unidad de medida');
            }else{
                Flash::valid('La unidad de medida se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        $enum = new monedas();
        $this->estatus = $enum->devuelveENUM('monedas', 'm_estatus');
        
        $this->page_title = 'Nueva moneda.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        View::template(null);
        $monedas = new monedas();
        if(Input::hasPost('monedas')){
            if(!$monedas->update(Input::post('monedas'))){
                Flash::error('No se pudo actualizar la moneda');
            }  else {
                Flash::valid('La moneda de medida se actualizo corectamente');
                return Router::redirect();
            }
        } 
        
        $enum = new monedas();
        $this->estatus = $enum->devuelveENUM('monedas', 'm_estatus');
        
        $this->monedas = $monedas->find((int)$id);
        $this->page_title = 'Editar moneda.';
    }
}