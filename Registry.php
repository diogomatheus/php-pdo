<?php
/**
 * @author   João Batista Neto
 */

class Registry {
       
    private static $instance;
    private $storage;

    protected function __construct() {
        $this->storage = new ArrayObject();
    }

    public function get( $key ) {
        if ( $this->storage->offsetExists( $key ) ) {
            return $this->storage->offsetGet( $key );
        } else {
            throw new RuntimeException( sprintf( 'Não existe um registro para a chave "%s".' , $key ) );
        }
    }

    public static function getInstance() {
        if ( !self::$instance )
            self::$instance = new Registry();

        return self::$instance;
    }

    public function set( $key , $value ) {
        if ( !$this->storage->offsetExists( $key ) ) {
            $this->storage->offsetSet( $key , $value );
        } else {
            throw new LogicException( sprintf( 'Já existe um registro para a chave "%s".' , $key ) );
        }
    }

    public function unregister( $key ) {
        if ( $this->storage->offsetExists( $key ) ) {
            $this->storage->offsetUnset( $key );
        } else {
            throw new RuntimeException( sprintf( 'Não existe um registro para a chave "%s".' , $key ) );
        }
    }
    
}

