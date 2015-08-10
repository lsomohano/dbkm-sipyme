<?php

/**
 *
 * Descripcion: Clase que gestiona la relación dirección-empresa
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class ProveedoresCuentas extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('proveedores'); 
        $this->belongs_to('cuentas');
    }
    
    /**
     * Método que retorna los recursos asignados a un perfil de usuario
     * @param int $perfil Identificador el perfil del usuario
     * @return array object ActieRecord
     */
    public function getProveedoresCuentas($proveedores) {
        $proveedores     = Filter::get($proveedores,'numeric');
        $columnas   = 'proveedores_cuentas.*, cuentas.cuenta, cuentas.sucursal, cuentas.claveinterbancaria, cuentas.cu_referencia, cuentas.bancos_id, bancos.b_nombrecorto';
        $join       = 'INNER JOIN cuentas ON cuentas.id = proveedores_cuentas.cuentas_id ';  
        $join.='INNER JOIN bancos ON bancos.id = cuentas.bancos_id';
        $condicion  = "proveedores_cuentas.proveedores_id = '$proveedores'";
//        $order      = 'recurso.modulo ASC, recurso.controlador ASC,  recurso.recurso_at ASC';        
        return $this->find("columns: $columnas", "join: $join", "conditions: $condicion");        
    }
}