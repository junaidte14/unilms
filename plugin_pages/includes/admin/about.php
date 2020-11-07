<?php 
$args = array( 
	'post_type' => 'uni_lms_courses',
	'posts_per_page' => -1
);
$loop = new WP_Query( $args );
$total_courses = $loop->found_posts;

$args1 = array( 
	'post_type' => 'uni_lms_classes',
	'posts_per_page' => -1
);
$loop1 = new WP_Query( $args1 );
$total_classes = $loop1->found_posts;

$args2 = array( 
	'post_type' => 'uni_lms_students',
	'posts_per_page' => -1
);
$loop2 = new WP_Query( $args2 );
$total_students = $loop2->found_posts;

$args3 = array( 
	'post_type' => 'uni_lms_course_files',
	'posts_per_page' => -1
);
$loop3 = new WP_Query( $args3 );
$total_course_files = $loop3->found_posts;

$args4 = array( 
	'post_type' => 'uni_lms_lectures',
	'posts_per_page' => -1
);
$loop4 = new WP_Query( $args4 );
$total_lectures = $loop4->found_posts;

$args5 = array( 
	'post_type' => 'uni_lms_attendances',
	'posts_per_page' => -1
);
$loop5 = new WP_Query( $args5 );
$total_attendances = $loop5->found_posts;

$args6 = array( 
	'post_type' => 'uni_lms_quizzes',
	'posts_per_page' => -1,
	'meta_query' => array(
        array(
            'key' => 'quiz_type',
            'value' => 'class_quiz',
            'compare' => '=',
            'type' => 'CHAR'       
        )
    )
);
$loop6 = new WP_Query( $args6 );
$total_quizzes = $loop6->found_posts;

$args7 = array( 
	'post_type' => 'uni_lms_quizzes',
	'posts_per_page' => -1,
	'meta_query' => array(
        array(
            'key' => 'quiz_type',
            'value' => 'class_assignment',
            'compare' => '=',
            'type' => 'CHAR'       
        )
    )
);
$loop7 = new WP_Query( $args7 );
$total_assignments = $loop7->found_posts;

?>

