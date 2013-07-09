# Install NFS client libraries
%w{nfs-common}.each do |pkg|
  package pkg do
    action :install
  end
end 
