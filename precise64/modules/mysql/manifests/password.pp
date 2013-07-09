#
# Class: mysql::password
#
# Set mysql password
#
class mysql::password {

  # Load the variables used in this module. Check the params.pp file
  require mysql
  require mysql::params

  if (!defined(File['/home/vagrant/root-mysql'])) {
    file { '/home/vagrant/root-mysql':
      ensure  => directory,
      path    => '/home/vagrant/root-mysql',
      group   => 'vagrant',
      owner   => 'vagrant',
      mode    => 0700,
      require => Service['mysql'],
    }
  }

  $my_cnf = '/home/vagrant/root-mysql/.my.cnf'

  file { $my_cnf:
    ensure  => present,
    path    => $my_cnf,
    group   => 'vagrant',
    owner   => 'vagrant',
    mode    => 0644,
    content => template('mysql/root.my.cnf.erb'),
    require => File['/home/vagrant/root-mysql']
  }

  exec { 'mysql_root_password':
    subscribe   => File[$my_cnf],
    path        => '/bin:/sbin:/usr/bin:/usr/sbin',
    refreshonly => true,
    command     => "mysqladmin --defaults-file=${my_cnf} -uroot password '${mysql::real_root_password}'",
    require     => File[$my_cnf],
  }

}
