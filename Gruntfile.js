module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		concat: {
			options: {
				separator: ';'
			},
			dist: {
				src: ['public/js/**/*.js'],
				dest: 'public/assets/js/<%= pkg.name %>.js'
			}
		},

		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
			},
			dist: {
				files: {
					'dist/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
				}
			}
		},

		qunit: {
			files: ['test/**/*.html']
		},

		jshint: {
			files: ['Gruntfile.js', 'public/js/**/*.js', 'public/test/**/*.js'],
			options: {
				// options here to override JSHint defaults
				globals: {
					jQuery: true,
					console: true,
					module: true,
					document: true
				}
			}
		},

		clean: {
			all: {
				files: [
					// Delete all files except for all *.jpg and *.png in the imgs subdirectory
					{
						src: ['public/assets/**", "!public/assets/imgs/**/*.jpg", "!public/assets/imgs/**/*.png'],
						filter: 'isFile'
					},
					// Delete some specific directories (and all their contents)
					{
						src: ['public/assets/css', 'public/assets/js']
					}
				]
			}
		},

		less: {
			dev: {
				files: {
					"public/assets/css/styles.css": "public/less/styles.less"
				}
			},
			prod: {
				options: {
					cleancss: true,
					yuicompress: true
				},
				files: {
					"public/assets/css/styles.min.css": "public/less/styles.less"
				}
			}
		},

		watch: {
			files: ['<%= jshint.files %>', 'public/less/**/*.less'],
			tasks: ['clean:all', 'less']
		}
	});

	// grunt.loadNpmTasks('grunt-contrib-uglify');
	// grunt.loadNpmTasks('grunt-contrib-jshint');
	// grunt.loadNpmTasks('grunt-contrib-qunit');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-less');

	//grunt.registerTask('test', ['jshint', 'qunit']);
	//grunt.registerTask('default', ['jshint', 'qunit', 'concat', 'uglify']);
	grunt.registerTask('default', ['clean:all', 'less']);
};