<h2><?php _e('UniLMS Dashboard', 'unilms');?></h2>
<div class="wrap">

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2 class="hndle"><span><?php esc_attr_e( 'UniLMS Home', 'unilms' ); ?></span></h2>

						<div class="inside">
							<p>
								<?php 
									esc_attr_e(
										'Welcome to UniLMS!',
										'unilms'
									); 
								?>
							</p>
							<p>
								<?php 
									esc_attr_e(
										'A learning management system developed
										for universities, schools, colleges, academies or any other
											type of institutes.',
										'unilms'
									); 
								?>
							</p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h2 class="hndle"><span><?php esc_attr_e( 'UniLMS Features', 'unilms' ); ?></span></h2>

						<div class="inside">
							<a href="https://codoplex.com/product/unilms-a-learning-management-wordpress-plugin/" target="_blank">GET PRO VERSION</a>
							<ol>
								<li>
									<strong><?php esc_attr_e('Students Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Students can register to the website as a standard user',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can approve student profile by reviewing it and assigning him UniLMS Student role by editing his/her profile',	'unilms');?></li>
										<li><?php esc_attr_e('Once a student is assigned UniLMS Student role, then he/she can login to the website and add/edit details like department, class, registration number etc. by visiting profile page in the backend of website',	'unilms');?></li>
										<li><?php esc_attr_e('After adding details in profile, user can visit Student Dashboard page which is automatically created when UniLMS plugin is activated',	'unilms');?></li>
										<li><?php esc_attr_e('At Student Dashboard page, student can see his/her information and also he/she can view results of all activities (quizzes, assignments, mid term, final term, final result etc.)',	'unilms');?></li>
										<li><?php esc_attr_e('Each student is assigned to particular class',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Classes Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Admin can add new classes or update/delete existing ones',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can assign courses to each class',	'unilms');?></li>
										<li><?php esc_attr_e('Classes archive and single pages can also be viewed from front end of the website',	'unilms');?></li>
										<li><?php esc_attr_e('Classes archive page lists all classes with class details like (session, semester, fall/spring)',	'unilms');?></li>
										<li><?php esc_attr_e('Any student can view each class details from front end of website',	'unilms');?></li>
										<li><?php esc_attr_e('Classes can be duplicated if they share most of the content',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Courses Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Admin can create, edit, delete courses',	'unilms');?></li>
										<li><?php esc_attr_e('When UniLMS plugin is activated, then a new page titled UNILMS Courses is automatically created which lists all courses in a tabular form',	'unilms');?></li>
										<li><?php esc_attr_e('Courses can be duplicated if they share most of the content',	'unilms');?></li>
										<li><?php esc_attr_e('Each course can be assigned to a class',	'unilms');?></li>
										<li><?php esc_attr_e('Course contents, of the course, are generated using the lectures and activities created by the admin',	'unilms');?></li>
										<li><?php esc_attr_e('Course author can define sessional marks %, mid term exam %, final term exam % and grad policy etc.',	'unilms');?></li>
										<li><?php esc_attr_e('Course archive and single pages can be viewed publically from front end of the website',	'unilms');?></li>
										<li><?php esc_attr_e('Course archive page lists all courses',	'unilms');?></li>
										<li><?php esc_attr_e('Course single page shows all details of course like course description, course contents',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Lectures Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Admin can create, edit and delete lectures',	'unilms');?></li>
										<li><?php esc_attr_e('These lectures can be added to the course contents of the course',	'unilms');?></li>
										<li><?php esc_attr_e('Each lecture is assigned to particular course',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can share all necessary details or resource materials with each lecture',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Activities Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Activities include quizzes, assignments, mid term exam, final term exam, projects, class participation etc.',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can select whether this activity will count in sessionals marks or not',	'unilms');?></li>
										<li><?php esc_attr_e("Each activity's marks can be added for each student",	'unilms');?></li>
										<li><?php esc_attr_e('These activities can be viewed publically. On public pages of these activities, details like activity max marks, submission date, or activity result is shown',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Attendances Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Admin can create new attendance',	'unilms');?></li>
										<li><?php esc_attr_e('Attendance date, class, course, activity and students list to mark attendance are some of the options available',	'unilms');?></li>
										<li><?php esc_attr_e('Attendances are used while preparing course files or to give attendance marks to the students',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Course Files Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Course files includes grading policy, course contents, course plan, instructor log, student log, quizzes, assignments, sessionals, mid term exam, final term exam, attendance sheet and final result of that course',	'unilms');?></li>
										<li><?php esc_attr_e('Each course file part is automatically generated by specifying class and course',	'unilms');?></li>
										<li><?php esc_attr_e('Each course file can also be seen publically on front side of the website',	'unilms');?></li>
										<li><?php esc_attr_e('Archive page and single page of each course file are publically visible to anyone',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can printout each part of course file from admin or front end side of the website',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Teachers / Faculty Members Module (PRO)',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Teacher registration page is automatically created when UniLMS plugin is activated',	'unilms');?></li>
										<li><?php esc_attr_e('Teacher can edit his/her profile by logging in to the backend of website and visiting profile menu',	'unilms');?></li>
										<li><?php esc_attr_e('All teachers/faculty members list page is automatically created when UniLMS plugin is activated',	'unilms');?></li>
										<li><?php esc_attr_e('Individual teacher/faculty member profile page is also automatically created when UniLMS plugin is activated',	'unilms');?></li>
										<li><?php esc_attr_e('Teacher can add/edit contact and social media information by visiting profile page in backend of website',	'unilms');?></li>
										<li><?php esc_attr_e("Public profile page shows teacher's contact and social media details as well as a list of courses assigned to the teacher",	'unilms');?></li>
										<li><?php esc_attr_e('Teacher can create/edit new courses, lectures, activities(quizzes, assignments, mid term exam, final term exam, projects and add marks for these activites), questions, attendances, course files and students',	'unilms');?></li>
										<li><?php esc_attr_e('Teacher can print out all activites, courses, lectures or course files by visiting the public pages of them',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can also add teachers manually',	'unilms');?></li>
										<li><?php esc_attr_e('Admin has complete access to all the content created by the teacher',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can assign a course to a particular teacher',	'unilms');?></li>
										<li><?php esc_attr_e('When a teacher registers to the website, then he/she cannot login to the website until admin approves it',	'unilms');?></li>
										<li><?php esc_attr_e('Content created by teachers is not published until admin reviews it',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Time Tables Module (PRO)',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Admin can generate random time table automatically',	'unilms');?></li>
										<li><?php esc_attr_e('Time table can be generated from courses, classes and faculty members added inside UniLMS plugin',	'unilms');?></li>
										<li><?php esc_attr_e('Admin can also generate custom time table for custom courses, classes and faculty members',	'unilms');?></li>
										<li><?php esc_attr_e('Time slots, day slots and room slots are defined for each time table',	'unilms');?></li>
										<li><?php esc_attr_e('Time table also shows empty slots which can be used to arrange supplementary classes',	'unilms');?></li>
										<li><?php esc_attr_e('Time tables can also be shown publically so that students can see their time table by visiting website',	'unilms');?></li>
									</ol>
								</li>
								<li>
									<strong><?php esc_attr_e('Settings Module',	'unilms');?></strong>
									<ol>
										<li><?php esc_attr_e('Admin can define institute logo which can be used while printing course files or any other documents',	'unilms');?></li>
									</ol>
								</li>
							</ol>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2 class="hndle">
							<span>
								<?php esc_attr_e('Stats', 'unilms'); ?>
							</span>
						</h2>

						<div class="inside">
							<strong><?php _e('Total Students:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_students);?></p>
							<strong><?php _e('Total Courses:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_courses);?></p>
							<strong><?php _e('Total Course Files:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_course_files);?></p>
							<strong><?php _e('Total Classes:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_classes);?></p>
							<strong><?php _e('Total Lectures:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_lectures);?></p>
							<strong><?php _e('Total Attendances:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_attendances);?></p>
							<strong><?php _e('Total Quizzes:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_quizzes);?></p>
							<strong><?php _e('Total Assignments:', 'unilms'); ?></strong>
							<p><?php echo esc_html($total_assignments);?></p>
							
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->