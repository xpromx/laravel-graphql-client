<?php

namespace Travelience\Seo;

class GraphQL
{

    protected $key = 'grarphql';
    protected $host = false;
    protected $token = false;
    protected $errors = false;
    protected $minutes = false;

    public function __construct( $host=false, $token=false )
    {
        $this->host = ( $host ?? config('graphql.host') );
        $this->token = $token;
        $this->minutes = config('graphql.minutes');
    }

    public function getToken( $token )
    {
        $this->token = $token;
    }

    public function query( $query, $params=[], $cache=false )
    {

        // query in cache?
		if( $data = $this->cache( $query ) )
		{
			return $data;
        }
        
        // reset errors
        $this->errors = false;

        // curl to host
        $ch = curl_init( $this->host );

        $params = array_merge($params, ['query' => $query]);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = @curl_exec($ch);
        curl_close($ch);

        $data = json_decode($r);

        // check if we have errors
        if( $this->errors )
        {
            $this->errors[] = $this->errors['message'];

            if( isset( $this->errors['validation'] ) )
            {
                $this->errors = array_merge( $this->errors, $this->errors['validation'] );
            }

            return false;
        }

        // return response
        return $this->cache( $query,  $data->data, ( $cache > 1 ? $cache : $this->minutes ) );

    }

    public function cache( $query, $params=[], $cache=false )
    {
        return $this-query( $query, $params, $cache );
    }

    public function cacheResponse( $query, $data=false, $minutes=720 )
    {
        $key = md5($query);

        if( $data )
        {
            cache( [$key => $data], $minutes);
            return $data;
        }

        if( $data = cache($key) )
        {
            return $data;
        }

        return false;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function hasError()
    {
        if( $this->errors )
        {
            return true;
        }

        return false;
    }

    public function getErrorMessage()
    {
        if( !$this->hasError() )
        {
            return false;
        }

        return $this->errors[0];
    }


}