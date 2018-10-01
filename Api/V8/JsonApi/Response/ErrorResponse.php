<?php
namespace Api\V8\JsonApi\Response;

class ErrorResponse implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $detail;
    
    private $exception;
    
    protected $debugExceptions;
    
    public function __construct($debugExceptions = false) {
        $this->debugExceptions = $debugExceptions;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }
    
    public function setException(\Exception $exception) {
        $this->exception = $exception;
    }
    
    protected static function exceptionToArray(\Exception $exception) {
        return [
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
            'previous' => self::exceptionToArray($exception->getPrevious()),
            'trace' => $exception->getTrace(),
            'traceAsString' => $exception->getTraceAsString(),
        ];
    }
    
    public function getExceptionArray() {
        if (!$this->exception) { 
            return null;
        } 
        return self::exceptionToArray($this->exception);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $ret = [
            'errors' => [
                'status' => $this->getStatus(),
                'title' => $this->getTitle(),
                'detail' => $this->getDetail(),
            ]
        ];
        
        // do it only in debug mode!!!!
        if ($this->debugExceptions) {
            $ret['errors']['exception'] = $this->getExceptionArray();
        }
        
        return $ret;
    }
}
