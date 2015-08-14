<?php

/* 
 * Descripcion: Controlador que se encarga de la gestion del catalogo de los bancos.
 * 
 * @category    
 * @package     Controllers 
 */
Load::models('almacen/productos');

class ProductosController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        View::template('AdminLTE/default');
        $this->page_module = 'Productos';
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
    	$productos = new productos();
    	$this->productos = $productos->getProductos(); //Obtenemos todas las unidades
        $this->page_title = 'Lista de productos.';
    }
    
    /**
     * Create crear nuevos productos
     */
    public function create()
    {
        View::template(null);
        if (Input::hasPost('productos')){
            $productos = new productos(Input::post('productos'));
            if (!$productos->save()){
                Flash::error('No se pudo guardar el nuevo producto.');
            }else{
                Flash::valid('El registro del producto se creo corectamente');
                //Input::delete();
                return Router::redirect();
            }
        }
        
        $this->page_title = 'Nuevo producto.';
    }
    
    /**
     * Edit editamos los datos de los productos
     */
    public function edit($id=NULL)
    {
        View::template(null);
        $productos = new productos();
        if(Input::hasPost('productos')){
            if(!$productos->update(Input::post('productos'))){
                Flash::error('No se pudo actualizar el producto');
            }  else {
                Flash::valid('El producto se actualizo corectamente');
                return Router::redirect();
            }
        } 
        
        $this->productos = $productos->find((int)$id);
        $this->page_title = 'Editar producto.';
    }
}