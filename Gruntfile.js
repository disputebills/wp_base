module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				mangle: false
			},
			my_target: {
				files: {
					'js/main.min.js': ['js/main.js'],
					'js/plugins.min.js': ['js/plugins.js']
				}
			}
		},
		svgmin: {
			options: {
				plugins: [
					{ removeViewBox: false },
					{ removeUselessStrokeAndFill: true },
					{ removeEmptyAttrs: false },
					{ removeUnknownsAndDefaults: false },
					{ cleanupIDs: false }
				]
			},
			dist: {
				expand: true,
				cwd: 'svg',
				src: ['*.svg'],
				dest: 'svg/o'
			}
		},
		svgstore: {
			options: {
				prefix : 'icon-', // This will prefix each ID
				svg: {
					viewBox : '0 0 100 100',
					xmlns: 'http://www.w3.org/2000/svg',
					style: "display: none;"
				}
			},
			default: {
				files: {
					"parts/svg-defs.php": ["svg/*.svg"]
				}
			},
		},
		sass: {
			dist: {
				options: {
					style: 'compressed',
					//sourcemap: 'none'
				},
				files: {
					'css/main.css': 'scss/main.scss'
				}
			}
		},
		autoprefixer: {
			options: {
				// Task-specific options go here.
				browsers: ['last 2 version', 'safari 5.1', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'],
				map: true
			},
			single_file: {
				// Target-specific file lists and/or options go here.
				src: 'css/main.css',
				dest: 'style.css'
			},
		},

		imagemin: {
      options: {
        optimizationLevel: 3,
        progressive: true
      },
	    dynamic: {
	      files: [{
	        expand: true,
	        cwd: 'images',
	        src: ['**/*.{png,jpg,gif}'],
	        dest: 'images'
	      }]
	    }
	  },

		watch: {
			options: {
				livereload: 1337,
			},
			files: ['scss/**/*','js/main.js','js/plugins.js','svg/*','images/*','**/*.php'],
			tasks: 'default',
		},
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-svgmin');
	grunt.loadNpmTasks('grunt-svgstore');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-imagemin');

	grunt.registerTask('default', ['svgmin','svgstore','sass','autoprefixer','uglify']);

	grunt.registerTask('images', ['imagemin']);


};
