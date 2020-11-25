<?php
/*create shortcode to display student dashboard*/
function uni_lms_student_dash_shortcode_std() {
	global $current_user;
	$current_user_id = get_current_user_id();
	ob_start();
	if($current_user_id != 0){
		$profile_pic = get_avatar_url( $current_user_id);
	    ?>
	    <style>
	    .uni_lms_teacher_profile .col-container {
		    display: block; 
		    width: 100%; /* Set full-width to expand the whole page */
		}
		
		.uni_lms_teacher_profile .prof-pic{
			text-align: center;
		}

		.uni_lms_teacher_profile .prof-pic img{
			max-width: 200px;
			max-height: 200px;
			border-radius: 50%;
		}

		.uni_lms_teacher_profile .prof-det{
			text-align: center;
		}    

		.uni_lms_card button:hover, .uni_lms_card a:hover {
		    opacity: 0.7;
		}

		/* Style the tab */
		.uni_lms_course_tabs {
		    overflow: hidden;
		    border: 1px solid #ccc;
		    background-color: #f1f1f1;
		}

		/* Style the buttons inside the tab */
		.uni_lms_course_tabs button {
		    background-color: inherit;
		    float: left;
		    border: none;
		    outline: none;
		    cursor: pointer;
		    padding: 14px 16px;
		    transition: 0.3s;
		}

		/* Change background color of buttons on hover */
		.uni_lms_course_tabs button:hover {
		    background-color: #ddd;
		}

		/* Create an active/current tablink class */
		.uni_lms_course_tabs button.active {
		    background-color: #ccc;
		}

		.uni_lms_course_tabs br {
		    display: none;
		}

		/* Style the tab content */
		.uni_lms_course_tabcontent {
		    display: none;
		    padding: 6px 12px;
		    border: 1px solid #ccc;
		    border-top: none;
		}

		.uni_lms_course_tabs .tablinks{
		    color: #000;
		}

		.widefat th{
			text-align: left;
		}

	    </style>
	    <div class="uni_lms_teacher_profile">
	    	<div class="col-container">
				<div class="profile-banner">
					<div class="prof-pic">
						<img src="<?php echo $profile_pic;?>" alt="Student Profile Pic">
					</div>
					<div class="prof-det">
						<?php if ( get_the_author_meta( 'display_name', $current_user_id ) ) { ?>
							<h1 class="display_name title clear">
								<?php the_author_meta( 'display_name', $current_user_id ); ?>
							</h1>
						<?php }?>
					</div>
				</div>

				<div class="uni_lms_course_tabs">
	              <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_overview')"><?php _e('Overview', 'unilms');?></button>
	              <button class="tablinks" onclick="openCourseSections(event, 'course_contents')"><?php _e('Results', 'unilms');?></button>
	            </div>
	            <div id="course_overview" class="uni_lms_course_tabcontent">
	                <?php if ( get_the_author_meta( 'uni_lms_dpt', $current_user_id ) ) { ?>
						<p class="uni_lms_dpt clear">
							<strong><?php _e('Department:', 'unilms');?></strong> <?php the_author_meta( 'uni_lms_dpt', $current_user_id ); ?>
						</p>
					<?php }?>
					<?php if ( get_the_author_meta( 'uni_lms_class', $current_user_id ) ) { ?>
						<p class="uni_lms_class clear">
							<strong><?php _e('Class:', 'unilms');?></strong> <?php echo get_the_title( get_the_author_meta( 'uni_lms_class', $current_user_id ) ); ?>
						</p>
					<?php }?>
					<?php if ( get_the_author_meta( 'uni_lms_reg_no', $current_user_id ) ) { ?>
						<p class="uni_lms_reg_no clear">
							<strong><?php _e('Registration No:', 'unilms');?></strong> <?php the_author_meta( 'uni_lms_reg_no', $current_user_id ); ?>
						</p>
					<?php }?>
					
	            </div>
	            <div id="course_contents" class="uni_lms_course_tabcontent">
	            	<?php 
	            	$student_reg_no = get_the_author_meta( 'uni_lms_reg_no', $current_user_id );
	                $class_id = intval(get_the_author_meta( 'uni_lms_class', $current_user_id ));
		            $courses_args = array( 
	                    'post_type' => 'uni_lms_courses',
	                    'posts_per_page' => -1,
	                    'orderby'        => 'title',
	                    'order'          => 'ASC'
	                );
	                $courses_loop = new WP_Query( $courses_args );
	                
	                while ( $courses_loop->have_posts() ) : $courses_loop->the_post();
	                    
	                    $class_course = get_post_meta( $class_id, 'uni_lms_class_course-'.get_the_ID(), true );
	                    $course_title = get_the_title();
	                    if($class_course == "yes"):
	                    	$course_id = get_the_ID();
			                ?>
			                <h3><?php printf(__('Quizzes Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
			                <?php 
			                
			                if($student_reg_no != "" && $class_id != 0){
			                	include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_quizzes.php');
			                }
			                ?>
			                <h3><?php printf(__('Assignments Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
			                <?php 
			                $student_reg_no = get_the_author_meta( 'uni_lms_reg_no', $current_user_id );
			                $class_id = intval(get_the_author_meta( 'uni_lms_class', $current_user_id ));
			                if($student_reg_no != "" && $class_id != 0){
			                	include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_assignments.php');
			                }
			                ?>
			                <h3><?php printf(__('Attendances for (%s)', 'unilms'), esc_html($course_title));?></h3>
			                <?php 
			                $student_reg_no = get_the_author_meta( 'uni_lms_reg_no', $current_user_id );
			                $class_id = intval(get_the_author_meta( 'uni_lms_class', $current_user_id ));
			                if($student_reg_no != "" && $class_id != 0){
			                	include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_attendance.php');
			                }
			                ?>
			                <h3><?php printf(__('Mid Term Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
			                <?php 
			                $student_reg_no = get_the_author_meta( 'uni_lms_reg_no', $current_user_id );
			                $class_id = intval(get_the_author_meta( 'uni_lms_class', $current_user_id ));
			                if($student_reg_no != "" && $class_id != 0){
			                	include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_mid_term.php');
			                }
			                ?>
			                <h3><?php printf(__('Final Term Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
			                <?php 
			                $student_reg_no = get_the_author_meta( 'uni_lms_reg_no', $current_user_id );
			                $class_id = intval(get_the_author_meta( 'uni_lms_class', $current_user_id ));
			                if($student_reg_no != "" && $class_id != 0){
			                	include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_term.php');
			                }
			                ?>
			                <h3><?php printf(__('Final Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
			                <?php 
			                $student_reg_no = get_the_author_meta( 'uni_lms_reg_no', $current_user_id );
			                $class_id = intval(get_the_author_meta( 'uni_lms_class', $current_user_id ));
			                if($student_reg_no != "" && $class_id != 0){
			                	include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_result.php');
			                }
			                ?>
	                <?php
	                	endif;
	                endwhile;
	            	?>
	                
	            </div>

			</div>

		</div>

		<script>
		document.getElementById("course-default-tab").click();

		function openCourseSections(evt, courseSection) {
		    // Declare all variables
		    var i, tabcontent, tablinks;

		    // Get all elements with class="tabcontent" and hide them
		    tabcontent = document.getElementsByClassName("uni_lms_course_tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }

		    // Get all elements with class="tablinks" and remove the class "active"
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }

		    // Show the current tab, and add an "active" class to the button that opened the tab
		    document.getElementById(courseSection).style.display = "block";
		    evt.currentTarget.className += " active";
		}
		</script>
    <?php
	}else{
		_e('Sorry! No data to show', 'unilms');
	}
	return ob_get_clean();
}
add_shortcode( 'uni_lms_student_dashboard', 'uni_lms_student_dash_shortcode_std' );

//adding extra fields for student profile in profile edit page:
add_action( 'show_user_profile', 'uni_lms_show_extra_profile_fields_student_std' );
add_action( 'edit_user_profile', 'uni_lms_show_extra_profile_fields_student_std' );

function uni_lms_show_extra_profile_fields_student_std( $user ) { 
	global $user_ID;
 
    if ( current_user_can( 'uni_lms_student' ) || current_user_can('administrator') ) {
       
	?>

	<h3><?php _e('Student profile information', 'unilms');?></h3>

	<table class="form-table">
		<tr><th><?php _e('Educational Details', 'unilms');?></th></tr>
		<tr>
			<th><label for="uni_lms_dpt"><?php _e('Department', 'unilms');?></label></th>

			<td>
				<input type="text" name="uni_lms_dpt" id="uni_lms_dpt" value="<?php echo esc_attr( get_the_author_meta( 'uni_lms_dpt', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter the department.', 'unilms');?></span>
			</td>
		</tr>

		<tr>
			<th><label for="uni_lms_class"><?php _e('Class', 'unilms');?></label></th>

			<td>
				<?php
				$curr_class = get_the_author_meta( 'uni_lms_class', $user->ID ); 
                $args = array( 
                    'post_type' => 'uni_lms_classes',
                    'posts_per_page' => -1
                    );
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_class">
                    <option value="" <?php if($curr_class == 0){echo 'selected';}?> ><?php _e('Select Class', 'unilms');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($curr_class == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <span class="description"><?php _e('Please select class.', 'unilms');?></span>
                <?php 
                }else{
                    _e('No classes created by admin yet!','unilms');
                }
                ?>
			</td>
		</tr>

		<tr>
			<th><label for="uni_lms_reg_no"><?php _e('Registration No (Complete)', 'unilms');?></label></th>
			<td>
				<input type="text" name="uni_lms_reg_no" id="uni_lms_reg_no" value="<?php echo esc_attr( get_the_author_meta( 'uni_lms_reg_no', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter complete registration number.', 'unilms');?></span>
			</td>
		</tr>

	</table>
<?php }

}

add_action( 'personal_options_update', 'uni_lms_save_extra_profile_fields_student_std' );
add_action( 'edit_user_profile_update', 'uni_lms_save_extra_profile_fields_student_std' );

function uni_lms_save_extra_profile_fields_student_std( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	if(isset($_POST['uni_lms_dpt'])){
		update_user_meta( $user_id, 'uni_lms_dpt', sanitize_text_field($_POST['uni_lms_dpt']) );	
	}
	if(isset($_POST['uni_lms_class'])){
		update_user_meta( $user_id, 'uni_lms_class', intval($_POST['uni_lms_class']) );
	}
	if(isset($_POST['uni_lms_reg_no'])){
		update_user_meta( $user_id, 'uni_lms_reg_no', sanitize_text_field($_POST['uni_lms_reg_no']) );
	}
}
?>