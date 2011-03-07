<?

$e = ErrorLog::find_all();
$c = count($e);

if ($c>0)
{
  $errors = array(
    link_to("PHP Exceptions ($c)", list_error_logs_url())
  );
}