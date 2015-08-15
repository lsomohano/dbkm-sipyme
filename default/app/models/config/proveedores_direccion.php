<?php

/**
 *
 * Descripcion: Clase que gestiona la relación dirección-empresa
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class ProveedoresDireccion extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('proveedores'); 
        $this->belongs_to('direcciones');
    }
    
    /**
     * Método que retorna los recursos asignados a un perfil de usuario
     * @param int $perfil Identificador el perfil del usuario
     * @return array object ActieRecord
     */
    public function getProveedoresDireccion($proveedores) {
        $proveedores     = Filter::get($proveedores,'numeric');
        $columnas   = 'proveedores_direccion.*, direcciones.nombre_dir, direcciones.calle, direcciones.num_esterior, direcciones.colonia, direcciones.codigo_postal';
        $join       = 'INNER JOIN direcciones ON direcciones.id = proveedores_direccion.direcciones_id';        
        $condicion  = "proveedores_direccion.proveedores_id = '$proveedores'";
//        $order      = 'recurso.modulo ASC, recurso.controlador ASC,  recurso.recurso_at ASC';        
        return $this->find("columns: $columnas", "join: $join", "conditions: $condicion");        
    }
}