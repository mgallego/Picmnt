
# Install language package
node['locales']['locales'].each do |locale|
  package("language-pack-#{locale}") { action :install }
end