<?

unset($error_log->backtrace['object']);
$error_log->backtrace=__serialize($error_log->backtrace);