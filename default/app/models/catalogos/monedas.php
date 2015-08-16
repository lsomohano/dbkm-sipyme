<?php

/**
 *
 * Descripcion: Clase que gestiona las unidades de medida
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class monedas extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
//        $this->belongs_to('perfil');
        $this->has_many('cuentasempresa');
        $this->has_many('cuentasproveedores');
        $this->has_many('cuentasclientes');
        $this->has_many('condicionescomerciales');
    }
    
    
    /**
     * Devuelve un array de direcciones que se puede usar en un dbselect
     * 
     * @return array Array PHP de direcciones
     */    
    public function buscarMonedas() {
        return $this->find("m_estatus = 'activa'");
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