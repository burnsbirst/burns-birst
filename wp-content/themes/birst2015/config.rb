environment = :development
line_comments = false

http_path = "/"
css_dir = "./"
sass_dir = "scss/"
images_dir = "images"
javascripts_dir = "js"

#add_import_path "../plinth/scss/"

output_style = (environment == :production) ? :compressed : :expanded
if environment != :production
  enable_sourcemaps = true
  sass_options = {:sourcemap => true}
end

