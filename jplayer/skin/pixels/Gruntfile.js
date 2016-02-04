/*jshint node:true */

module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			build: [
				'js/*.js',
				'!js/*.min.js',
				'!js/vendor/*.js'
			],
			grunt: {
				options: {
					jshintrc: '.jshintnoderc'
				},
				src: [ 'Gruntfile.js' ]
			}
		},
		less: {
			files: {
				src: 'less/style.less',
				dest: 'css/style.css'
			}
		},
		pixrem: {
			files: {
				src: 'css/style.css',
				dest: 'css/style.css'
			}
		},
		postcss: {
			options: {
				processors: [
					require('autoprefixer')({
						browsers: [ '> 1%', 'last 2 versions', 'ff 17', 'opera 12.1', 'android 4' ],
						cascade: false
					})
				]
			},
			files: {
				src: 'css/style.css'
			}
		},
		watch: {
			css: {
				options: {
					debounceDelay: 500,
					livereload: true
				},
				files: [ 'style.css' ],
				tasks: [ 'pixrem', 'postcss' ]
			},
			less: {
				files: [
					'less/*.less',
					'less/**/*.less'
				],
				tasks: [ 'less' ]
			}
		}
	});

	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-less' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-pixrem' );
	grunt.loadNpmTasks( 'grunt-postcss' );

	grunt.registerTask( 'default', ['build'] );

	grunt.registerTask( 'build', ['jshint', 'less', 'pixrem', 'postcss'] );
};
