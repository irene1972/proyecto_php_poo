<?php

  class Producto{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;

    private $db;

    public function __construct(){
      $this->db = Database::connect();
    }
  
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
 
    }

    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $this->db->real_escape_string($categoria_id);

    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);

    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $this->db->real_escape_string($descripcion);

    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $this->db->real_escape_string($precio);

    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $this->db->real_escape_string($stock);
        
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function setOferta($oferta)
    {
        $this->oferta = $this->db->real_escape_string($oferta);

    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
  
    }

    public function getAll( $order ){
      $sql = "SELECT * FROM productos ";
      $sql .= " ORDER BY {$order};";
      $productos = $this->db->query($sql);
      return $productos;
    }

    public function getAllByCategory(){
      $sql="SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
            ." INNER JOIN categorias c ON p.categoria_id = c.id "
            ." WHERE p.categoria_id = {$this->getCategoria_id()} AND stock > 0 " 
            . " ORDER BY p.id DESC;";
      //echo $sql;
      $productos = $this->db->query($sql);
      return $productos;
    }

    public function getRandom( $limit ){
        $productos = $this->db->query("SELECT * FROM productos WHERE stock > 0 ORDER BY RAND() LIMIT $limit;");
        return $productos;
      }

    public function getById(){
        $producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()};");
        return $producto->fetch_object();
      }

    public function save(){
      
      $sql="INSERT INTO productos ( id, categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen ) 
                VALUES ( NULL, 
                        '{$this->getCategoria_id()}', 
                        '{$this->getNombre()}', 
                        '{$this->getDescripcion()}', 
                        '{$this->getPrecio()}', 
                        '{$this->getStock()}', 
                        null, CURDATE(), 
                        '{$this->getImagen()}' 
                        );";

      $save = $this->db->query($sql);
  
    //   echo $this->db->error;
    //   die('www');

      $result = false;
  
      if( $save ){
        $result = true;
      }
      
      return $result;
  
    }

    public function edit(){
        //( id, categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen ) 
        $sql = "UPDATE productos SET  nombre = '{$this->getNombre()}', 
                                    descripcion = '{$this->getDescripcion()}', 
                                    precio = '{$this->getPrecio()}', 
                                    stock = '{$this->getStock()}',
                                    categoria_id = {$this->getCategoria_id()}";

        $sql .= ( $this->getImagen() != null ) ? ", imagen = '{$this->getImagen()}'" : "";
        $sql .= " WHERE id = {$this->getId()};";
  
        $save = $this->db->query($sql);
  
        $result = false;
    
        if( $save ){
          $result = true;
        }
        
        return $result;
    
      }

    public function delete(){
        $sql = "DELETE FROM productos WHERE id = {$this->id};";
        $delete = $this->db->query($sql);
        
        $result = false;
  
        if( $delete ){
          $result = true;
        }
        
        return $result;
    }

  }
?>