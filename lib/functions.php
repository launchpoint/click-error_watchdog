<?

// error handler function
function error_handler($errno, $errstr, $errfile, $errline)
{
  global $run_mode;

  switch($run_mode)
  {
    case RUN_MODE_DEVELOPMENT:
    case RUN_MODE_TEST:
      if(CLI)
      {
        eprint( "\n--------------\n$errstr\n");
        foreach(debug_backtrace() as $trace)
        {
          if (array_key_exists('file', $trace)) eprint( "\t".$trace['file']);
          if (array_key_exists('line', $trace)) eprint( "\t".$trace['line']);
          if (array_key_exists('function', $trace)) eprint( "\t".$trace['function']);
          eprint( "\n");
        }
      } else {
        eprint( "<br/><h1>$errstr</h1>");
        eprint( "<table>");
        foreach(debug_backtrace() as $trace)
        {
          eprint( "<tr>");
          eprint( "<td>");
          if (array_key_exists('file', $trace)) eprint( htmlentities($trace['file']));
          eprint( "</td>");
          eprint( "<td>");
          if (array_key_exists('line', $trace)) eprint( htmlentities($trace['line']));
          eprint( "</td>");
          eprint( "<td>");
          if (array_key_exists('function', $trace)) eprint( htmlentities($trace['function']));
          eprint( "</td>");
          eprint( "</tr>");
        }
        eprint( "</table>");
      }
      
      trigger_error("Fatal development mode error.",E_USER_ERROR);
      break;
    case RUN_MODE_STAGING:
    case RUN_MODE_PRODUCTION:
      $key = md5("$errno|$errstr|$errfile|$errline");
      $err = ErrorLog::find_or_create_by( array(
        'conditions'=>array('token = ?', $key),
        'attributes'=>array(
          'code'=>$errno,
          'line_number'=>$errline,
          'fpath'=>$errfile,
          'message'=>$errstr,
          'token'=>$key,
          'backtrace'=>debug_backtrace()
        )
      ));
      $err->count++;
      $err->save();
      break;
  }
}

function exception_handler($exception) {
  eprint( "Uncaught exception: " , $exception->getMessage(), "\n");
  eprint( "<pre>");
  eprint(s_var_export($exception));
//  var_dump(get_object_vars($exception));
  eprint( "</pre>");
}


