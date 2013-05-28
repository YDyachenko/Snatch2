<?php

namespace Core\Http;

class Response
{
    
    protected $headers = array();
    protected $body = '';
    protected $statusCode = 200;
    protected $reasonPhrase;
    protected $version;


    /**
     * @var array Recommended Reason Phrases
     */
    protected $recommendedReasonPhrases = array(
        // INFORMATIONAL CODES
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        // SUCCESS CODES
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        // REDIRECTION CODES
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy', // Deprecated
        307 => 'Temporary Redirect',
        // CLIENT ERROR
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        // SERVER ERROR
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    );

    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setReasonPhrase($phrase)
    {
        $this->reasonPhrase = $phrase;
        return $this;
    }
    
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        
        return $this;
    }
    
    /**
     * Render the status line header
     *
     * @return string
     */
    public function renderStatusLine()
    {
        $status = sprintf(
            'HTTP/%s %d %s',
            $this->version,
            $this->statusCode,
            $this->getReasonPhrase()
        );
        return trim($status);
    }
    
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    
    public function getReasonPhrase()
    {
        if (null == $this->reasonPhrase) {
            if (isset($this->recommendedReasonPhrases[$this->statusCode])) 
                return $this->recommendedReasonPhrases[$this->statusCode];
            
            throw new \RuntimeException('Not found reason phrase');
        }
        
        return $this->reasonPhrase;
    }
    
    public function sendHeaders()
    {
        header($this->renderStatusLine());
        
        foreach($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }
        
        return $this;
    }
    
    public function setRedirect($url, $code = 302)
    {
        $this->setHeader('Location', $url)
             ->setStatusCode($code);

        return $this;
    }
    
    public function appendBody($body)
    {
        $this->body .= $body;
        
        return $this;
    }
    
    public function clearBody()
    {
        $this->body = '';
        
        return $this;
    }
    
    public function outputBody()
    {
        echo $this->body;
    }
    
}