<?php
	/* FFI implementation of ext/ctype */

class ctype extends ffi
{
	function __call($method, $args)
	{
		if (strncasecmp($method, 'ctype_', 6)) {
			return FALSE;
		}
		$str = (string) $args[0];

		$i = 0;
		$l = strlen($str);

		while ($i < $l) {
			if (!$this->{substr($method, 6)}($str[$i++])) {
				return FALSE;
			}
		}

		return TRUE;
	}

	function __construct()
	{
		parent::__construct(<<<EOD
[lib='libc.so.6']
	int isalnum (int c);
	int isalpha (int c);
	int isascii (int c);
	int isblank (int c);
	int iscntrl (int c);
	int isdigit (int c);
	int isgraph (int c);
	int islower (int c);
	int isprint (int c);
	int ispunct (int c);
	int isspace (int c);
	int isupper (int c);
	int isxdigit (int c);
EOD
		);
	}
}

	$ctype = new ctype();
	var_dump($ctype->ctype_isdigit(7343.32));
?>