<?php

/**
 *
 * Descripcion: Clase que gestiona las unidades de medida
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class unidadesm extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
//        $this->belongs_to('perfil');
        $this->has_many('productos');                        
    }
    
    /**
     * Devuelve un array de unidades de medidas que se puede usar en un dbselect
     * 
     * @return array Array PHP de direcciones
     */    
    public function buscarUnidadM() {
        return $this->find("unidad_estado = 'activa'");
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