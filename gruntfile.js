module.exports = function (grunt) {
    grunt.initConfig({
        browserify: {
            dist: {
                files: [{
                    expand: true,        // Enable dynamic expansion.
                    cwd: 'assets/js/',   // Source Path
                    src: ['*.js'],       // Actual pattern(s) to match.
                    dest: 'public/pjs',  // Destination folder
                    ext: '.js',          // Dest filepaths will have this extension.
                }],
                options: {
                    transform: [
                        [
                            'babelify',
                            {presets: ["es2015"]}
                        ]
                    ],
                    browserifyOptions: {
                        debug: false
                    }
                }
            },
			dev: {
                files: [{
                    expand: true,       // Enable dynamic expansion.
                    cwd: 'assets/js/',  // Source Path
                    src: ['*.js'],      // Actual pattern(s) to match.
                    dest: 'public/js',  // Destination folder
                    ext: '.min.js',     // Dest filepaths will have this extension.
                }],
                options: {
                    transform: [['babelify', { presets: "es2015" }]],
                    browserifyOptions: {
                        debug: true
                    }
                }
            }
        },
        uglify: {
            options: {
                banner: '/*! Grunt Uglify <%= grunt.template.today("yyyy-mm-dd") %> */ ',
                sourceMap: false
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
                    outputStyle: 'compressed',
                    sourceMap: false,
                    noCache: true
                },
                files: [{
                    expand: true,
                    cwd: 'assets/sass',
                    src: ['*.scss'],
                    dest: 'public/css',
                    ext: '.min.css'
                }]
            },
            dev: {
                options: {
                    outputStyle: 'expanded',
                    sourceMap: false,
                    update: true
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
                files: 'assets/sass/*',
                tasks: ['newer:sass:dev']
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
                    bin: 'php',
                    hostname: 'localhost',
                    port: 3000,
                    base: 'public',
                    keepAlive: false,
                    open: false
                }
            },
            test: {
                options: {
                    bin: 'php',
                    hostname: 'localhost',
                    port: 4000,
                    base: 'public',
                    keepAlive: true,
                    open: true
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
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-php');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-newer');
    grunt.registerTask('dev', ['browserify:dev', 'copy', 'sass:dev', 'php:dist', 'browserSync:dist', 'watch']);
    grunt.registerTask('build', ['browserify:dist', 'uglify', 'copy', 'sass:dist']);
    grunt.registerTask('test', ['build', 'php:test', 'watch']);
};
