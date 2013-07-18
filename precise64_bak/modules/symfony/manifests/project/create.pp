#
# Installs the Symfony2 Standard Edition on the machine.
#
# Parameters:
# version - the Symfony2 version (2.3.0, 2.3.1 etc),
#           if not defined the latest one will be taken
# user    - the owner of the project
#
# Sample usage:
# symfony::project::create { '/var/www/test':
#   user => 'vagrant',
# }
#
define symfony::project::create (
  $version = undef,
  $user    = undef,
) {

  exec { "symfony_project_create_${name}":
    name    => "composer --no-interaction create-project symfony/framework-standard-edition ${name} ${version}",
    creates => $name,
    path    => ['/usr/bin', '/usr/local/bin'],
    user    => $user,
  }

}
