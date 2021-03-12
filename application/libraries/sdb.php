<?php

	class sdb{

        private $QueryID;
        private $InsertID;    
		
        function conectDB(){  
             
            $hostname = "10.0.1.3";        	 
            $username = "egweb";
            $password = "53g53pr0";
        	$dbname   = "sepromex"; 
        	
        	$conexion = mysqli_connect($hostname,$username, $password) or die ("No se ha podido conectar al servidor de Base de datos".mysqli_error());
        	$db = mysqli_select_db($conexion,$dbname) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
        	
        	return $conexion;
        }
         
        function select_array($query){
            $result = mysqli_query($this->conectDB(),$query);
            $rows = array();
                while($row = mysqli_fetch_assoc($result))
                { 
                    $rows[] = $row;
                }
            return $rows; 
        }
        

        function query($query){
            $conex = $this->conectDB();
            $curso = mysqli_query($conex,$query);           
            $this->InsertID = mysqli_insert_id($conex);
        }
                 
        function num_rows($query){
            $result = mysqli_query($this->conectDB(),$query);
            $result = mysqli_num_rows($result);
            return $result;
        }

        function MaxId(){
            $result = mysqli_insert_id($this->conectDB());            
            return $result;
        }

        function last_insert(){
            return $this->InsertID;
        }
    }

 
?>
