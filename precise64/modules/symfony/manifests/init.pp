# Class: symfony
#
# Entrypoint for a Symfony2 project installation on the machine.
#
# Requirements:
#   composer has to be installed and has to be available
#   as "composer" in the system.
#
class symfony (
  $composer_update = true,
) {

  if $composer_update {
    exec { 'symfony_composer_update':
      name => 'composer self-update',
      path => ['/usr/bin', '/usr/local/bin'],
    }
  }

}