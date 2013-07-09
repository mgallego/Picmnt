# Install Bindfs
%w{bindfs}.each do |pkg|
  package pkg do
    action :install
  end
end 
