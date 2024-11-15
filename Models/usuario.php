<?php
require_once('conexion.php');

class Usuario extends conexion{
	
	private $IdUsuarios;
	private $Nombre ;
	private $Email;
	private $Clave;
        private $PreguntaS;
        private $Respuesta;
        

        /* Setters and Getters*/
        public function getIdUsuarios() {
            return $this->IdUsuarios;
        }

        public function getNombre() {
            return $this->Nombre;
        }

        public function getEmail() {
            return $this->Email;
        }

        public function getClave() {
            return $this->Clave;
        }

        public function setIdUsuarios($IdUsuarios) {
            $this->IdUsuarios = $IdUsuarios;
        }

        public function setNombre($Nombre) {
            $this->Nombre = $Nombre;
        }

        public function setEmail($Email) {
            $this->Email = $Email;
        }

        public function setClave($Clave) {
            $this->Clave = $Clave;
        }
        
        public function getPreguntaS() {
            return $this->PreguntaS;
        }

        public function getRespuesta() {
            return $this->Respuesta;
        }

        public function setPreguntaS($PreguntaS) {
            $this->PreguntaS = $PreguntaS;
        }

        public function setRespuesta($Respuesta) {
            $this->Respuesta = $Respuesta;
        }

                
         function __destruct() {
        $this->Disconnect();
    }

	public function __construct($admin=array()){
        parent::__construct();
		if(count($admin)>1){
			foreach ($admin as $campo=>$valor){
                $this->$campo = $valor;
			}
		}else {
			$this->Nombre = "";
			$this->Email = "";
			$this->Clave = "";
                        $this->PreguntaS = "";
                        $this->Respuesta = "";
			
		}
    }

    public function insertar(){
        $this->insertRow("INSERT INTO usuarios
            VALUES (NULL, ?, ?, ?, ?, ?)", array(
                $this->Nombre,
                $this->Email,
                $this->Clave,
                $this->PreguntaS,
                $this->Respuesta,
               )
        );
		$this->Disconnect();
    }

    public function editar(){
		$arrAdmin = (array) $this;
		$this->updateRow("UPDATE Usuarios SET  Nombre = ?, Email = ?, Clave = ?, PreguntaS = ?, Respuesta = ? WHERE IdUsuarios = ?", array(
	    $this->Nombre,
            $this->Email,
            $this->Clave,
            $this->PreguntaS,
            $this->Respuesta,
            $this->IdUsuarios,
		));
		$this->Disconnect();
    }
    public static function getAll(){
		return usuario::buscar("SELECT * FROM Usuarios",array());
    }
    
	public static function buscar($query, $param){
        $arrUser = array();
        $tmp = new usuario();
        $getrows = $tmp->getRows($query, $param);
        
        foreach ($getrows as $valor) {
            $us = new usuario();
            $us->IdUsuarios = $valor['IdUsuarios'];
            $us->Nombre = $valor['Nombre'];
            $us->Email = $valor['Email'];
            $us->Clave = $valor['Clave'];
            $us->PreguntaS = $valor['PreguntaS'];
            $us->Respuesta = $valor['Respuesta'];
           
            
            array_push($arrUser, $us);
        }
        $tmp->Disconnect();
        return $arrUser;
    }

    public function actualizar($query, $param){
        $arrAdmin = array();
        $tmp = new usuario();
        $this->updateRow($query, $param);	
        
        $tmp->Disconnect();        
        return $arrAdmin;

    }

    public function eliminar(){
        return $this->Email;
    }

    public static function buscarForId($id){
		if ($id > 0){
			$us = new usuario();
			$getrow = $us->getRow("SELECT * FROM Usuarios WHERE IdUsuarios =?", array($id));
			$us->IdUsuarios = $getrow['IdUsuarios'];
			$us->Nombre = $getrow['Nombre'];
			$us->Email = $getrow['Email'];
                        $us->Clave = $getrow['Clave'];
                        $us->PreguntaS = $getrow['PreguntaS'];
                        $us->Respuesta = $getrow['Respuesta'];
			
			
			$us->Disconnect();
			return $us;
		}else{
			return NULL;
		}
		$this->Disconnect();
    }
    
    
    

}
?>
