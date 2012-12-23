set :application, "Picmnt"
set :domain,      "server_picmnt_pre"
set :deploy_to,   "/var/www/Picmnt"
set :app_path,    "app"
set :user, "picmnt"
set :port, 22123

set :repository,  "git://github.com/mgallego/Picmnt.git"
set :scm,         :git
set :model_manager, "doctrine"
set :branch, "Dev"
set :deploy_migrations_interactive, false

set :shared_files,      ["app/config/parameters.yml", "src/SFM/PicmntBundle/Resources/views/Addons/analytics.html.twig", "src/SFM/PicmntBundle/Resources/views/Addons/uservoice.html.twig"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]

set :use_composer, true
set :vendors_mode, "install"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set :use_sudo, false
set :keep_releases,  3

logger.level = Logger::MAX_LEVEL

set :writable_dirs,     ["app/cache", "app/logs", "web/uploads"]
set :webserver_user,    "www-data"
set :permission_method, :acl

set :use_set_permissions, true

set :clear_controllers, false#['app_dev.php', 'app_test.php', 'config.php']

#before "symfony:bootstrap:build", "deploy:set_permissions"

after "deploy", "deploy:cleanup"
