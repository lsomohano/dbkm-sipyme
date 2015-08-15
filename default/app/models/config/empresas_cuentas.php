<?php

/**
 *
 * Descripcion: Clase que gestiona la relación dirección-empresa
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class EmpresasCuentas extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('empresas'); 
        $this->belongs_to('cuentas');
    }
    
    /**
     * Método que retorna los recursos asignados a un perfil de usuario
     * @param int $perfil Identificador el perfil del usuario
     * @return array object ActieRecord
     */
    public function getEmpresasCuentas($empresa) {
        $empresa     = Filter::get($empresa,'numeric');
        $columnas   = 'empresas_cuentas.*, cuentas.cuenta, cuentas.sucursal, cuentas.claveinterbancaria, cuentas.cu_referencia, cuentas.bancos_id, bancos.b_nombrecorto';
        $join       = 'INNER JOIN cuentas ON cuentas.id = empresas_cuentas.cuentas_id ';  
        $join.='INNER JOIN bancos ON bancos.id = cuentas.bancos_id';
        $condicion  = "empresas_cuentas.empresas_id = '$empresa'";
//        $order      = 'recurso.modulo ASC, recurso.controlador ASC,  recurso.recurso_at ASC';        
        return $this->find("columns: $columnas", "join: $join", "conditions: $condicion");        
    }
}