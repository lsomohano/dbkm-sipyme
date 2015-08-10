<?php
/**
 *
 * Descripcion: Controlador para el panel principal de los usuarios logueados
 *
 * @category    
 * @package     Controllers 
 */

class IndexController extends BackendController {
    
    public $page_title = 'Principal';
    
    public $page_module = 'Inicio';
    
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
//        $this->page_module = 'Inicio';
    }
    
    public function index() { 

    }

}
