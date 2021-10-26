{ pkgs }: {
	deps = [
    (pkgs.php.buildEnv {
    	extraConfig = "
      error_reporting=On
      zend_extension=${pkgs.phpExtensions.xdebug}/lib/php/extensions/xdebug.so 
      ";
    })
    pkgs.phpExtensions.curl
    pkgs.phpExtensions.mbstring
    pkgs.phpExtensions.pdo
    pkgs.phpExtensions.opcache
    pkgs.phpExtensions.xdebug
    pkgs.phpPackages.composer
	];
}