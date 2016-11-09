/* global module */
module.exports = function(grunt) {

  grunt.loadNpmTasks('grunt-rigger');

  grunt.initConfig({
    meta: {},
	
	compass: {
      dist: {
        options: {
          config: 'config.rb',
          sourcemap: true
        }
      }
    },
	
    rig: {
      plugins: {
        src: [
			'js/plugins/plugins.js',
			'js/plugins/**.js'
		],
        dest: 'js/plugins.js'
      }
    },
	
	jshint: {
      options: {
        jshintrc: true
      },
      all: ['Gruntfile.js', 'js/main.js']
    },
	
	uglify: {
      options: {
        preserveComments: 'some',
        sourceMap: true
      },
      plugins: {
        src: 'js/plugins.js',
        dest: 'js/plugins.min.js'
      }
    },
  
  });

  grunt.registerTask('default', 'rig');
};



