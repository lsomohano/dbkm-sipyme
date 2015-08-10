<?php

/**
 *
 * Descripcion: Clase que gestiona las direcciones de empresas clientes y provedores.
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class direcciones extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->has_many('empresas_direccion');
        $this->has_many('clientes_direccion');
        $this->has_many('proveedores_direccion'); 
        $this->has_many('correosempresas');
        $this->has_many('telefonoempresas');
    }
    
    /**
     * Devuelve un array de direcciones que se puede usar en un dbselect
     * 
     * @return array Array PHP de direcciones
     */    
    public function buscarDir() {
        return $this->find("estatus = 'activa'");
    }
    
    /**
     * Actualiza estatus
     * 
     * @return array Array PHP de direcciones
     */
    public function dirCambiaEstatus($direcciones_id){
        if ($this->update_all("estatus='asignada'","id=$direcciones_id"))
        {
            return TRUE;
        }else{
            return FALSE;
        }
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