<?php

namespace Travelience\GraphQL;

class Response
{
    protected $data = false;
    protected $errors = false;

    /**
     * Constructor of the response
     *
     * @param  object  $data
     * @param  string  $query
     * @param  integer $cache;
     * @return Response
     */
    public function __construct( $data, $query, $cache=false )
    {
        $this->data = $data;

        // check if we have errors
        if( property_exists($data, 'errors') )
        {
            $this->errors[] = $data->errors[0]->message ;

            if(property_exists( $data->errors[0], 'validation' ) )
            {
                $this->errors = array_merge( $this->errors, $data->errors[0]->validation );
            }

        }

        if( !$this->hasErrors() && $cache )
        {
            $this->cache( $query, $data, $cache );
        }

        return $this;

    }

    /**
     * Get one of the response query
     *
     * @param  string  $key
     * @return Collection
     */
    public function get( $key )
    {
        if( $this->hasErrors() )
        {
            return true;
        }

        if( property_exists( $this->data->data, $key ) )
        {
            return collect($this->data->data->$key);
        }

        return false;
    }

    /**
     * return the errors for this response
     *
     * @return Collection
     */
    public function errors()
    {
        return collect($this->errors);
    }

    /**
     * Check if the response has errors
     *
     * @return boolean
     */
    public function hasErrors()
    {
        if( $this->errors )
        {
            return true;
        }

        return false;
    }

    /**
     * Get first error message
     *
     * @return string
     */
    public function getErrorMessage()
    {
        if( !$this->hasErrors() )
        {
            return false;
        }

        return $this->errors[0];
    }

    /**
     * Cache the query response
     *
     * @param  string  $query
     * @param  object  $data
     * @param  integer $minutes;
     * @return boolean
     */
    public function cache( $query, $data=false, $minutes=720 )
    {
        $key = md5($query);

        if( $data->data )
        {
            cache( [$key => $data], $minutes);
            return true;
        }

        return false;
    }


    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
     public function __get($key)
     {
         return $this->get($key);
     }

}

