<?php 
class Database {
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct() {
        $this->host = constant('HOST');;
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset = constant('CHARSET');
    }
//PDO (PHP Data Objects) interfaz para acceso a BD en PHP, conexión a una base de datos MySQL y devuelve un objeto PDO que puedes usar para ejecutar consultas SQL.
     function connect() {
       
        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Lanza excepciones si ocurre un error en la base de datos.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,//Las consultas devolverán resultados como arreglos asociativos (clave = nombre de columna).
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options); //objeto PDO es la cadena de conexion y se puede reutilizar.
            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection:' . $e->getMessage());
        }  
    } 
}
?>

