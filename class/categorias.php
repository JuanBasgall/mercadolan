<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
//include './autoload.php';

class categorias {
    /*@autor Juan Angel Basgall*/
    protected $id;
    public $nombre_categoria;
    private $exist;
    
    public function __construct($id = null) {
        if ($id != null){
            $db = base_datos::conect();
            $resp = $db->select("categorias", "id=?", array($id));
            
            if (isset($resp)){
                //echo "<br>El método construct se conectó con la base de datos..<br>";  
            } else {
                echo "<br>No se conectó con la base de datos..<br> ";
            }
            if (isset($resp[0]['id'])){
                $this->id = $resp[0]['id'];
                $this->nombre_categoria = $resp[0]['nombre_categoria'];
                $this->exist = true;
            } else {
                echo "<br>Objeto inexistente en la base de datos..";
                //throw new Exception ("Error al cargar");
            }
        } else {
            #echo "<br> el ID es nulo<br>";
        }
        
    }
    
    public function mostrar(){
        echo "<br>-------------------------------------";
        echo"<pre>";
        var_dump($this);
        print_r($this);
        echo "</pre>";
        echo "<br>-------------------------------------";
    }
    
    public function guardar(){
        if($this->exist){
            return $this->actualizar();
        } else {
            return $this->insertar();
        }
    }
    
    public function eliminar(){
        $db = base_datos::conect();
        return $db->delete("categorias", "id=" . $this->id);
    }
    public function insertar(){
        $db = base_datos::conect();
        $resp = $db->insert("categorias", "nombre_categoria", "?", array($this->nombre_categoria));
        
        if ($resp){
            $this->id = $resp;
            $this->exist = true;
            return true;
        } else {
            echo "<br>Error en la respuesta de insertado la base de datos!!!<br>";
            return false;
        }
        echo "<br>Se agrego correctamente<br>";
    }
    
    public function actualizar(){
        $db = base_datos::conect();
        return $db->update("categorias", "nombre_categoria=?", "id=?",
                array($this->nombre_categoria, $this->id));
    }
    
    static function listar($filtro = null){
        $db = base_datos::conect();
        return $db->select("categorias", $filtro);
    }
    
    static function nombrecat($id_cat){
        $db = base_datos::conect();
        $nombrecat =  $db->select('categorias', 'id='.$id_cat);
        $nombre = $nombrecat[0]['nombre_categoria'];
        return $nombre;
        
    }
    public function get_codigo(){
        return $this->id;
    }
}

//$nuevaCategoria = new categorias(23);
//$nuevaCategoria->nombre_categoria = "celulaes";
//$nuevaCategoria->mostrar();
//$nuevaCategoria->guardar();


/*

$categoria= new Categorias(intval($_POST["numeroCategoria"]));
$categoria->guardar($arr_prepare=[htmlspecialchars($_POST["descripcion"])]);
 * 
 */