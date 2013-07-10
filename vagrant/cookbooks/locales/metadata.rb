maintainer        "Folken Laëneck"
maintainer_email  "folken.laeneck@gmail.com"
license           "Apache 2.0"
description       "Setup and compile locales"
version           "1.0.0"

%w{ubuntu}.each do |os|
  supports os
end

recipe "locales", "Setup and compile locales"

attribute "locales/locales",
  :display_name => "Locales",
  :description  => "Locales to set up",
  :default      => ['en']