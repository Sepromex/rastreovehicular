<pre>
<?php
	$databases = [
		['host' => '160.16.18.20:3305', 'user' => 'usercruce', 'pass' => 'server'],
		['host' => '160.16.18.8', 'user' => 'egweb', 'pass' => 'egW@b2009'],
		['host' => 'localhost', 'user' => 'root', 'pass' => '53g53pr0'],
		['host' => '200.39.13.91', 'user' => 'root', 'pass' => '53g53pr0', 'database' => 'sepromex'],
		['host' => '200.39.13.92', 'user' => 'root', 'pass' => '53g53pr0'],
	];


	foreach ($databases as $data) {
		$db = @mysql_connect($data['host'],$data['user'],$data['pass']);
		if (!$db) {
			echo $data['host'].' no conecta.'.mysql_error()."\n";
		} else {
			echo $data['host'].' FUNCIONA!.'."\n";'';
		}
	}
?>
</pre>
