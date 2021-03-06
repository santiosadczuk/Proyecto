<?php
namespace App\Modelos;

use App\Modelos\Producto;
use App\Modelos\Usuario;
use App\Modelos\DB;


abstract class DB {

	static private $dsn= 'mysql:host=200.68.105.36;dbname=uv025077_proyectox';
	static private $user = 'uv025077_proyX';
	static private $pass = '2sJ[NQRLe8xBxDVUx7r2BCpmjUr9hV@2*h?wtM62G/UbsbFErAoi({HUE[P]x';
	static private $opt = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

	public static function conectar(){
		try {

    		$conex = new \PDO( self::$dsn, self::$user, self::$pass, self::$opt );
    		return $conex;

  		} catch( PDOException $exception ) {

    		$error = 'El error es: ' . $exception->getMessage();
  			return $error;

  		}
	}
	 /**
     * @param
     * @return array [$this, $response];
     */
    public static function guardarProducto(Producto $producto) {
    	try {
    	$sql = 'INSERT INTO productos (nombre, marca, descripcion, categoria, precio, foto, stock, destacado) VALUES (:nombre, :marca, :descripcion, :categoria, :precio, :foto, :stock, :destacado)';
    	$pdo = self::conectar();
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindValue(':nombre', $producto->getNombre(), \PDO::PARAM_STR);
    	$stmt->bindValue(':marca', $producto->getMarca(), \PDO::PARAM_STR);
    	$stmt->bindValue(':descripcion', $producto->getDescripcion(), \PDO::PARAM_STR);
    	$stmt->bindValue(':categoria', json_encode($producto->getCategoria()), \PDO::PARAM_STR);
    	$stmt->bindValue(':precio', $producto->getPrecio(), \PDO::PARAM_INT);
    	$stmt->bindValue(':foto', $producto->getFoto(), \PDO::PARAM_STR);
        $stmt->bindValue(':stock', $producto->getStock(), \PDO::PARAM_STR);
    	$stmt->bindValue(':destacado', $producto->getDestacado(), \PDO::PARAM_INT);
    	$stmt->execute();
    	$resp = "Se guardó el producto con éxito";
	    } catch(\	PDOException $exception) {
	    	$resp = "Se produjo un error: {$exception->getMessage()}";
	    }
	    return  $pdo->lastInsertId();
    }

    /**
     * @param params
     * @return returns?
     */
    public static function traerPorEmail($email){
    	$sql = 'SELECT * FROM usuarios WHERE email = :email';
    	$stmt = self::conectar()->prepare($sql);
    	$stmt->execute([
    		':email' => $email
    	]);
    	$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
    	return $usuario ? $usuario : false;
    }

		public static function guardarUsuario(Usuario $usuario) {
			try {
				$pdo = DB::conectar();
				$sql = 'INSERT INTO usuarios (nombre, apellido, email, sexo, nacionalidad, nacimiento, direccion, cp, telefono, dni, avatar, contrasenia ) VALUES (:nombre, :apellido, :email, :sexo, :nacionalidad, :nacimiento, :direccion, :cp, :telefono, :dni, :avatar, :contrasenia)';
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':nombre', $usuario->getNombre(), \PDO::PARAM_STR);
				$stmt->bindValue(':apellido', $usuario->getApellido(), \PDO::PARAM_STR);
				$stmt->bindValue(':email', $usuario->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':sexo', $usuario->getSexo(), \PDO::PARAM_STR);
        $stmt->bindValue(':nacionalidad', $usuario->getNacionalidad(), \PDO::PARAM_STR);
        $stmt->bindValue(':nacimiento', $usuario->getNacimiento(), \PDO::PARAM_STR);
        $stmt->bindValue(':direccion', $usuario->getDireccion(), \PDO::PARAM_STR);
        $stmt->bindValue(':cp', $usuario->getCp(), \PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $usuario->getTelefono(), \PDO::PARAM_STR);
        $stmt->bindValue(':dni', $usuario->getDni(), \PDO::PARAM_STR);
        $stmt->bindValue(':avatar', $usuario->getFoto(), \PDO::PARAM_STR);
				$stmt->bindValue(':contrasenia', $usuario->getContrasenia(), \PDO::PARAM_STR);

				$stmt->execute();
				$resp = "Usuario registrado con exito";
			} catch(\	PDOException $exception) {
			  	$resp = "Se produjo un error: {$exception->getMessage()}";
			}
			return $pdo->lastInsertId();
		}

}
