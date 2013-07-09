
# Install PHP5-FPM
%w{php5-mysql php5-curl php5-gd php5-mcrypt php5-sqlite php5-tidy php5-xmlrpc php5-xsl php5-redis php5-cli}.each do |pkg|
  package pkg do
    action :install
  end
end

template "#{node['nginx']['dir']}/conf.d/php5-fpm.conf" do
  source "php5-fpm.conf.erb"
  owner "root"
  group "root"
  mode "0644"
end

template "/etc/php5/fpm/pool.d/www.conf" do
  source "pool.conf.erb"
  owner "root"
  group "root"
  mode "0644"
end

service 'php5-fpm' do
  supports :status => true, :restart => true, :reload => true
  action :enable
end

%W{php5-fpm nginx}.each do |s|
  service s do
    action :restart
  end
end