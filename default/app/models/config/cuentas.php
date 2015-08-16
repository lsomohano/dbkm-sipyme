<?php

/**
 *
 * Descripcion: Clase que gestiona las cuentas bancarias de empresas clientes y provedores.
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class cuentas extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->has_many('empresas_cuentas');
        $this->has_many('clientes_cuentas');
        $this->has_many('proveedores_cuentas'); 
        $this->belongs_to('bancos');
        $this->belongs_to('monedas');
    }
    
    
    /**
     * Devuelve un array de direcciones que se puede usar en un dbselect
     * 
     * @return array Array PHP de direcciones
     */    
    public function buscarCuentas() {
        return $this->find("estatus = 'activa'");
    }
    
    /**
     * Actualiza estatus
     * 
     * @return array Array PHP de direcciones
     */
    public function dirCambiaEstatus($cuentas_id){
        if ($this->update_all("estatus='asignada'","id=$cuentas_id"))
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