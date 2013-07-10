
exec { 'apt-get-update':
  command => 'apt-get update',
  path    => '/usr/bin/',
  timeout => 60,
  tries   => 3,
}

class { 'apt':
  always_apt_update => false,
}

package { ['python-software-properties']:
  ensure  => 'installed',
  require => Exec['apt-get-update'],
}

file { '/home/vagrant/.bash_aliases':
  ensure => 'present',
  source => 'puppet:///modules/puphpet/dot/.bash_aliases',
}

package { [    'build-essential',
    'vim',
    'curl',
    'emacs']:
  ensure  => 'installed',
  require => Exec['apt-get-update'],
}

class { 'apache':
  require => Exec['apt-get-update'],
}

apache::dotconf { 'custom':
  content => 'EnableSendfile Off',
}

apache::module { 'rewrite': }

apache::vhost { 'picmnt.dev':
  server_name   => 'picmnt.dev',
  serveraliases => [],
  docroot       => '/var/www/',
  port          => '80',
  env_variables => [],
  priority      => '1',
}

apt::ppa { 'ppa:ondrej/php5':
  before  => Class['php'],
}

class { 'php':
  service       => 'apache',
  module_prefix => '',
  require       => [Exec['apt-get-update'], Package['apache']],
}

php::module { 'php5-mysql': }
php::module { 'php5-cli': }
php::module { 'php5-curl': }
php::module { 'php5-intl': }
php::module { 'php5-mcrypt': }
php::module { 'php-apc': }

class { 'php::devel':
  require => Class['php'],
}

class { 'php::pear':
  require => Class['php'],
}


php::pecl::module { 'imagick':
  use_package => false,
}

class { 'xdebug':
  service => 'apache',
}

php::pecl::module { 'xhprof':
  use_package     => false,
  preferred_state => 'beta',
}

apache::vhost { 'xhprof':
  server_name => 'xhprof',
  docroot     => '/var/www/xhprof/xhprof_html',
  port        => 80,
  priority    => '1',
  require     => Php::Pecl::Module['xhprof']
}


class { 'composer':
  require => Package['php5', 'curl'],
}

puphpet::ini { 'xdebug':
  value   => [
    'xdebug.default_enable = 1',
    'xdebug.remote_autostart = 0',
    'xdebug.remote_connect_back = 1',
    'xdebug.remote_enable = 1',
    'xdebug.remote_handler = "dbgp"',
    'xdebug.remote_port = 9000'
  ],
  ini     => '/etc/php5/conf.d/99-xdebug.ini',
  notify  => Service['apache'],
  require => Class['php'],
}
puphpet::ini { 'php':
  value   => [
    'date.timezone = "Europe/Madrid"'
  ],
  ini     => '/etc/php5/conf.d/99-php.ini',
  notify  => Service['apache'],
  require => Class['php'],
}
puphpet::ini { 'custom':
  value   => [
    'display_errors = On',
    'error_reporting = -1'
  ],
  ini     => '/etc/php5/conf.d/99-custom.ini',
  notify  => Service['apache'],
  require => Class['php'],
}

class { 'mysql':
  root_password => 'P4ssW0rd',
  require       => Exec['apt-get-update'],
}


class { 'phpmyadmin':
  require => Class['mysql'],
}

apache::vhost { 'phpmyadmin':
  server_name => 'phpmyadmin',
  docroot     => '/usr/share/phpmyadmin',
  port        => 80,
  priority    => '10',
  require     => Class['phpmyadmin'],
}

