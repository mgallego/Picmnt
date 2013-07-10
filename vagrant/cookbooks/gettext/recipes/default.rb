# Install Gettext
%w{gettext}.each do |pkg|
  package pkg do
    action :install
  end
end