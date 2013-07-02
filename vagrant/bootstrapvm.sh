#! /bin/bash
apt-get install -y curl libcurl3
if ! [ -x /usr/bin/chef-solo ] ; then
  curl -L --insecure https://www.opscode.com/chef/install.sh | sudo bash
fi
