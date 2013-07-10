maintainer        "Folken Laëneck"
maintainer_email  "folken.laeneck@gmail.com"
license           "Apache 2.0"
description       "Installs and setup PHPMyAdmin"
version           "1.0.0"

%w{debian ubuntu}.each do |os|
  supports os
end

depends "apt"
depends "php5-fpm-nginx"
depends "mysql"

recipe "phpmyadmin", "Installs PHPMyAdmin using packages."