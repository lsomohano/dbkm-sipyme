<?php

/**
 *
 * Descripcion: Clase que gestiona las cuentas bancarias de empresas clientes y provedores.
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class configfactura extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('empresas');
    }
    
    /**
     * Método que retorna los recursos asignados a un perfil de usuario
     * @param int $perfil Identificador el perfil del usuario
     * @return array object ActieRecord
     */
    public function getConfigfactura($empresa) {
        $empresa     = Filter::get($empresa,'numeric');
        $columnas   = 'configfactura.*';
        $condicion  = "configfactura.empresas_id = '$empresa'";
        return $this->find("columns: $columnas", "conditions: $condicion");        
    }
    
    /**
     * Devuelve un array de direcciones que se puede usar en un dbselect
     * 
     * @return array Array PHP de direcciones
     */    
    public function buscarConfigfactura() {
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