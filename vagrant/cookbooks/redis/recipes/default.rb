# Install Redis
%w{redis-server}.each do |pkg|
  package pkg do
    action :install
  end
end

service 'redis-server' do
  supports :status => true, :restart => true, :reload => true
  action :enable
end

service 'redis-server' do
  supports :status => true, :restart => true, :reload => true
  action :start
end