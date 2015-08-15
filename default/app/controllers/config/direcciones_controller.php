<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/direcciones','config/empresas_direccion');

class DireccionesController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Direcciones';
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
        if (Input::hasPost('direcciones')){
            $direcciones = new direcciones(Input::post('direcciones'));
            if (!$direcciones->save()){
                Flash::error('No se pudo guardar la dirección.');
            }else{
                $empresas_id = Input::request("empresas_id");
                Flash::valid("El registro de la dirección se creo corectamente");
//                return Router::redirect("config/empresas/edit/$empresas_id");
//                return Router::redirect($_SERVER['HTTP_REFERER']);
                return header('Location: '.$_SERVER['HTTP_REFERER']);    
            }
        }
        $enum = new direcciones();
        $this->tipo = $enum->devuelveENUM('direcciones', 'tipo_dir');
        $this->empresa_id = $empresa_id;
        $this->page_title = 'Nueva Dirección.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($empresa_id=NULL, $id=NULL)
    {
        View::template(null);
        $direcciones = new direcciones();
        if(Input::hasPost('direcciones')){
            if(!$direcciones->update(Input::post('direcciones'))){
                Flash::error('No se pudo actualizar la dirección');
            }  else {
                $empresas_id = Input::request("empresas_id");
                Flash::valid('La direccion se actualizo corectamente');
//                return Router::redirect("config/empresas/edit/$empresas_id");
                return header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        } 
        $enum = new direcciones();
        $this->tipo = $enum->devuelveENUM('direcciones', 'tipo_dir');
        $this->empresa_id = $empresa_id;
        $this->direcciones = $direcciones->find((int)$id);
        $this->page_title = 'Editar Dirección.';
    }
}
