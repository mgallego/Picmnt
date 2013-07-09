
# Install phpmyadmin
package('phpmyadmin') { action :install }

template "#{node['nginx']['dir']}/sites-available/phpmyadmin" do
  source "phpmyadmin.vhost.erb"
  owner "root"
  group "root"
  mode "0644"
  
  notifies :reload, "service[nginx]"
end

nginx_site 'phpmyadmin'