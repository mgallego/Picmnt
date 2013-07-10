maintainer        "Folken Laëneck"
maintainer_email  "folken.laeneck@gmail.com"
license           "Apache 2.0"
description       "Installs GNU gettext"
version "1.0.0"

%w{debian ubuntu}.each do |os|
  supports os
end

depends "apt"

recipe "gettext", "Installs GNU gettext"