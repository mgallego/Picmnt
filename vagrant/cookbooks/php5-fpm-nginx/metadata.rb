maintainer        "Folken Laëneck"
maintainer_email  "folken.laeneck@gmail.com"
license           "Apache 2.0"
description       "Installs and setup php5 with PHP-FPM on nginx"
version           "1.0.0"

%w{debian ubuntu}.each do |os|
  supports os
end

depends "apt"
depends "nginx"
depends "redis"

recipe "php5-fpm-nginx", "Installs php5-fpm using packages."

attribute "php5-fpm-nginx/user",
  :display_name => "PHP5-FPM user",
  :description  => "User PHP5-FPM pool will run as",
  :default      => nil
  
attribute "php5-fpm-nginx/group",
  :display_name => "PHP5-FPM group",
  :description  => "Group PHP5-FPM pool will run as",
  :default      => nil

attribute "php5-fpm-nginx/port",
  :display_name => "Listened port",
  :description  => "Port PHP5-FPM pool will listen",
  :default      => '9000'