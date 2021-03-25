<?php
/**
 * Created by PhpStorm.
 * User: Ledev
 * Date: 5/27/2018
 * Time: 6:08 PM
 */

namespace Application\Helpers;


class Collection implements  \IteratorAggregate,\ArrayAccess
{

    private $item;

    public function __construct(array $item = [] )
    {
        $this->item = $item;
    }

    //Methode de recuperation d'entrer de $item
    public function get($key)
    {
        if ( $this->has($key)  ) {
            return $this->item[$key];
        }else {
            return false;
        }
    }




    // put value in Collection
    public function set($key, $value)
    {
        $this->item[$key] = $value ;
    }

    //Methode de verification d'entrer
    public function has($key)
    {
        return array_key_exists($key , $this->item) ;
    }

    //Methode permettant de recuperer deux entrer
    public function lists($key, $value)
    {
        $results = [] ;
        foreach ($this->item as $item) {
            $results[ $item[$key] ] = $item[$value];
        }
        return new Collection($results) ;
    }

    //Methode permettant d'extraire un entrer
    public function extract($key)
    {
        $results = [] ;
        foreach ($this->item as $item) {
            $results[ ] = $item[$key];
        }
        return new Collection($results) ;
    }
    //Methode permettant la jonction
    public function join($glue)
    {
        return implode($glue, $this->item);
    }

    //Methode de recuperation de la valeur max du tableau
    public function max($key = false)
    {
        if ( $key ) {
            return $this->extract($key)->max();
        }else{
            return  max($this->item) ;
        }
    }

    /*
      methode de transformation de l'objet en tableau
    */

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset,$value)
    {
        return $this->set($offset,$value);
    }

    public function offsetUnset($offset)
    {
        if (  $this->has($offset) ) {
            unset($this->item[$offset]) ;
        }
    }


    /*
     Metode de IteratorAggregate
    */
    public function getIterator()
    {
        return new \ArrayIterator($this->item);
    }



}