<?php

/* 
 * Descripcion: Controlador que se encarga de la gestion del catalogo de monedas.
 * 
 * @category    
 * @package     Controllers 
 */
Load::models('proyectos/proyecto');

class ProyectoController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Proyectos';
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
    	$proyectos = new proyecto();
    	$this->proyectos = $proyectos ->getProyectos(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de Proyectos';
    }
    
    /**
     * Create crear nuevas eempresas
     */
    public function create()
    {
        View::template(null);
        if (Input::hasPost('proyecto')){
            $proyecto = new proyecto(Input::post('proyecto'));
            if (!$proyecto->save()){
                Flash::error('No se pudo guardar el nuevo proyecto');
            }else{
                Flash::valid('El nuevo proyecto se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
//        $enum = new monedas();
//        $this->estatus = $enum->devuelveENUM('monedas', 'm_estatus');
        
        $this->page_title = 'Nuevo Proyecto.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        View::template(null);
        $proyecto = new proyecto();
        if(Input::hasPost('proyecto')){
            if(!$proyecto->update(Input::post('proyecto'))){
                Flash::error('No se pudieron actualizar los datos del proyecto');
            }  else {
                Flash::valid('El proyecto se actualizo corectamente');
                return Router::redirect();
            }
        } 
        
//        $enum = new monedas();
//        $this->estatus = $enum->devuelveENUM('monedas', 'm_estatus');
        
        $this->proyecto = $proyecto->find((int)$id);
        $this->page_title = 'Editar Proyecto.';
    }
}