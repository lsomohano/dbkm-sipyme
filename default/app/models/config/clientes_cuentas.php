<?php

/**
 *
 * Descripcion: Clase que gestiona la relación dirección-empresa
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class ClientesCuentas extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('clientes'); 
        $this->belongs_to('cuentas');
    }
    
    /**
     * Método que retorna los recursos asignados a un perfil de usuario
     * @param int $perfil Identificador el perfil del usuario
     * @return array object ActieRecord
     */
    public function getClientesCuentas($cliente) {
        $cliente     = Filter::get($cliente,'numeric');
        $columnas   = 'clientes_cuentas.*, cuentas.cuenta, cuentas.sucursal, cuentas.claveinterbancaria, cuentas.cu_referencia, cuentas.bancos_id, bancos.b_nombrecorto';
        $join       = 'INNER JOIN cuentas ON cuentas.id = clientes_cuentas.cuentas_id ';  
        $join.='INNER JOIN bancos ON bancos.id = cuentas.bancos_id';
        $condicion  = "clientes_cuentas.clientes_id = '$cliente'";
//        $order      = 'recurso.modulo ASC, recurso.controlador ASC,  recurso.recurso_at ASC';        
        return $this->find("columns: $columnas", "join: $join", "conditions: $condicion");        
    }
}