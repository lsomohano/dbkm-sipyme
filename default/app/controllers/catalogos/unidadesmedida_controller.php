<?php

/* 
 * Descripcion: Controlador que se encarga de la gestion del catalogo de las unidades de medida.
 * 
 * @category    
 * @package     Controllers 
 */
Load::models('catalogos/unidadesmedidas');

class UnidadesmedidaController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Unidades de Medidas';
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
    	$unidadesMedidas = new unidadesm();
    	$this->unidadesMedidas = $unidadesMedidas -> find(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de las unidades de medidas';
    }
    
    /**
     * Create crear nuevas eempresas
     */
    public function create()
    {
        View::template(null);
        if (Input::hasPost('unidadesm')){
            $unidadesm = new unidadesm(Input::post('unidadesm'));
            if (!$unidadesm->save()){
                Flash::error('No se pudo guardar la nueva unidad de medida');
            }else{
                Flash::valid('La unidad de medida se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        $enum = new unidadesm();
        $this->estatus = $enum->devuelveENUM('unidadesm', 'unidad_estado');
        
        $this->page_title = 'Nueva unidad de medida.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        View::template(null);
        $unidadesm = new unidadesm();
        if(Input::hasPost('unidadesm')){
            if(!$unidadesm->update(Input::post('unidadesm'))){
                Flash::error('No se pudo actualizar la unidad');
            }  else {
                Flash::valid('La unidad de medida se actualizo corectamente');
                return Router::redirect();
            }
        } 
        $enum = new unidadesm();
        $this->estatus = $enum->devuelveENUM('unidadesm', 'unidad_estado');
        
        $this->unidadesm = $unidadesm->find((int)$id);
        $this->page_title = 'Editar unidad de medida.';
    }
}