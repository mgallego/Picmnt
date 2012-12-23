set :stages,        %w(development preproduction production)
set :default_stage, "development"
set :stage_dir,     "app/config/stages"
require 'capistrano/ext/multistage'
