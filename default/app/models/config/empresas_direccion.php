<?php

/**
 *
 * Descripcion: Clase que gestiona la relación dirección-empresa
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class EmpresasDireccion extends ActiveRecord {
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {        
        $this->belongs_to('empresas'); 
        $this->belongs_to('direcciones');
    }
    
    /**
     * Método que retorna los recursos asignados a un perfil de usuario
     * @param int $perfil Identificador el perfil del usuario
     * @return array object ActieRecord
     */
    public function getEmpresasDireccion($empresa) {
        $empresa     = Filter::get($empresa,'numeric');
        $columnas   = 'empresas_direccion.*, direcciones.nombre_dir, direcciones.calle, direcciones.num_esterior, direcciones.colonia, direcciones.codigo_postal';
        $join       = 'INNER JOIN direcciones ON direcciones.id = empresas_direccion.direcciones_id';        
        $condicion  = "empresas_direccion.empresas_id = '$empresa'";
//        $order      = 'recurso.modulo ASC, recurso.controlador ASC,  recurso.recurso_at ASC';        
        return $this->find("columns: $columnas", "join: $join", "conditions: $condicion");        
    }
    
    public function saveEmpresaDireccion($empresa_id, $nombre_dir){
        $dirc = new direcciones();
        $condicion  = "direcciones.nombre_dir = '$nombre_dir'";
        $direcciones_id = $dirc->find('columns: direcciones.id', "conditions: $condicion");
        
        $this->empresas_id = $empresa_id;
        $this->direcciones_id = $direcciones_id->id;
        $this->save();
    }
}