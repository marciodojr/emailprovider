module.exports = function (grunt) {
    grunt.initConfig({
        clean: {
            build: ['public/css/*.min.css', 'public/img/', 'public/js/*.min.js'],
            release: ['public/pjs/']
        },
        browserify: {
            dist: {
                files: [{
                    expand: true,       // Enable dynamic expansion.
                    cwd: 'assets/js/',  // Source Path
                    src: ['*.js'],      // Actual pattern(s) to match.
                    dest: 'public/pjs',  // Destination folder
                    ext: '.js',         // Dest filepaths will have this extension.
                }]
            },
			dev: {
                files: [{
                    expand: true,       // Enable dynamic expansion.
                    cwd: 'assets/js/',  // Source Path
                    src: ['*.js'],      // Actual pattern(s) to match.
                    dest: 'public/js',  // Destination folder
                    ext: '.min.js',         // Dest filepaths will have this extension.
                }]
            }
        },
        uglify: {
            options: {
                banner: '/*! Grunt Uglify <%= grunt.template.today("yyyy-mm-dd") %> */ ',
                sourceMap: true,
				sourceMapIncludeSources: true
            },
            build: {
                files: [{
                    expand: true,
                    src: ['*.js'],
                    cwd: 'public/pjs',
                    dest: 'public/js',
                    ext: '.min.js'
                }]
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'compressed',
                    loadPath: 'node_modules/bootstrap-sass/assets/stylesheets'
                },
                files: [{
                    expand: true,
                    cwd: 'assets/sass',
                    src: ['*.scss'],
                    dest: 'public/css',
                    ext: '.min.css'
                }]
            }
        },
        copy: {
            images: {
                expand: true,
                cwd: 'assets/img/',
                src: ['**/*.{png,jpg,svg}'],
                dest: 'public/img/'
            },
            fonts: {
                expand: true,
                flatten: true,
                src: [
                    'node_modules/bootstrap-sass/assets/fonts/bootstrap/*',
                    'node_modules/font-awesome/fonts/*',
                    'assets/fonts/*'
                ],
                dest: 'public/fonts/',
                filter: 'isFile'
            }
        },
        // configure the "grunt watch" task
        watch: {
            sass: {
                files: 'assets/sass/**',
                tasks: ['newer:sass:dist']
            },
            browserify: {
                files: 'assets/js/*',
                tasks: ['newer:browserify:dev']
            },
			copy: {
				files: 'assets/img/**',
				tasks: ['newer:copy:images', 'newer:copy:fonts']
			}
        },
        php: {
            dist: {
                options: {
                    bin: '/usr/bin/php',
                    hostname: 'localhost',
                    port: 3000,
                    base: 'public',
                    keepAlive: false,
                    open: false
                }
            }
        },
        browserSync: {
            dist: {
                bsFiles: {
                    src: [
                        'public/css/*',
                        'public/fonts/*',
                        'public/img/**',
                        'public/js/**',
                        'app/**/*.php'
                    ]
                },
                options: {
                    proxy: '<%= php.dist.options.hostname %>:<%= php.dist.options.port %>',
                    watchTask: true,
                    notify: true,
                    open: true,
                    logLevel: 'silent',
                    ghostMode: {
                        clicks: true,
                        scroll: true,
                        links: true,
                        forms: true
                    }
                }
            }
        },
        newer: {
          options: {
            override: function(detail, include) {
                if (detail.task === "sass") {
                    include(true);
                } else {
                    include(false);
                }
            }
          }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-php');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-newer');
    grunt.registerTask('dev', ['clean:build', 'browserify:dev', 'copy', 'sass:dist', 'php:dist', 'browserSync:dist', 'watch']);
    grunt.registerTask('build', ['clean:build', 'browserify:dist', 'uglify', 'copy', 'sass:dist', 'clean:release']);
};
