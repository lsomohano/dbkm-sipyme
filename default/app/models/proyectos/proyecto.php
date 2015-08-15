<?php

/**
 *
 * Descripcion: Clase que gestiona los proyectos
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class proyecto extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('clientes');
        $this->belongs_to('empresas');
        $this->has_many('levantamiento');
        $this->has_many('cotizacion');
        $this->has_many('foliocotiza');
    }
    
    /**
     * Método que retorna los productos dados de alta en la base de datos
     * @return array object ActieRecord
     */
    public function getProyectos() {
//        $cliente     = Filter::get($cliente,'numeric');
        $columnas   = 'proyecto.*, empresas.e_nombrecorto, clientes.c_nombrecorto';
        $join       = 'INNER JOIN empresas ON empresas.id = proyecto.empresas_id ';  
        $join       .='INNER JOIN clientes ON clientes.id = proyecto.clientes_id';
//        $condicion  = "clientes_cuentas.clientes_id = '$cliente'";
//        $order      = 'recurso.modulo ASC, recurso.controlador ASC,  recurso.recurso_at ASC';        
        return $this->find("columns: $columnas", "join: $join");        
    }
    
    /**
     * 
     * @param type $empresas_id
     * @return type
     */
    public function buscarProyectos($empresas_id){
        $condicion  = "proyecto.empresas_id = '$empresas_id'";
        return $this->find("condicion: $condicion", 'order: nombrecorto');
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