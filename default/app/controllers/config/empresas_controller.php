<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/empresas', 'config/direcciones', 'config/empresas_direccion', 'config/cuentas', 'config/empresas_cuentas', 'config/configfactura');

class EmpresasController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Empresas';
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
    	$empresas = new empresas();
    	$this->empresas = $empresas -> find(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de empresas.';
    }
    
    /**
     * Create crear nuevas eempresas
     */
    public function create()
    {
        if (Input::hasPost('empresas')){
            $empresas = new empresas(Input::post('empresas'));
            if (!$empresas->save()){
                Flash::error('No se pudo guardar el nuevo banco.');
            }else{
                Flash::valid('El registro del banco se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        
        $this->page_title = 'Nueva Empresa.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($id=NULL)
    {
        $empresas = new empresas();
        if(Input::hasPost('empresas')){
            if(!$empresas->update(Input::post('empresas'))){
                Flash::error('No se pudo actualizar la empresa');
            }  else {
                Flash::valid('La empresa se actualizo corectamente');
                return Router::redirect();
            }
        } 
        
        $empre_dirc = new EmpresasDireccion();
        $this->direcciones = $empre_dirc->getEmpresasDireccion($id);
        
        $cuentas = new EmpresasCuentas();
        $this->cuentas = $cuentas->getEmpresasCuentas($id);
        
        $configfactura = new configfactura();
        $this->configfactura = $configfactura->getConfigfactura($id);
        
        $this->empresas = $empresas->find((int)$id);
        $this->page_title = 'Editar empresas.';
    }
    
    /**
     * Método para subir imágenes
     */
    public function upload() {  
        $upload = new DwUpload('logotipo', 'img/upload/empresas/');
        $upload->setAllowedTypes('png|jpg|gif|jpeg');
        $upload->setEncryptName(TRUE);
        $upload->setSize('3MB', 160, 160, TRUE);
        if(!$data = $upload->save()) { //retorna un array('path'=>'ruta', 'name'=>'nombre.ext');
            $data = array('error'=>TRUE, 'message'=>$upload->getError());
        }else{
            $ruta = 'img/upload/empresas/'.$data['name'];
            $path = 'img/upload/empresas/thumb/'.$data['name'];

            Load::lib("resize-class");
            $resizeObj = new resize($ruta);
            $resizeObj -> resizeImage(50, 50, 'auto');
            $resizeObj -> saveImage($path, 100);
        }
        sleep(1);//Por la velocidad del script no permite que se actualize el archivo
        $this->data = $data;
        View::json();
    }
    
    
    
}
