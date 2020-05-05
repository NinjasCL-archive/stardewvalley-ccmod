<?php 
namespace App;

// from http://keltdockins.com/2014/03/20/2014-03-20_serve-then-remove-temporary-file-using-laravel/

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use \Illuminate\Support\Facades\Response;

class Download extends Response
{
    static public function file($fileName, $name = null, array $headers = array())
    {
        $file = new File((string) $fileName);
        $base = $name ?: basename($fileName);
        $content = file_get_contents($fileName);
 
        $response = Response::make($content);
 
        if (!isset($headers['Content-Type']))
        {
            $headers['Content-Type'] = $file->getMimeType();
        }
 
        if (!isset($headers['Content-Length']))
        {
            $headers['Content-Length'] = $file->getSize();
        }
 
        if (!isset($headers['Content-disposition']))
        {
            $headers['Content-disposition'] = 'attachment; filename=' . $base;
        }
 
        foreach ($headers as $headerName => $headerValue)
        {
            $response->header($headerName, $headerValue);
        }
 
        unlink($fileName);
 
        return $response;
    }
}