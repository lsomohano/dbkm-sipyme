<?php
/**
 *
 * Descripcion: Controlador empresas para el manejo de las empresas
 *
 * @category    
 * @package     Controllers  
 */
Load::models('config/configfactura');

class ConfigfacturaController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Configuración de facturación';
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
        if (Input::hasPost('configfactura')){
            $archivokey = Upload::factory('archivokeyPem');
            $archivokey->setExtensions(array('pem'));//le asignamos las extensiones a permitir
            
            $archivocer = Upload::factory('archivocerPem');
            $archivocer->setExtensions(array('pem'));//le asignamos las extensiones a permitir
            
            if ($archivokey->isUploaded() && $archivocer->isUploaded()) {
                if ($namekey = $archivokey->save()) {
                    if ($namecer = $archivocer->save()){
                        $configfactura = new configfactura(Input::post('configfactura'));
                        $empresas_id = Input::request("empresas_id");
                        $configfactura->archivokeyPem = $namekey;
                        $configfactura->archivocerPem = $namecer."1";
                        $configfactura->empresas_id = $empresas_id;
                        if (!$configfactura->save()){
                            Flash::error('No se pudo guardar la configuracion de la factura.');
                        }else{
                            
                            Flash::valid("El registro de la configuracion de la factura se creo corectamente.");
                            return Router::redirect("config/empresas/edit/$empresas_id");
                        }
                    }
                }   
            }
        }
        
        $this->empresa_id = $empresa_id;
        $this->page_title = 'Nuevo dato de factura.';
    }
    
    /**
     * Edit editamos las unidades de medida ingresamos
     */
    public function edit($empresa_id=NULL, $id=NULL)
    {
        View::template(null);
        $configfactura = new configfactura();
        if(Input::hasPost('configfactura')){
            $empresas_id = Input::request("empresas_id");
            
            
            if ($_FILES['a_keyPem']['tmp_name'] != "") {
                $archivokey = Upload::factory('a_keyPem');
                $archivokey->setExtensions(array('pem'));//le asignamos las extensiones a permitir
                if ($archivokey->isUploaded()) {
                    if ($namekey = $archivokey->save()) {
                        $configfactura->archivokeyPem = $namekey;
                    }   
                }
            }
            
            
            if ($_FILES['a_keyPem']['tmp_name'] != "") {
                $archivocer = Upload::factory('a_cerPem');
                $archivocer->setExtensions(array('pem'));//le asignamos las extensiones a permitir
                if ($archivocer->isUploaded()) {
                    if ($namecer = $archivocer->save()){
                        $configfactura->archivocerPem = $namecer;
                    }
                }
            }
            $configfactura->empresas_id = $empresas_id;
            if(!$configfactura->update(Input::post('configfactura'))){
                Flash::error('No se pudo actualizar la configuracion de facturas');
            }  else {
                $empresas_id = Input::request("empresas_id");
                Flash::valid('La direccion se actualizo corectamente');
                return Router::redirect("config/empresas/edit/$empresas_id");
            }
        } 
        
        $this->empresa_id = $empresa_id;
        $this->configfactura = $configfactura->find((int)$id);
        $this->page_title = 'Editar Dato de factura.';
    }
    
    
}