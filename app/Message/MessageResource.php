<?php
namespace App\Message;
class MessageResource
{
   public $msg;
   public $msgname;
   public $code;

//    function __construct($msgname, $msg, $code)
//    {
//      $this->msgname = $msgname;
//      $this->msg = $msg;
//      $this->code = $code;
//    }
   public function print($msgname, $msg, $code)
   {
    $this->msgname = $msgname;
    $this->msg = $msg;
    $this->code = $code;
       $data = [
           $this->msgname => $this->msg,
       ];

       return response()->json(['data' => $data], $this->code);
   }
}