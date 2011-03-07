<?

require_authenticated();

$e = ErrorLog::find_by_id($params['id']);
if ($e) {
  $e->delete();
  flash_next("Deleted $e->message");
}
redirect_to(list_error_logs_url());