<?php

/**
 *
 * Descripcion: Clase que gestiona las unidades de medida
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class productos extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('inventarios');
        $this->belongs_to('unidadesm');
        $this->belongs_to('tipoproducto');
        $this->has_many('materiales');
    }
    
    /**
     * Devuelve un array de direcciones que se puede usar en un dbselect
     * 
     * @return array Array PHP de direcciones
     */    
    public function buscarProductos() {
        return $this->find();
    }
    
    
    /**
     * Método que retorna los productos dados de alta en la base de datos
     * @return array object ActieRecord
     */
    public function getProductos() {
//        $cliente     = Filter::get($cliente,'numeric');
        $columnas   = 'productos.*, tipoproducto.tipoproducto_nombre, unidadesm.unidad_nombre';
        $join       = 'INNER JOIN tipoproducto ON tipoproducto.id = productos.tipoproducto_id ';  
        $join.='INNER JOIN unidadesm ON unidadesm.id = productos.unidadesm_id';
//        $condicion  = "clientes_cuentas.clientes_id = '$cliente'";
//        $order      = 'recurso.modulo ASC, recurso.controlador ASC,  recurso.recurso_at ASC';        
        return $this->find("columns: $columnas", "join: $join");        
    }
    /**
     * Devuelve un array de un campo enum que se puede usar en un select
     * 
     * @return array Array PHP de un campo enum
     */
    public function devuelveENUM($table, $column)
    {
        $enum = $this->find_by_sql("SHOW COLUMNS FROM $table LIKE '$column'");
        preg_match_all("/'([\w ]*)'/", $enum->Type, $values);
        $miarray = array(NULL=>'-- Seleccione --');
        foreach($values[1] as $indice=>$valor) {
            $miarray[$valor] = $valor;
//            return $this->values = "Indice: ".$pepe."  Valor: ".$pepa."<br>";
        }
        return $this->values = $miarray;
    }
}