<?php

require_once('config.inc');
require_once('lcmess.inc');

define('dbh', pg_connect($conn_str));
if (!dbh) {
        die ("Could not connect to the server");
}

_set_lc_messages();

$res = pg_query(dbh, "CREATE OR REPLACE FUNCTION test_notice() RETURNS boolean AS '
begin
        RAISE NOTICE ''11111'';
        return ''f'';
end;
' LANGUAGE plpgsql;");

function tester() {
        $res = pg_query(dbh, 'SELECT test_notice()');
        $row = pg_fetch_row($res, 0);
		var_dump($row);
        pg_free_result($res);
        if ($row[0] == 'f')
        {
                var_dump(pg_last_notice(dbh));
        }
}
tester();

pg_close(dbh);

?>
===DONE===