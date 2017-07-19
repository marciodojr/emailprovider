module.exports = function (grunt) {
    grunt.initConfig({
        clean: ['public/css/*.min.css', 'public/img/', 'public/js/*.min.js'],
        browserify: {
            dist: {
                files: [{
                    expand: true,       // Enable dynamic expansion.
                    cwd: 'assets/js/',  // Source Path
                    src: ['*.js'],      // Actual pattern(s) to match.
                    dest: 'public/js',  // Destination folder
                    ext: '.js',         // Dest filepaths will have this extension.
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
                    src: ['**/*.js', '!**/*.min.js'],
                    cwd: 'public/js',
                    dest: 'public/js',
                    ext: '.min.js'
                }]
            }
        },
        sass: {
            // this is the "dev" Sass config used with "grunt watch" command
            // dev: {
            //     options: {
            //         style: 'expanded',
            //         // tell Sass to look in the Bootstrap stylesheets directory when compiling,
            //         // it is also possible to use an array.
            //         loadPath: 'node_modules/bootstrap-sass/assets/stylesheets'
            //     },
            //     files: {
            //         // the first path is the output and the second is the input
            //         'css/index.css': 'assets/sass/index.scss'
            //     }
            // },
            // this is the "production" Sass config used with the "grunt buildcss" command
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
                src: ['node_modules/bootstrap-sass/assets/fonts/bootstrap/*'],
                dest: 'public/fonts/',
                filter: 'isFile'
            }
        },
        // configure the "grunt watch" task
        watch: {
            sass: {
                files: 'assets/sass/*.scss',
                tasks: ['sass:dist']
            },
            browserify: {
                files: 'assets/js/**',
                tasks: ['browserify:dist', 'uglify']
            },
			copy: {
				files: 'assets/img/**',
				tasks: ['copy:images']
			}
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['clean', 'browserify:dist', 'uglify', 'copy', 'sass:dist']);
    grunt.registerTask('production', ['clean', 'browserify', 'uglify', 'copy', 'sass:dist']);
};
